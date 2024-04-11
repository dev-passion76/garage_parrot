<?php
require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';
require_once '../lib/bib_general.php';
require_once '../bibappli/lib_metier.php';
require_once '../lib_page/header.php';
require_once '../class/classUtilisateur.php';
require_once '../class/classVehicule.php';

if (isset($_SESSION['clUser']))
    $clUser = unserialize($_SESSION['clUser']);
else
    $clUser = null;

// permet de tester que la page a bien été validé par POST de formulaire via la balise action du form
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // pour des raisons de sécurité, une page peut être appelé soit par le site, soit nativement par un pirate
    // sauf si l'on recontrole sur le serveur qu'il est bien authentifié et ADMIn alors OK sinon dommage pour le hackeur
    if ($clUser) {
        /**
         * Section d'analyse sur la partie retour ajax du changement de statut du véhicule
         * @var unknown $codeMarque
         */
        $fct = POST::get("fct");
        if ($fct !=null && $fct="changeStatut"){
            $idxVehicule  = POST::get('idxVehicule');
            $statut = POST::get("statut");
            
            Vehicule::modifierStatus($pdo,$idxVehicule,$statut);
            exit;
        }
        $codeMarque  = POST::get('code_marque');
        $description = POST::get('description');
        $prix        = POST::get('prix');
        $annee_circulation = POST::get('prix');
        $km = POST::get('km');
        $url_img = POST::get('url_img');

        /**
         * Cette instuction permet de savoir où la page  est stocké sur le serveur
         * @var Ambiguous $docRoot
         */
        $docRoot = $_SERVER['CONTEXT_DOCUMENT_ROOT'];
        
        /**
         * On va creer la variable qui localise les images des vehicules sous assets\photos_vehicules
         */
        
        $docReperImage = $docRoot.'\assets\photos_vehicules';
        
        // type => application/pdf
        
        /**
         *  <form action="vehicule.php" method="POST" enctype="multipart/form-data" id="formulaire_identification">
         *  
         *  dans le formulaire : enctype="multipart/form-data"
         *  permet l'acquisition dans $_FILES qui est un array des fichiers envoyés par le client sur le serveur via la balise <input type="file"
         */
        

        if (isset($_FILES['url_img'])){
            $files = $_FILES['url_img'];
        }
        else{
            $files = null;
        }
            
        /**
         * Test d'existence de donnée
         */
        if ($files == null || ! is_array($files)) 
            $message = "L'ajout de la photo est obligatoire";
        else
        if ($files['error']!=0)
            $message = "Fichier de trop grande taille ou incorrect";
        else
        if ($codeMarque == null || $codeMarque == '')
            $message = "La saisie de la marque est obligatoire";
        else
        if ($description == null || $description == '')
            $message = "La saisie de la description est obligatoire";
        else
        if ($prix == null || $prix == '')
            $message = "La saisie du prix est obligatoire";
        else
        if ($annee_circulation == null || $annee_circulation == '')
            $message = "La saisie de l'année de circulation est obligatoire";
        else
        if ($km == null || $km == '')
            $message = "La saisie du kilométrage est obligatoire";
        else
            if ($files['type']=='image/jpeg' || $files['type']=='image/png' || $files['type']=='image/jpg'){
            
            $nomFichierImage = $files['name'];
            if (move_uploaded_file($files['tmp_name'], $docReperImage.'\\'.$nomFichierImage)){
                if (Vehicule::ajoute($pdo,$codeMarque,$description,$prix,$annee_circulation,$km,$nomFichierImage)){
                    $message = "Bravo, vehicule insérere";
                }
                else
                    $message = "Echec, anomalie insetion base de donnéee";
            }
            else
                $message = "Echec, lors de la prise du fichier image";
        }
        else{
            $message = "Format du fichier image incorrect";
        }
    }
    else
        $message = "Accès à la page non autorisé";
}

// Si l'objet de session n'existe pas ou que l'utilisateur connecté n'est pas admin alors retour sur la page d'index
if ($clUser == null)
{
    header("Location:index.php");
    exit;
}
?>
<body>
	<div>
<?php
// Affichage de la liste des utilisateurs, pour l'administrateur

