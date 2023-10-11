<?php

require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

require_once '../lib_page/header.php';

// permet de tester que la page a bien été validé par POST de formulaire via la balise action du form
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    // pour des raisons de sécurité, une page peut être appelé soit par le site, soit nativement par un pirate
    // sauf si l'on recontrole sur le serveur qu'il est bien authentifié et ADMIn alors OK sinon dommage pour le hackeur
    if (isset($_SESSION['userConnect'])){
        $user = $_SESSION['userConnect'];
        if ($user['type_utilisateur'] == 'A'){

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
<!-- Permet de savoir si un utilisateur s'est authentifié et que ce dernier et admin, donc je lui donne l'autorisation de créer ... AINSI l'ensemble du html FORM ci-dessous n'est pas envoyé au poste client-->
<?php
 if (isset($_SESSION['userConnect'])){
    $user = $_SESSION['userConnect'];
    if ($user['type_utilisateur'] == 'A'){
?>
<!-- <form action="utilisateur.php" method="POST" id="formulaire_identification"> -->
    <!--
        la ligne ci-dessous test l'existance de la variable $identifiant 
            si OUI alors affiche $identiant
            SINON '' donc rien
        syntaxe : (<test> ? reponse OUI : reponse NON     )
        <?=(isset($identifiant)?  $identifiant : '')?> 
    -->
    <input type="text" name="identifiant" placeholder="Identifiant"   value="<?=(isset($identifiant)?  $identifiant : '')?>"/>
    <input type="text" name="mot_de_passe" placeholder="Mot de passe" value="<?=(isset($mot_de_passe) ? $mot_de_passe : '')?>"/>
    <input type="submit" value="Envoyer"/>
</form>
<?php
//
    }
 }
?>
    <?php
//require_once '../lib_page/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
