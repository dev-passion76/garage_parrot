<?php
require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';
require_once '../lib/bib_composant_affiche.php';

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
        <img
        src="assets/image-voiture garage removebg-preview.png"
        alt="Logo du garage"
        width="530"
        class="d-inline-block align-text-top"
        />
        <br /><h1 class="garage-text" style="color: #531424"
        >Garage V.Parrot</h1>
      </a>     
      </div>
    </div>
  </nav>

<div class="container text-center">
  <div class="row">
        <div class="col-sm-6 col-no-rel">
            <div class="annonce_img">
                <a class="annonce_img_c" href="#" data-index="0">
                    <img src="assets/photos_vehicules/<?= $reqVehicule['url_img']?>" alt="FIAT 1.0 70ch BSG S&amp;S Cult" title="FIAT 1.0 70ch"> <!-- Lorsque je sup BSG S&amp;S Cult ça ne produit rien -->
                </a>
                <div class="annonce_badges">          
                  <div class="move-bottom">
                    <div class="annonce_services">
                      <div class="annonce_service bb">
                        <div class="container container_inside">
                            <div class="row">
                                <div class="col-xs-6">
                                </div>    
                              </div>
                                <div class="col-xs-6">
                                    </a>
                                </div>
                        </div>
                                <!-- Informations générales -->
                                <div class="clear"></div>
                                <div class="col-xs-6">
                                    <a href="#" class="annonce_un_service">
                                        <span class="icon-waxoyl"></span>
                                    </a>
                                </div>
                            </div>
                        </div> 
                    </div>
                  </div>
                    <div class="separateur"></div>

                <div class="annonce_services">
                    <div class="annonce_service">
                        <h4>Points de contrôles</h4>
                        <div class="container container_inside">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>
                                        <strong class="primary very-big">103</strong>
                                    </p>

                                    <p><strong>
                                    points de contrôles ont été réalisés sur cette voiture</strong></p>
                                </div>

                                <div class="col-xs-8">
                                    <p>Les éventuelles pièces endommagées ont été remplacées, l’intérieur est nettoyé de fond en comble, et la carrosserie rajeunie.</p>

                                    <p>Le certificat d’état et d’origine de cette occasion, vous sera remis lors de la livraison.</p>

                                    <p>N’hésitez pas à nous contacter afin de connaitre l’origine de ce véhicule, les points de contrôle réalisés ainsi que les pièces remplacées sur ce véhicule.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                                    </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="intro">
                <h1><?= $reqVehicule['description']?></h1>
                <p class="modele_subtitle">1.0 70ch BSG S&amp;S Cult</p>
                
            </div>

            
            <div class="well">
                <div class="row">
                    <div class="col-sm-7">
                        <p class="prix"><?= afficheMontant($reqVehicule['prix'])?>&nbsp;€</p>
                        <p>
                            <span class="adresse_coordonnees_adresse"><strong>Toulouse</strong><br>6 rue Alexi-Larrey><br>31000 TOULOUSE</span><br>
                            <span class="icon-mobile"></span> 09 00 00 00 00 </a>
                        </p>
                      </div>
                    </div>
                </div>
                    </div>
                
            </div>
            <div class="fiche_droite">
                <div class="">
                    <h2>Informations générales&nbsp;<span class="badge">Réf. : 5572</span></h2>
                    <div class="row">
                        <div class="col-xs-6">
                            <table class="table">
                                <tbody><tr>
                                    <td>Année</td>
                                    <td>2020</td>
                                </tr>

                                <tr>
                                    <td>Energie</td>
                                    <td>Essence</td>
                                </tr>

                                <tr>
                                    <td>Garantie</td>
                                    <td>12 mois</td>
                                </tr>

                                <tr>
                                    <td>Emission CO2</td>
                                    <td>107 g/km</td>
                                </tr>

                                <tr>
                                    <td>Crit'Air</td>
                                    <td>1 
                            </tbody></table>
                        </div>
                    </div>
                </div>
            </div>

            <p>&nbsp;</p>


        </div>
    </div>

  <div>
  <div class="container-page">
<?php 

?>
  </div>	
  <div
  class="shadow-sm mb-6 bg-body bg-custom height-custom text-center"
  style="font-size: 2em; position: relative;">
          <div class="card-front">
            <p><strong>Reprise<br></strong>de votre véhicule</p>
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
