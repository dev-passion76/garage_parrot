<?php
require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

require_once '../class/classUtilisateur.php';

require_once '../class/classHoraire.php';

if (isset($_SESSION['clUser'])){
    $clUser = unserialize($_SESSION['clUser']);
    if (! $clUser->isAdmin()){
        header("Location:index.php");
        exit;
    }
}
else{
    $clUser = null;
    header("Location:index.php");
    exit;
}
// permet de tester que la page a bien été validé par POST de formulaire via la balise action du form

/**
 * Cette variable va avoir 4 possibilité de statut
 * A ajouter
 * M modifier
 * S supprimer
 * C consulter
 * 
 * @var string $actionGlobal
 */
$actionGlobal = '';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // pour des raisons de sécurité, une page peut être appelé soit par le site, soit nativement par un pirate
    // sauf si l'on recontrole sur le serveur qu'il est bien authentifié et ADMIn alors OK sinon dommage pour le hackeur
    if ($clUser) {
        if ($clUser->isAdmin()) {
        $fonction = POST::get('fct');
        $jourSemaine = POST::get('jourSemaaine');

        if ($fonction=='ouverture')
            $retour = Horaire::switchOuverture($pdo,$jourSemaine);
        else
        if ($fonction=='modifieHoraire'){
            $zone = POST::get('zone');
            $value = POST::get('value');

            /**
             * On appelle la fonction de mise à jour 
             * qui nous renvoi soit un array de data correspondant à la mise à jour
             * soit null, car la mise à jour n'a pas eu lieu et donc on va envoyer un message
             * que le poste client via jQuery va afficher à l'utilisateur
             */
            $retour = Horaire::modifieHoraire($pdo,$jourSemaine,$zone,$value);
            if ($retour==null){
                $retour = Horaire::getRaw($pdo,$jourSemaine);
                $retour['errorMessage'] = "Saisie invalide";
                $retour['ok'] = 0;
            }
            else
                $retour['ok'] = 1;
        }

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($retour);

        exit;
        }
    }
}

// Si l'objet de session n'existe pas ou que l'utilisateur connecté n'est pas admin alors retour sur la page d'index
if ($clUser == null || ! $clUser->isAdmin() )
{
    header("Location:index.php");
    exit;
}

require_once '../lib_page/header.php';
?>
<body>
	<div>

<?php
// Affichage de la liste des utilisateurs, pour l'administrateur


$requete = Horaire::getListe($pdo);
// test si existance d'au moins un utilisateur via le retour de la demande qui peut renvoyer null
if ($requete) {
    ?>
	<div class="tbl">
			<div>
				<div>Horaires d'ouverture</div>
			</div>
			<table>
				<tr>
					<td rowspan="2">Jour</td>
					<td rowspan="2">Ouvert</td>
					<td colspan="2">Matin</td>
					<td colspan="2">Après midi</td>
				</tr>
				<tr>
					<td>Debut</td>
					<td>Fin</td>
					<td>Debut</td>
					<td>Fin</td>
				</tr>
            <?php foreach ($requete as & $raw) { ?>
                <tr>
					<td><?=GestionDate::$jourSemaine[$raw['jour_semaine']-1]?></td>
					<td onclick="ClassHoraire.ouvertFerme(this,<?=$raw['jour_semaine']?>)">
                        <input type="checkbox" <?=($raw['is_ouvert']==1 ? "checked" : "")?>/>
                    </td>
					<td>
                        <input type="text" name="am_debut" size="5" maxlength="5" value="<?=GestionDate::dateHM($raw['am_debut'])?>"
                            onchange="ClassHoraire.modifieHoraire(this,<?=$raw['jour_semaine']?>)">
                        </input>
                    </td>
					<td>
                        <input type="text" name="am_fin" size="5" maxlength="5" value="<?=GestionDate::dateHM($raw['am_fin'])?>"
                            onchange="ClassHoraire.modifieHoraire(this,<?=$raw['jour_semaine']?>)">
                        </input>
                    </td>
					<td>
                        <input type="text" name="pm_debut" size="5" maxlength="5" value="<?=GestionDate::dateHM($raw['pm_debut'])?>"
                            onchange="ClassHoraire.modifieHoraire(this,<?=$raw['jour_semaine']?>)">
                        </input>
                    </td>
					<td>
                        <input type="text" name="pm_fin" size="5" maxlength="5" value="<?=GestionDate::dateHM($raw['pm_fin'])?>"
                            onchange="ClassHoraire.modifieHoraire(this,<?=$raw['jour_semaine']?>)">
                        </input>
                    </td>
				</tr>
            <?php
    }
    ?>
        </table>
		</div>
<?php } ?>
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
    <script src="js/sandrine.js"></script>
</body>
</html>
