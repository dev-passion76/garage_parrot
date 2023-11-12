<?php
require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

require_once '../lib_page/header.php';

require_once '../class/classUtilisateur.php';

require_once '../class/classTemoignage.php';

/**
 * L'instantiation de la clsse utilisateur est juste là
 * pour vérifier que pour accéder à la gestion je suis au moins connecté
 * et comme il existe uniquement 2 professionnel Admin et Employé
 * par la peine de tester le type d'utilisateur connecté
 */
if (isset($_SESSION['clUser']))
    $clUser = unserialize($_SESSION['clUser']);
else
    $clUser = null;

$actionGlobal = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // pour des raisons de sécurité, une page peut être appelé soit par le site, soit nativement par un pirate
    // sauf si l'on recontrole sur le serveur qu'il est bien authentifié et ADMIn alors OK sinon dommage pour le hackeur
    if ($clUser) {        
        $action = POST::get('action');
        $idxTemoignage = POST::get('idx_temoignage');

        // L'on doit verifier que l'identifiant saisie n'existe pas déjà
    }
    else
        $message = "Accès à la page non autorisé";
}

if (! isset($action)) $action = '';

// Si l'objet de session n'existe pas ou que l'utilisateur connecté n'est pas admin alors retour sur la page d'index
if ($clUser == null)
{
    header("Location:index.php");
    exit;
}
?>
<body>
	<div>
<?php if (isset($message)) { ?>
    <div>
        <?= $message ?>
    </div>
<?php } ?>

<?php
// Affichage de la liste des utilisateurs, pour l'administrateur

$allUser = $clUser->getListe($pdo);
// test si existance d'au moins un utilisateur via le retour de la demande qui peut renvoyer null
if ($allUser) {
    ?>
	<div class="tbl">
			<div>
				<div>Liste des utilisateurs</div>
				<div><a href="?action=A">Créer</a></div>
			</div>
			<table>
				<tr>
					<td>Identifiant</td>
					<td>Nom</td>
					<td>Prenom</td>
					<td>Type Utilisateur</td>
					<td>Action</td>
				</tr>
            <?php foreach ($allUser as $user) { ?>
                <tr>
					<td><?=$user['identifiant']?></td>
					<td><?=$user['nom']?></td>
					<td><?=$user['prenom']?></td>
					<td><?=$user['type_utilisateur']?></td>
					<td>
						<a href="?action=M&index=<?= urlencode($user['identifiant'])?>">Modif</a>
						<a href="?action=S&index=<?= urlencode($user['identifiant'])?>">Supp.</a>
					</td>
				</tr>
            <?php
    }
    ?>
        </table>
		</div>
<?php } ?>
<!-- Permet de savoir si un utilisateur s'est authentifié et que ce dernier et admin, donc je lui donne l'autorisation de créer ... AINSI l'ensemble du html FORM ci-dessous n'est pas envoyé au poste client-->
<?php
if ($clUser) {
    if ($clUser->isAdmin()) {
        if ($action == 'C'){
            
        }
        else{
        ?>
		<form action="utilisateur.php" method="POST" id="formulaire_identification">
			<div class="clFormSaisie">
				<input type="hidden" name="action" value="<?=$action?>"/>
				<div>
					<label for="id_identifiant">Identifiant&nbsp;:</label>
					<?php if ($action == 'A'){ ?> 
						<input type="text" id="id_identifiant" name="identifiant" placeholder="Identifiant"
						value="<?=htmlentities(isset($identifiant)?  $identifiant : '')?>" />
					<?php } ?>
					<?php if ($action == 'M'){ ?>
						<input type="hidden" name="identifiant" value="<?=htmlentities($identifiant)?>"/>
						<?=htmlentities($identifiant)?>
					<?php } ?>
				</div>
				<div>
					<label for="id_mot_de_passe">Mot de passe&nbsp;:</label> 
						<input type="password" id="id_mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" value="<?=htmlentities(isset($mot_de_passe) ? $mot_de_passe : '')?>" />
				</div>
				<div>
					<label for="id_nom">Nom&nbsp;:</label> 
						<input type="text" name="nom" id="id_nom" placeholder="Nom" value="<?=htmlentities(isset($nom) ? $nom : '')?>" />
				</div>
				<div>
					<label for="id_prenom">Prénom&nbsp;:</label> <input
						type="text" id="id_prenom" name="prenom"
						placeholder="Prénom" value="<?=htmlentities(isset($prenom) ? $prenom : '')?>" />
				</div>
				<div>
					<label for="id_type_utilisateur">Type Utilisateur&nbsp;:</label> 
						<select name="type_utilisateur" id="id_type_utilisateur">
						<option value="">Votre choix</option>
						<option value="A" <?= (isset($type_utilisateur) && $type_utilisateur=="A" ? " selected" : '') ?>>Admin</option>
						<option value="E" <?= (isset($type_utilisateur) && $type_utilisateur=="E" ? " selected" : '') ?>>Employe</option>
					</select>
				</div>
				<div class="button">
					<label></label>
					<input type="submit" value="Envoyer" />
				</div>
			</div>
		</form>
<?php
        }
    }
}
?>
</div>
<div>
	<a href="index.php">Retour</a>
</div>
    <?php
    require_once '../lib_page/footer.php';
    ?>
<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
