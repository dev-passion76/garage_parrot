<?php 
/**
 *  Quelques règles genérales
 *  en fait, on met souvent en haut de la page les tests php notamment dans le cas de création de connexion ou autre
 *  en effet 
 *    1 on affiche une page pour que l'utilisateur saisisse de l'information que l'on va ensuite soumettre
 *    2 donc c'est au debut de l'appel de la nouvelle page que l'on va intercepté les données pour les traiters et ensuite affiché un écran approprié
 */
// Vérifie si les identifiants ont été soumis
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Remplacer informations par celles de ma base de données
    $db_username = 'votre_nom_utilisateur';
    $db_password = 'votre_mot_de_passe';

    // Récupére les identifiants soumis par l'utilisateur
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Vérifie si les identifiants sont corrects
    if ($input_username === $db_username && $input_password === $db_password) {
        // Authentification réussie, créer une session
        $_SESSION['logged_in'] = true;
        header('Location: page_admin.php'); // Redirige vers la page d'administration
        exit();
    } else {
        echo 'Identifiants incorrects. Veuillez réessayer.';
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion employés</title>
</head>
<body>
    
<!-- Formaulaire de connexion admin -->

 <h2>Connexion employés</h2>
    <form action="authentification.php" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Se connecter">
<?php
require_once '../lib_page/footer.php';

?>
</body>
</html>