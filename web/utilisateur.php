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
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // pour des raisons de sécurité, une page peut être appelé soit par le site, soit nativement par un pirate
    // sauf si l'on recontrole sur le serveur qu'il est bien authentifié et ADMIn alors OK sinon dommage pour le hackeur
    if ($clUser) {
        if ($clUser->isAdmin()) {
            $identifiant = POST::get('identifiant');
            $mot_de_passe = POST::get('mot_de_passe');
            $nom = POST::get('nom');
            $prenom = POST::get('prenom');
            $type_utilisateur = POST::get('type_utilisateur');

            // L'on doit verifier que l'identifiant saisie n'existe pas déjà
            if ($identifiant == null || $identifiant == '')
                $message = "La saisie de l'identifiant est obligatoire";
            else if ($mot_de_passe == null || $mot_de_passe == '')
                $message = "La saisie du mot de passe est obligatoire";
            else if ($nom == null || $nom == '')
                $message = "La saisie du nom est obligatoire";
            else if ($prenom == null || $prenom == '')
                $message = "La saisie du prenom est obligatoire";
            else if ($type_utilisateur == null || ! ($type_utilisateur == 'A' || $type_utilisateur == 'E'))
                $message = "La saisie du type d'utilisateur est obligatoire";
            else {
                $sql = "select * from utilisateur where identifiant = " . $pdo->quote($identifiant);

                $utilisateur = DbAccess::canFind($pdo, $sql);

                if ($utilisateur) {
                    $message = "Utilisateur déjà existant";
                } else {
                    // Insertion en base de données

                    if ($clUser->ajouteUtilisateur($pdo, $identifiant, $mot_de_passe, $nom, $prenom, $type_utilisateur))
                        $message = "Bravo, vous venez de créer un nouvel utilisateur";
                    else
                        $message = "Erreur lors de l'ajout de l'utilisateur";
                }
            }
        }
        else
            $message = "Cette page est réservé à l'administrateur du site";
    }
    else
        $message = "Accès à la page non autorisé";
}

// Si l'objet de session n'existe pas ou que l'utilisateur connecté n'est pas admin alors retour sur la page d'index
if ($clUser == null || ! $clUser->isAdmin() )
{
    header("Location:index2.php");
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

$allUser = $clUser->getListeUtilisateur($pdo);
// test si existance d'au moins un utilisateur via le retour de la demande qui peut renvoyer null
if ($allUser) {
    ?>
	<div class="tbl">
			<div>Liste des utilisateurs</div>
			<table>
				<tr>
					<td>Identifiant</td>
					<td>Nom</td>
					<td>Prenom</td>
					<td>Type Utilisateur</td>
					<td>Action</td>
				</tr>
            <?php
    foreach ($allUser as $user) {
        ?>
                <tr>
					<td><?=$user['identifiant']?></td>
					<td><?=$user['nom']?></td>
					<td><?=$user['prenom']?></td>
					<td><?=$user['type_utilisateur']?></td>
					<td>
						
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
        ?>
		<form action="utilisateur.php" method="POST" id="formulaire_identification">
			<div class="clFormSaisie">
				<div>
					<label for="id_identifiant">Identifiant&nbsp;:</label> 
						<input type="text" id="id_identifiant" name="identifiant" placeholder="Identifiant"
						value="<?=(isset($identifiant)?  $identifiant : '')?>" />
				</div>
				<div>
					<label for="id_mot_de_passe">Mot de passe&nbsp;:</label> 
						<input type="text" id="id_mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" value="<?=(isset($mot_de_passe) ? $mot_de_passe : '')?>" />
				</div>
				<div>
					<label for="id_nom">Nom&nbsp;:</label> 
						<input type="text" name="nom" id="id_nom" placeholder="Nom" value="<?=(isset($prenom) ? $nom : '')?>" />
				</div>
				<div>
					<label for="id_prenom">Prénom&nbsp;:</label> <input
						type="text" id="id_prenom" name="prenom"
						placeholder="Prénom" value="<?=(isset($prenom) ? $prenom : '')?>" />
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
        // TEST1
    }
}
?>
</div>
<div>
	<a href="index2.php">Retour</a>
</div>
    <?php
    require_once '../lib_page/footer.php';
    ?>
<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
