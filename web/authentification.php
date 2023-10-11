<?php
require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';
require_once '../lib/bib_composant_affiche.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['username']))
        $identifiant = $_POST['username'];
    else
        $identifiant = null;

    if (isset($_POST['password']))
        $mot_de_passe = $_POST['password'];
    else
        $mot_de_passe = null;

    // $pdo->quote TOUJOURS UTILISE pour des zones NON NUMERIQUE (ex varchar, date ...) Contre les injections SQL, sauf pour les booléennes
    $sql = "select * from utilisateur ".
            "where identifiant = ".$pdo->quote($identifiant)." and mdp = ".$pdo->quote($mot_de_passe);
    $reponse = DbAccess::canFind($pdo, $sql);
    if ($reponse){
        // utilisateur OK
        $okConnect = 1;
        // Donc va enregister dans la session les informations de la connexion utilisateur
        $_SESSION['userConnect'] = $reponse;
    }
    else{
        $okConnect = 0;
    }
}
require_once '../lib_page/header.php';
?><body>
<?php if (isset($okConnect)) {?>
    <div>
        <?= ($okConnect ? "OK" : "FUCK") ?>  
    </div>
<?php }?>

<?php
require_once '../lib_page/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>