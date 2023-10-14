<?php

require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../lib/bib_general.php';

require_once '../bibappli/lib_metier.php';

require_once '../lib_page/header.php';

require_once '../class/classUser.php';

if (isset($_SESSION['clUser']))
    $clUser = unserialize($_SESSION['clUser']);
else
    $clUser = null;
    
// permet de tester que la page a bien été validé par POST de formulaire via la balise action du form
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    // pour des raisons de sécurité, une page peut être appelé soit par le site, soit nativement par un pirate
    // sauf si l'on recontrole sur le serveur qu'il est bien authentifié et ADMIn alors OK sinon dommage pour le hackeur
    if ($clUser){
        $user = $_SESSION['userConnect'];
        if($clUser->isAdmin()) {
            $identifiant = POST::get('identifiant');
            $mot_de_passe = POST::get('mot_de_passe');
            $nom = POST::get('nom');
            $prenom = POST::get('prenom');
            $type_utilisateur = POST::get('type_utilisateur');
            
            // L'on doit verifier que l'identifiant saisie n'existe pas déjà

            if ($identifiant== null || $identifiant == '')
                $mes = "La saisie de l'identifiant est obligatoire";
            else
            if ($mot_de_passe == null || $mot_de_passe == '')
                $mes = "La saisie du mot de passe est obligatoire";
            else
            if ($nom == null || $nom == '')
                $mes = "La saisie du nom est obligatoire";
            else
            if ($prenom == null || $prenom == '')
                $mes = "La saisie du prenom est obligatoire";
            else
            if ($type_utilisateur == null || ! ($type_utilisateur == 'A' && $type_utilisateur == 'E'))
                $mes = "La saisie du type d'utilisateur est obligatoire";
             else{
                $sql = "select * from utilisateur where identifiant = ".$pdo->quote($identifiant);
    
                $utilisateur = DbAccess::canFind($pdo,$sql);
    
                if ($utilisateur){
                    $message = "Utilisateur déjà existant";
                }
                else{
                    // Insertion en base de données
    
                    if ($clUser->ajouteUtilisateur($identifiant,$mot_de_passe,$nom,$prenom,$type_utilisateur))
                        $message = "Bravo, vous venez de créer un nouvel utilisateur";
                    else 
                        $message = "Erreur lors de l'ajout de l'utilisateur";
                }
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
                <td><?=$user['nom']?></td>
                <td><?=$user['prenom']?></td>
                <td><?=$user['type_utilisateur']?></td>
            </tr>
        <?php
            }
        ?>
    </table>
<?php } ?>
<!-- Permet de savoir si un utilisateur s'est authentifié et que ce dernier et admin, donc je lui donne l'autorisation de créer ... AINSI l'ensemble du html FORM ci-dessous n'est pas envoyé au poste client-->
<?php
if ($clUser){    
    if($clUser->isAdmin()) {
?>
<form action="utilisateur.php" method="POST" id="formulaire_identification">
    <!--
        la ligne ci-dessous test l'existance de la variable $identifiant 
            si OUI alors affiche $identiant
            SINON '' donc rien
        syntaxe : (<test> ? reponse OUI : reponse NON     )
        <?=(isset($identifiant)?  $identifiant : '')?> 
    -->
    <input type="text" name="identifiant" placeholder="Identifiant"   value="<?=(isset($identifiant)?  $identifiant : '')?>"/>
    <input type="text" name="mot_de_passe" placeholder="Mot de passe" value="<?=(isset($mot_de_passe) ? $mot_de_passe : '')?>"/>
    <input type="text" name="mot_de_passe" placeholder="Nom" value="<?=(isset($prenom) ? $prenom : '')?>"/>
    <input type="text" name="mot_de_passe" placeholder="Prénom" value="<?=(isset($com) ? $nom : '')?>"/>
    <select name="type_utilisateur">
    	<option value="">Votre choix</option>
    	<option value="A">Admin</option>
    	<option value="E">Employe</option>
    </select>
    <input type="submit" value="Envoyer"/>
</form>
<?php
// TEST1
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
