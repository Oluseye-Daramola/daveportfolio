<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

header('Content-Type: text/plain');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid Request";
    exit;
}

$name    = strip_tags(trim($_POST["name"]));
$email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$subject = strip_tags(trim($_POST["subject"]));
$message = strip_tags(trim($_POST["message"]));

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo "All fields are required.";
    exit;
}

$mail = new PHPMailer(true);

try {
    // SMTP Settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // 🔴 ENTER YOUR GMAIL HERE
    $mail->Username   = 'daramolaoluseye22@gmail.com';

    // 🔴 ENTER YOUR GMAIL APP PASSWORD HERE
    $mail->Password   = 'immi elcq xcae pyun';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email setup
    $mail->setFrom('daramolaoluseye22@gmail.com', 'Website Contact Form');
    $mail->addAddress('daramolaoluseye22@gmail.com'); 

    $mail->Subject = "New Contact Message: $subject";
    $mail->Body    = 
"Name: $name
Email: $email
Subject: $subject

Message:
$message";

    if ($mail->send()) {
        echo "OK";
    } else {
        echo "Failed to send message.";
    }

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
