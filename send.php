<?php
// Form POST ile gelmezse ana sayfaya gönder
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

// Form alanlarını al
$name    = trim($_POST["name"] ?? "");
$email   = trim($_POST["email"] ?? "");
$country = trim($_POST["country"] ?? "");
$message = trim($_POST["message"] ?? "");

// Güvenlik için basit filtre
$name    = strip_tags($name);
$email   = filter_var($email, FILTER_SANITIZE_EMAIL);
$country = strip_tags($country);
$message = strip_tags($message);

// Mail ayarları
$to      = "info@aurivaexport.com";  // Hedef mail
$subject = "Auriva Export Web Sitesi Teklif Formu";

$body  = "Web sitesi teklif formundan yeni bir mesaj geldi:\n\n";
$body .= "Ad Soyad : " . $name . "\n";
$body .= "E-posta  : " . $email . "\n";
$body .= "Ülke     : " . $country . "\n\n";
$body .= "Mesaj:\n" . $message . "\n";

// Gönderici bilgisi (hosting mail ayarına göre info adresiniz olmalı)
$headers  = "From: Auriva Export <info@aurivaexport.com>\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Maili gönder
$success = mail($to, $subject, $body, $headers);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Mesaj Durumu | Auriva Export</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; text-align:center; padding:40px;">
  <h1>Auriva Export</h1>

  <?php if ($success): ?>
    <h2>Teşekkürler!</h2>
    <p>Mesajınız başarıyla gönderildi. En kısa sürede sizinle iletişime geçeceğiz.</p>
  <?php else: ?>
    <h2>Bir hata oluştu</h2>
    <p>Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin veya doğrudan
       <a href="mailto:info@aurivaexport.com">info@aurivaexport.com</a> adresine mail gönderin.</p>
  <?php endif; ?>

  <p><a href="index.html#contact">Ana sayfaya geri dön</a></p>
</body>
</html>
