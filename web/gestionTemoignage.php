<?php
require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

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
        $fonction = POST::get('fct');
        $idxTemoignage = POST::get('idTemoignage');

        if ($fonction=='publie')
            $retour = Temoignage::switchPublic($pdo,$idxTemoignage);
        else
        if ($fonction=='interdit')
            $retour = Temoignage::switchInterdit($pdo,$idxTemoignage);
        else
        if ($fonction=='change')
            $retour = Temoignage::getRaw($pdo,$idxTemoignage);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($retour);

        exit;
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

require_once '../lib_page/header.php';
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

$allData = Temoignage::getListe($pdo);

// test si existance d'au moins un utilisateur via le retour de la demande qui peut renvoyer null
if ($allData) {
    ?>
	<div class="tbl">
			<div>
				<div>Liste des temoignages</div>
				<div><a href="?action=A">Créer</a></div>
			</div>
			<table>
				<tr>
					<td>Nom</td>
					<td>Date de création</td>
					<td>Date de publication</td>
					<td>Publier</td>
					<td>Interdit</td>
				</tr>
            <?php foreach ($allData as $row) { ?>
                <tr onclick="ClassTemoignage.change(this,<?=$row['idx_temoignage']?>)">
					<td><?=$row['nom']?></td>
					<td><?=convDateJJMMAA($row['date_creation'])?></td>
					<td><?=$row['date_publication']?></td>
                    <td onclick="ClassTemoignage.publie(this,<?=$row['idx_temoignage']?>)">
                        <input type="checkbox" <?=($row['is_publie'] ? ' checked' : '')?>/>
                    </td>
                    <td onclick="ClassTemoignage.interdit(this,<?=$row['idx_temoignage']?>)">
                    <div>
                        <input type="checkbox" <?=($row['is_interdit'] ? ' checked' : '')?>/>
                    </div>
                    </td>
				</tr>
            <?php
    }
    ?>
        </table>
        <!-- DEB bloc commentaire de la ligne encours -->
        <div>
            <pre id="idCommentaire">
                <?=$allData[0]['commentaire']?>
            </pre>
        </div>
        <!-- FIN bloc commentaire de la ligne encours -->
		</div>
<?php } ?>
<!-- Permet de savoir si un utilisateur s'est authentifié et que ce dernier et admin, donc je lui donne l'autorisation de créer ... AINSI l'ensemble du html FORM ci-dessous n'est pas envoyé au poste client-->
</div>
<div>
	<a href="index.php">Retour</a>
</div>
    <?php
    require_once '../lib_page/footer.php';
    ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/plugins/bootstrap.bundle.min.js"></script>
    <script src="js/sandrine.js"></script>
</body>
</html>
