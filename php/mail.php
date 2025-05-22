<?php
require __DIR__.'/../vendor/autoload.php';

include_once 'ligaBD.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function send($assunto, $mensagem, $email){

    $mail = new PHPMailer(true);
    try {
        $mail->setLanguage('pt');
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0; // 1 para debug
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'alinemoicas23@gmail.com';
        $mail->Password = 'kdzhohxumfhnqcpc';
        $mail->Port = 587;
        $mail->From = 'alinemoicas23@gmail.com';
        $mail->FromName = 'FeelSync';
        $mail->addAddress($email);
        $mail->addReplyTo($email);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
        echo "Erro ao enviar email: {$mail->ErrorInfo}";
        echo"<div class='alert alert-danger'>Email ou password incorretos!</div>";
    }
}
