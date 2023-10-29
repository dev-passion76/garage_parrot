<?php 
/**
 * Ajout ../lib_ext dans l'include path au cas où il n'y est pas
 */
$chaineAchercher = '../lib_ext';

if (strpos(get_include_path(), $chaineAchercher) === false)
    set_include_path(get_include_path().';'.$chaineAchercher);
    
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

$mail = new PHPMailer;
$mail->isSMTP();

$mail->Host = 'smtp.laposte.net';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAutoTLS = true;
$mail->SMTPDebug = 2;  
// sandrineECF@laposte.net sandrineECF1234&
$mail->Username = 'sandrineECF@laposte.net';
$mail->Password = 'sandrineECF1234&';

/*
$mail->Host = 'smtp.sfr.fr';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAutoTLS = true;
$mail->SMTPDebug = 2;
// sandrineECF@laposte.net sandrineECF1234&
$mail->Username = 'testcnda@sfr.fr';
$mail->Password = 'Adsi2269';
*/

$from = $mail->Username;
$to   = 'emmanuel.de.peretti@gmail.com';

$mail->setFrom($from, $from);
$mail->addAddress($to, 'Emmanuel de Peretti');

$mail->isHTML(false);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->send()) {
    $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
} else {
    $msg = 'Message envoyé ! Merci de nous avoir contactés.';
}
?>