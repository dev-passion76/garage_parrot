
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
?>
<body>
  <div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/Mercedes Blanche slider.jpg" class="d-block w-100" alt="photo slide one">
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
  <nav class="navbar navbar-custom">
    <div class="container-fluid d-flex nav-container">
      <a class="navbar-brand large-margin" href="index.html">
        <img
        src="assets/image-voiture garage removebg-preview.png"
        alt="Logo du garage"
        width="530"
        class="d-inline-block align-text-top"
        />
        <br /><h1 class="garage-text" style="color: #531424"
        >Garage V.Parrot</h1>
      </a>
      <div class="d-flex justify-content-center" style="flex-grow: 1">
        <ul class="navbar-nav flex-row centered-nav-items">
          <li class="nav-item me-5">
            <a class="nav-link nav-item-text" href="#">Nos occasions</a>
          </li>
          <li class="nav-item me-5">
            <a class="nav-link nav-item-text ml-6" href="#">Qui sommes-nous ?</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  

<div
  class="shadow-sm mb-6 bg-body bg-custom height-custom text-center"
  style="font-size: 2em; position: relative;"
  >
  TROUVEZ <span style="color: #430d25">VOTRE PROCHAIN VÉHICULE</span>
  
  <!-- Conteneur principal -->
<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">

    <!-- Conteneur flex pour les selects -->
    <div style="display: flex; justify-content: center; align-items: center; gap: 160px;">
      

        <!-- Premier select -->
        <form action="voitures-occasions.php" method="POST"><select name="from_home_modele" id="marque" class="form-control custom-select" onchange="this.form.submit()">

            <option value="Selection">Sélectionnez votre marque</option>
            <?php $sql = "select * from marque ".
                          "where exists(select * from vehicule ".
                                  "where vehicule.code_marque = marque.code)";
                  $reqMarque = getRequeteSql($pdo,$sql);
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
        </form>

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
    </div>
</div>
  </div>

<div class="container text-center">
  <div class="row">
  <class="bg-body height-custom text-center style="font-size: 2em"></class>
    DÉCOUVREZ NOTRE <span style="color: #430d25">SÉLECTION DE VÉHICULE</span> <!-- Ne prend pas la couleur -->
  </div>

  

  <div style="display: flex; justify-content: space-between; align-items: center; gap: 160px;">
  <a href="#" style="flex: 1; margin-top: 85px;" class="custom-link"> <!-- flex: 1; pr que chaque élément occupe l'espace dispo -->
    Nos occasions à moins de 20 000€
  </a>
  <a href="#" style="flex: 1; margin-top: 85px;" class="custom-link"> <!-- Utilisez flex: 1; pour que chaque élément occupe l'espace disponible -->
    Nos occasions récentes à faible KM
  </a>
</div>
  <div>
  
  <div class="container-page">
<?php 
   $sql = "select * from vehicule ";
    $reqVehicule = getRequeteSql($pdo,$sql);
    foreach ($reqVehicule as $raw){
      require '../lib_page/vignette_auto.php'; 
}
?>
  </div>
			
			
  <div
  style="font-size: 2em; position: relative;"
  >NOS <span style="color: #430d25">ENGAGEMENTS</span></div>

  <div
  class="shadow-sm mb-6 bg-body bg-custom height-custom text-center"
  style="font-size: 2em; position: relative;">
  <div class="container">
    <div class="card container">
      <div class="card-wrapper">
        <div class="card">
          <div class="card-front">
            <p><strong>Reprise<br></strong>de votre véhicule</p>
            <div class="card-back">
              <a href="#" class="btn">Proposition de reprise de votre ancien véhicule<br>Nous prenons en charges les démarches administratives</a>
            </div>
          </div>
        </div>
      </div>
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
