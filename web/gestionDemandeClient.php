<?php
require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

require_once '../lib_page/header.php';

require_once '../class/classUtilisateur.php';

require_once '../class/classClientDemande.php';

if (isset($_SESSION['clUser']))
    $clUser = unserialize($_SESSION['clUser']);
else
    $clUser = null;

// permet de tester que la page a bien été validé par POST de formulaire via la balise action du form

/**
 * Cette variable va devoir 4 possibilité de statut
 * A ajouter
 * M modifier
 * S supprimer
 * C consulter
 * 
 * @var string 
 Global
 */
$actionGlobal = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($clUser) {

    }
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // pour des raisons de sécurité, une page peut être appelé soit par le site, soit nativement par un pirate
    // sauf si l'on recontrole sur le serveur qu'il est bien authentifié et ADMIn alors OK sinon dommage pour le hackeur
    if ($clUser) {

    }
    else
        $message = "Accès à la page non autorisé";
}

if ($clUser == null )
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
// Affichage de la liste des demandes clients donc on fait une instance de la class ClientDemande
$clientDemande = new ClientDemande();

$allDemande = $clientDemande->getListe($pdo);

if ($allDemande) {
    ?>
	<div class="tbl">
			<div>
				<div>Liste des demandes d'informations</div>
			</div>
			<table>
				<tr>
					<td>Nom</td>
					<td>Prenom</td>
				</tr>
            <?php foreach ($allDemande as $raw) { ?>
                <tr>
					<td><?=$raw['nom']?></td>
					<td><?=$raw['prenom']?></td>
					<td>
						<a href="?action=M&index=<?= urlencode($raw['idx_contact_client'])?>">Modif</a>
						<a href="?action=S&index=<?= urlencode($raw['idx_contact_client'])?>">Supp.</a>
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
        if ($actionGlobal == 'C'){
            
        }
        else{
        ?>
		<form action="#" method="POST" id="formulaire">
			<div class="clFormSaisie">
                <!--
				<div class="button">
					<label></label>
					<input type="submit" value="Envoyer" />
				</div>
                -->
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