$vehicule = new Vehicule();
$allVehicule = $vehicule->getListe($pdo);
// test si existance d'au moins un utilisateur via le retour de la demande qui peut renvoyer null
if ($allVehicule) {
    ?>
	<div class="tbl">
			<div>Liste des véhicules</div>
			<table>
				<tr>
					<td>Marque</td>
					<td>Description</td>
					<td>Prix</td>
					<td>Année Ciculation</td>
					<td>Km</td>
					<td>Fcihier Image</td>
					<td>Action</td>
					<td>Statut</td>
				</tr>
            <?php
            foreach ($allVehicule as $raw) {
        ?>
                <tr>
					<td title="<?=$raw['code_marque']?>"><?=$raw['libelle']?></td>
					<td><?=$raw['description']?></td>
					<td><?=$raw['prix']?></td>
					<td><?=$raw['annee_circulation']?></td>
					<td><?=$raw['km']?></td>
					<td><?=$raw['url_img']?></td>
					<td>
						<a href="?action=M&index=<?= urlencode($raw['idx_vehicule'])?>">Modif</a>
						<a href="?action=S&index=<?= urlencode($raw['idx_vehicule'])?>">Supp.</a>
					</td>
					<td>
						<select name="statut" onchange="ClassWorkFlow.changeStatut(this,<?=$raw['idx_vehicule']?>)">
						<?php
						foreach (Vehicule::getListeStatut() as $key => $value) {
						echo "<option value='$key'".($raw['status']==$key ? " selected" : "").">".htmlentities($value);
						echo "</option>";
						}
						$raw['status']
						?>
						</select>
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
		<form action="vehicule.php" method="POST" enctype="multipart/form-data" id="formulaire_identification">
			<div class="clFormSaisie">
			<?php if (isset($message)) { ?>
                <div style="color:red;">
                    <?= $message ?>
                </div>
            <?php } ?>
			
				<div>
					<label for="id_code_marque">Marque&nbsp;:</label> 
					
						<!-- <input type="text" id="id_code_marque" name="code_marque" placeholder="Code Marque" value="<?=(isset($codeMarque)?  $codeMarque : '')?>" /> -->
            			<select name="code_marque" id="id_code_marque">
							<option value="Selection">Sélectionnez votre marque</option>
                                <?php $sql = "select * from marque ".
                                              "where exists(select * from vehicule ".
                                               "where vehicule.code_marque = marque.code)";
                                      $reqMarque = DbAccess::getRequeteSql($pdo,$sql);
                                      foreach($reqMarque as $raw){ 
                                ?>
                            <option value="<?=$raw["code"]?>" <?= (isset($codeMarque) && $raw["code"] == $codeMarque ? " selected" : "")?>  ><?=$raw["libelle"]?></option>  
                            <?php } ?>
        			    </select>
				</div>
				<div>
					<label for="id_description">Description&nbsp;:</label> <input
						type="text" id="id_description" name="description"
						placeholder="Description"
						value="<?=(isset($description) ? $description: '')?>" />
				</div>
				<div>
					<label for="id_prix">Prix&nbsp;:</label> <input type="text"
						name="prix" id="id_prix" placeholder="Prix"
						value="<?=(isset($prix) ? $prix : '')?>" />
				</div>
				<div>
					<label for="id_prenom">Année de circulation&nbsp;:</label> <input
						type="text" id="id_annee_circulation" name="annee_circulation"
						placeholder="Année de circulation"
						value="<?=(isset($annee_circulation) ? $annee_circulation : '')?>" />
				</div>
				<div>
					<label for="id_km">Km&nbsp;:</label> <input type="text" name="km"
						id="id_km" placeholder="Km" value="<?=(isset($km) ? $km : '')?>" />
				</div>
				<div>
					<label for="id_url_img">Url Img&nbsp;:</label> <input type="file"
						name="url_img" id="id_url_img" placeholder="Image" value="<?=(isset($url_img) ? $url_img : '')?>" />
				</div>
				<div class="button">
					<label></label> <input type="submit" value="Envoyer" />
				</div>
			</div>
		</form>
<?php
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/plugins/bootstrap.bundle.min.js"></script>
    <script src="js/sandrine.js"></script>
</body>
</html>
