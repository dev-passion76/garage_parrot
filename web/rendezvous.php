<?php
require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';
require_once '../lib/bib_general.php'; 
require_once '../bibappli/lib_metier.php';
require_once '../lib_page/header.php'; 

$success = false;
$messageSuccess = '';
$messageErreur = '';

$nom = '';
$email = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $horaire = $_POST['horaire'] ?? null;
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message = $_POST['message'];
    
    if ($email != strip_tags($email)){
        $messageErreur = 'Votre saisie d\'Adresse mail est incorrecte';
    }
    else
    if (!verifMail($email)) {
        $messageErreur = 'Adresse email non valide. Veuillez réessayer.';
    }
    else{
        // Vérification de la dispo
        $sql = "SELECT * FROM calendrier WHERE horaire = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$horaire]);
        $rendezVous = $stmt->fetch();

        if (!$rendezVous) {

        // Le créneau est libre
            $sqlInsert = "INSERT INTO calendrier (horaire, nom, email, message) VALUES (?, ?, ?, ?)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $success = $stmtInsert->execute([$horaire, $nom, $email, $message]);

            if ($success) {
                $messageSuccess = "Votre rendez-vous a été pris avec succès.";
            } else {
                $messageErreur = "Il y a eu un problème lors de la prise de votre rendez-vous.";
            }
        } else {
            $messageErreur = "Désolé, ce créneau n'est plus disponible. Veuillez en choisir un nouveau";
        }
    }
} else {
    $horaire = $_GET['dateHeure'] ?? null;
}
?>

        <form action="rendezvous.php" method="post">
            <input type="hidden" name="horaire" value="<?= htmlspecialchars($horaire); ?>">
            <input type="text" name="nom" placeholder="Votre nom" value="<?=$nom?>">
            <input type="email" name="email" placeholder="Votre email" value="<?=$email?>">
            <input type="tel" name="tel" placeholder="Votre numéro de téléphone">
            <textarea name="message" id="message" cols="30" rows="10"><?=$message?></textarea>
            <button type="submit">Prendre Rendez-Vous</button>
        </form> 
<?php if ($messageErreur !=''){?>
<td>
    <?= $messageErreur ?>
</td>
<?php } ?>

<?php if ($messageSuccess!=''){?>
<td>
    <?= $messageSuccess ?>
</td>
<?php } ?>
