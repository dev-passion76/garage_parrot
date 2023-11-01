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

/** 
 * A voir dans le futur ce qu'on appelle SPF et DKIM
 * 
 */
$mail = new PHPMailer(true);

$mail->isSMTP();


$mail->Host = 'smtp.laposte.net';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//$mail->SMTPAutoTLS = true;
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
//$to   = 'archi.sandrineblandamour@gmail.com';
$to   = 'archi.sandrineblandamour@gmail.com';

$mail->setFrom($from, $from);
$mail->addAddress($to, $to);
$mail->addReplyTo($from, $from);
$mail->Helo = 'DEV-PC';
//$mail->AuthType = 'LOGIN PLAIN DIGEST-MD5 NTLM XOAUTH2';
$mail->AuthType = 'LOGIN PLAIN';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

$mail->isHTML(false);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->XMailer = null;

if (!$mail->send()) {
    $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
} else {
    $msg = 'Message envoyé ! Merci de nous avoir contactés.';
}
?>