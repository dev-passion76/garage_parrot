<?php
/**
 * Cette bilbliotheque a été crée pour confiner les informations de connexion
 * a la base de donnée en dehors de la visibilité de l'alias du serveur Apache
 * Comme cela si suite a un deny de service qui aurait laisser seulement le serveur apache opérationnel
 * la page brut de php que verrait l'utilisateur n'aura pas les identifiants en base de donnée
 */
require_once '../lib/bib_connect.php';

/**
 * Cette bibliotheque est prevu pour avoir les fonctions de base pour les interrog et mise a jour
 * en base de donnée
 * A savoir interrogation Multi Record et Mone Record
 * Creation / modification / suppression de record
 * Gestion des transactions au sens du Begin transaction et du commit transaction
 *
 */
require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

require_once '../lib_page/header.php';

require_once '../class/classUtilisateur.php';

if (isset($_GET['exit'])){
    session_destroy();
    header("Location:index.php");
    exit;
}
/**
 * Ici on va voir si l'on peut recuperer la session de  l'utilisateur
 */
if (isset($_SESSION['clUser'])){
    $clUser = unserialize($_SESSION['clUser']);
}
else
    $clUser = null;
    ?>
<body>
   <div id="idConnect">
    <?php if ($clUser==null) {?>
   		
    
    
    <?php } else {?>
    	<div>
    		<div>
    			Bonjour <?= $clUser->getUser()['nom'].' '.$clUser->getUser()['prenom']?>
    		</div>
    		<?php if($clUser->isAdmin()) { ?>
    			<div><a href="utilisateur.php">Gestion des utilisateurs</a></div>
    		<?php } ?>
    		<div>
          <a href="vehicule.php">Gestion des vehicules</a>
        </div>		
    		<div>
          <a href="gestionDemandeClient.php">Gestion des demandes d'information</a>
        </div>		
    	</div>
    	<div>	
    		<a href="?exit=1">Deconnexion</a>
    	</div>
    <?php } ?>
  </div>
  <div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="image/site/mercedes_blanche.png" class="d-block w-100" alt="photo slide one">
    </div>
    <div class="carousel-item">
      <img src="assets/honda blanche slider.jpg" class="d-block w-100" alt="photo slide two">
    </div>
    <div class="carousel-item">
      <img src="assets/mini cabriolet slider.jpg" class="d-block w-100" alt="photo slide three">
    </div>
    <div class="carousel-item">
      <img src="assets/Pneumatique slider.jpg" class="d-block w-100" alt="photo slide four">
  </div>
  <div class="carousel-item">
      <img src="assets/réparationn slider.jpg" class="d-block w-100" alt="photo slide five">
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
  </div>
      <div class="profile-icon-container"> 
        <a href="signin.php">
          <img src="image/icone_user.png" alt="Icône de profil" class="profile-icon" style="width: 60px; height: auto;"/>
        </a>
      </div>
  <nav class="navbar navbar-custom">
    <div class="container-fluid d-flex nav-container">
      <div class="divCenter">
        <a class="navbar-brand large-margin" href="index.html">
          <h1 class="garage-text">Garage V.Parrot</h1>
        </a>
        <a href="qui_sommes_nous.php" >
          <span class="garage-text">Qui sommes-nous ?</span>
        </a>
      </div>
      <div class="divCenter">
          <div class="logo-garage">
            <img src="assets/image-voiture-garage.png" alt="Logo du garage">
          </div>
      </div>
    </div>
  </nav>
  <div class="shadow mb-6 bg-body bg-custom text-center">
          <div class="clSelectVehicule">
            <div class="titre">
              <span>TROUVEZ</span> <span>VOTRE PROCHAIN VÉHICULE</span>  
            </div>           
    <!-- Conteneur flex pour les selects -->
    <div class="corps">
        <!-- Premier select -->
        <form action="voitures-occasions.php" method="POST">
            <select name="from_home_modele" id="marque" class="form-control custom-select" onchange="this.form.submit()">

            <option value="Selection">Sélectionnez votre marque</option>
            <?php $sql = "select * from marque ".
                          "where exists(select * from vehicule ".
                                  "where vehicule.code_marque = marque.code)";
                  $reqMarque = DbAccess::getRequeteSql($pdo,$sql);
                  foreach($reqMarque as $raw){ 
            ?>
          <option value="<?=$raw["code"]?>" class="custom-option"><?=$raw["libelle"]?></option>  
          <?php } ?>
          <!-- <option value="ABARTH">ABARTH</option>
              <option value="AUDI">AUDI</option>
              <option value="BMW">BMW</option>
              <option value="FIAT">FIAT</option>
              <option value="FORD">FORD</option>
              <option value="MERCEDES">MERCEDES</option>
              <option value="MINI">MINI</option>
              <option value="PEUGEOT">PEUGEOT</option>
              <option value="RENAULT">RENAULT</option> -->
          </select>

          <!-- Deuxième select -->
          <select name="from_home_modele" id="reparations" class="form-control custom-select">
              <option value="">Réparations</option>
              <?php $reqPrestation = getPrestation($pdo,"RP");
                    foreach($reqPrestation as $raw){ ?>
          <option value="<?=$raw["code"]?>"><?=$raw["libelle"]?></option>  
          <?php } ?> 
              <!-- <option value="carrosserie">Carrosserie</option>
              <option value="mecanique">Mécanique</option>
              <option value="entretien">Entretien</option> -->
          </select>
        </form>
      </div> 
    </div>
  </div>
          <div class="container text-center">
            <div class="clSelectVehicule">
              <div class="titre">
                <div class="clDecouvreVehicule">
                  <div class="titre"><br>
                  <span>DÉCOUVREZ</span> <span>VOTRE PROCHAIN VÉHICULE</span>
                </div>
                <div class="shadow-sm mb-6 bg-body bg-custom text-center">
        <div class="clChoixSelonVeh">
          
        

          <!--BEGIN affichage -->
          <div>
              <div class="titre"><br>
              Nos occasions à moins de 20 000€
              </div>
              <div class="container-page">
              <?php 
              $sql = "select * from vehicule where prix < 20000";
                $reqVehicule = DbAccess::getRequeteSql($pdo,$sql);
                foreach ($reqVehicule as $raw){
                  require '../lib_page/vignette_auto.php'; 
                }
              ?>
              </div>
          </div>
          <!-- END affichage -->
          
          <div>
              <div class="titre"><br>
              Nos occasions récentes à faible KM
              </div>
              <div class="container-page"> 
              <?php 
              $sql = "select * from vehicule where km < 20000";
                $reqVehicule = DbAccess::getRequeteSql($pdo,$sql);
                foreach ($reqVehicule as $raw){
                  require '../lib_page/vignette_auto.php'; 
              }
              ?>
              </div>
          </div>





          </div>
        </div>
      </div>
  </div>
