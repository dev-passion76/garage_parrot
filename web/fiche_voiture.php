<?php
require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';
require_once '../lib/bib_composant_affiche.php';
require_once '../bibappli/lib_metier.php';

/**
 * Récuperations infos données
 */
if (isset($_GET['code_vehicule']))
    $codeVehicule = $_GET['code_vehicule'];
else
    $codeVehicule = null;


    //echo $codeMarque;

    $sql = "select * from vehicule where idx_vehicule = $codeVehicule";
    // comme le méthode est static alors on utilise la syntaxe <Nom de la classe>::<Nom de la méthode>
    $reqVehicule = DbAccess::canFind($pdo,$sql);

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
          <img src="assets/image-voiture-garage.png" alt="Logo du garage" width="530" class="d-inline-block align-text-top"/>
          <br /><h1 class="garage-text" style="color: #531424"
          >Garage V.Parrot</h1>
        </a>     
      </div>
    </nav>
  </div>

<!-- Début de la section avec l'image et les informations -->

    <div class="container">
        <div class="content-row">

            <!-- Section Image -->

            <div class="image-section">
              <div class="visuel_conteneur">
                <a href="fiche_voiture.php?code_vehicule=<?= $reqVehicule['idx_vehicule']?>" class="visuel">
                  <img width="400" height="300" class="lazymage loaded" src="assets/photos_vehicules/<?= $reqVehicule['url_img']?>" alt="<?= $reqVehicule['description']?>" title="<?= $reqVehicule['description']?>">
                </a>
              </div>
            </div>

<!-- Section Informations (avec PHP intégré) --> 

<div class="info-section">
    <div class="intro">
        <h1><?= $reqVehicule['description']?></h1>
            <p class="modele_subtitle">1.0 70ch</p>
    </div>
      <div class="row">
        <div class="col-sm-7">
            <p class="prix"><?= afficheMontant($reqVehicule['prix'])?>&nbsp;€</p>
        </div>
      </div>
</div>
  <div class="row">
    <div class="annonce_img">
        <h2>Informations générales&nbsp;</h2> 
        <div class="row">
          <div class="col-xs-6">
              <table class="table">
                  <tbody><tr>
                      <td>Année</td>
                      <td>2020</td>
                      <td>Energie</td>
                      <td>Essence</td>
                      <td>Couleur</td>
                      <td>Jaune métalisé</td>
                      <td>Emission CO2</td>
                      <td>148g/km</td>
                      <td>Crit'Air</td>
                      <td>1</td>
                      <td>Puissance178ch/9CV</td>
                      <td>Kilométrage</td>
                      <td>Manuelle</td>
                  </tr>

                  <?php
                          $chaineRetour = getLibelleProprieteVehicule($pdo,$reqVehicule['idx_vehicule'],'BO');
                  if ($chaineRetour!=null){
                  ?>

                  <tr>
                      <td>Type de boîte</td>
                      <td><?=$chaineRetour?></td>
                  </tr>
                  <?php } ?>
              </tbody></table>
          </div>
        </div>
    </div>
  </div>
</div>
                
            </div>
        </div>
        <div>
          <a href="contact?code_vehicule=<?= $reqVehicule['idx_vehicule']?>" class="btn btn-custom btn-sm btn-block btn-voir">Nous contacter</a>
        </div>
    </div>

<?php
require_once '../lib_page/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
