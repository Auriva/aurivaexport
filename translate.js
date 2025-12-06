const BASE_LANG = "tr";
let translations = {};

// Sayfa yüklenince sözlükleri al ve elemanlara TR metnini kaydet
async function initTranslations() {
    try {
        const res = await fetch("/languages.json");
        translations = await res.json();
    } catch (e) {
        console.error("languages.json yüklenemedi", e);
        return;
    }

    // Tüm elemanlarda tek satırlı text node’ları bul
    document.querySelectorAll("*").forEach(el => {
        if (
            el.childNodes.length === 1 &&
            el.childNodes[0].nodeType === Node.TEXT_NODE
        ) {
            const text = el.innerText.trim();
            if (text) {
                // Orijinal Türkçe metni data attribute olarak kaydediyoruz
                if (!el.dataset.i18nKey) {
                    el.dataset.i18nKey = text;
                }
            }
        }
    });
}

// Dili değiştir
function translatePage(lang) {
    const dict = translations[lang] || translations[BASE_LANG];

    document.querySelectorAll("[data-i18n-key]").forEach(el => {
        const key = el.dataset.i18nKey;
        const newText = dict[key] || key; // Çeviri yoksa Türkçe kalsın
        el.innerText = newText;
    });
}

// Sayfa açılır açılmaz TR referanslarını kaydet
initTranslations();
