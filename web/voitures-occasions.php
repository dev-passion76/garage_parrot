<?php

require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';

require_once '../class/classVehicule.php';
/**
 * Récuperations infos données
 */
if (isset($_POST['from_home_modele']))
    $codeMarque = $_POST['from_home_modele'];
else
    $codeMarque = null;

    //echo $codeMarque;

    $sql = "select * from marque where code = '$codeMarque'";

    //print $sql;
    $reqMarque = DbAccess::getRequeteSql($pdo,$sql);
require_once '../lib_page/header.php';
?><body> 
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
        src="assets/image-voiture-garage.png"
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
            <a class="nav-link nav-item-text" href="#">Qui sommes nous ?</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
  

<div class="container text-center">

  

  <div>
  
  <div class="container-page ">
<?php 
    foreach (Vehicule::requeteVehiculeMarque($pdo,$codeMarque) as $raw){
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
