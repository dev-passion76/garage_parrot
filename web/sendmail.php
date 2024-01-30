<?php 

require_once '../lib/bib_mail.php';

$mail = Mail::getMail();

$from = $mail->Username;
$to   = 'archi.sandrineblandamour@gmail.com';

$mail->setFrom($from, $from);
$mail->addAddress($to, $to);
$mail->addReplyTo($from, $from);

$mail->isHTML(false);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->XMailer = null;

if (!$mail->send()) {
    $msg = 'Une erreur est survenue, veuillez réessayer plus tard.';
} else {
    $msg = 'Message envoyé ! Merci de nous avoir contacté.';
}
?>