</div>	
</div>


<div class="container text-center">
  <div class="clEngagements">
    <div class="titre">
      <span>NOS</span> <span>ENGAGEMENTS</span>
      
    </div>
  </div>
  <div>    
		<div class="row">
			<div class="card col-sm-3 col-xs-6">
				<div>
						<span class="front">
							<span class="icon-buyback2"></span>

							<strong>Reprise</strong><br>de votre véhicule
						</span>
						<span class="back">
							<p>Proposition de reprise à sans obligation d'achat.</p>

							<p>Nous prenons en charge les formalités administratives.</p>
						</span>
				</div>
			</div>
			<div class="card col-sm-3 col-xs-6">
				<div>
						<span class="front">
							<span class="icon-roole"></span>

							<strong>Protégez votre véhicule</strong><br>et votre budget
						</span>

						<span class="back">
							<p>Rejoindre le club Roole, c’est rejoindre une communauté d’automobilistes visant à rendre la voiture plus simple et plus économique.</p>
						</span>
				</div>
			</div>

			<div class="card col-sm-3 col-xs-6">
				<div>
						<span class="front">
							<span class="icon-warranty-term-svgrepo-com"></span>

							Véhicules<br><strong>contrôlés et garantis</strong>
						</span>

						<span class="back">
							<p>103 points de contrôles</p>

							<p>Le certificat d’état et d’origine de cette occasion, vous sera remis lors de la livraison.</p>
						</span>
				</div>
			</div>

			<div class="card col-sm-3 col-xs-6">
				<div>
						<span class="front">
							<span class="icon-waxoyl"></span>

							<strong>Soignez</strong><br>votre carrosserie
						</span>

						<span class="back">
							<p>Découvrez nos solutions de protection de votre carrosserie et de peinture haute brillance pour que votre nouvelle voiture garde l’aspect du neuf plus longtemps.</p>
						</span>
				</div>
			</div>
		</div>
</div>
<?php
require_once '../lib_page/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
