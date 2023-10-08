<?php

require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

require_once '../lib_page/header.php';

// permet de tester que la page a bien été validé par POST de forumaire via la balise action du form
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['identifiant']))
        $identifiant = $_POST['identifiant'];
    else
        $identifiant = null;

    if (isset($_POST['mot_de_passe']))
        $mot_de_passe = $_POST['mot_de_passe'];
    else
        $mot_de_passe = null;

    // L'on doit verifier que l'identifiant saisie n'existe pas déjà

    $sql = "select * from utilisateur where identifiant = ".$pdo->quote($identifiant);

    $utilisateur = DbAccess::canFind($pdo,$sql);

    if ($utilisateur){
        $message = "Utilisateur déjà existant";
    }
    else{
        // Insertion en base de données
        $nom = '';
        $prenom =  '';
        $type_utilisateur = '';

        $data = [
            'tidentifiant' => $identifiant,
            'tmdp' => $mot_de_passe,
            'tnom' => $nom,
            'tprenom' => $prenom,
            'ttype_utilisateur' => $type_utilisateur,
        ];
        $sql = "INSERT INTO utilisateur (identifiant,mdp,nom,prenom,type_utilisateur) VALUES (:tidentifiant, :tmdp, :tnom, :tprenom, :ttype_utilisateur)";
        
        $stmt= $pdo->prepare($sql);
        $stmt->execute($data);

        $message = "Bravo, vous venez de créer un nouvel utilisateur";
    }
}
?>
<body>

<?php if (isset($message)) { ?>
    <div>
        <?= $message ?>
    </div>
<?php } ?>

<?php 
    // Affichage de la liste des utilisateurs, pour l'administrateur 
    $sql = "select * from utilisateur ";
    $allUser = DbAccess::getRequeteSql($pdo,$sql);
    // test si existance d'au moins un utilisateur via le retour de la demande qui peut renvoyer null
    if ($allUser)
{ ?>
    <table>
        <?php 
            foreach ($allUser as $user){
        ?>
            <tr>
                <td><?=$user['identifiant']?></td>
            </tr>
        <?php
            }
        ?>
    </table>
<?php } ?>

<form action="utilisateur.php" method="POST">
    <!--
        la ligne ci-dessous test l'existance de la variable $identiant 
            si OUI alors affiche $identiant
            SINON '' doc rien
        syntaxe : (<test> ? reponse OUI : reponse NON     )
        <?=(isset($identifiant)?  $identifiant : '')?> 
    -->
    <input type="text" name="identifiant" placeholder="Identifiant"   value="<?=(isset($identifiant)?  $identifiant : '')?>"/>
    <input type="text" name="mot_de_passe" placeholder="Mot de passe" value="<?=(isset($mot_de_passe) ? $mot_de_passe : '')?>"/>
    <input type="submit" value="Envoyer"/>
</form>
    <?php
//require_once '../lib_page/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
