<?php

require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';
require_once '../class/classHoraire.php';

require_once '../class/classVehicule.php';
/**
 * Récuperations infos données
 */
if (isset($_POST['from_home_reparation']))
    $codeReparation = $_POST['from_home_reparation'];
else
    $codeReparation = null;

    //echo $codeMarque;

    $sql = "select * from prestation where code = '$codeReparation'";

    //print $sql;
    $reqReparation = DbAccess::canFind($pdo,$sql);
    $minutes_to_add = 15;

require_once '../lib_page/header.php';

$sql = "SELECT min(am_debut) as 'am_debut',min(am_fin) as 'am_fin',max(pm_debut) as 'pm_debut',max(pm_fin) as 'pm_fin' FROM garage.horaire";
$reqHoraireGarage = DbAccess::canFind($pdo,$sql);

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
			<div>
          Type de réparation : <?=$reqReparation['libelle']?>
      </div>
      <!--Gestion du calendrier -->
      <div id="idCalend">
        <table>
          <tr>
              <td>
              <?php 
                  $time = new DateTime();
                  // Conversion en UTC
                  $time->setTimezone(new DateTimeZone('Europe/Paris'));
                  $time->setTime(0,0,0,0);

                for ($j=0; $j<30; $j++){?>
                <td>
                  <?php
                  // GestionDate::$jourSemaine[$raw['jour_semaine'] - 1] 
                    $jourSemaine = $time->format('w'); /// Le dimanche est 0
                    //

                    $jourSemaine = (($jourSemaine+6) % 7) ;

                    echo $time->format('M d')." ".substr(GestionDate::$jourSemaine[$jourSemaine],0,1);

                    $time->modify('+1 day');
                  ?>
                </td> 
              <?php } ?>
          </tr>
            <?php 
            
                $debut = substr($reqHoraireGarage['am_debut'],0,2)*60+substr($reqHoraireGarage['am_debut'],3,2);
                $fin   = substr($reqHoraireGarage['am_fin'],0,2)*60+substr($reqHoraireGarage['am_fin'],3,2);
            
                afficheCalendrier($pdo,$debut,$fin,$minutes_to_add);

                $debut = substr($reqHoraireGarage['pm_debut'],0,2)*60+substr($reqHoraireGarage['pm_debut'],3,2);
                $fin   = substr($reqHoraireGarage['pm_fin'],0,2)*60+substr($reqHoraireGarage['pm_fin'],3,2);
            
                afficheCalendrier($pdo,$debut,$fin,$minutes_to_add);

                function afficheCalendrier($pdo,$debut,$fin,$minutes_to_add){
                for ($h=$debut;$h<$fin;$h+=$minutes_to_add) {?> 
                <tr>
                  <td>
                    <?= sprintf("%02d",intdiv($h,60)).':'.sprintf("%02d",$h % 60) ?>
                  </td>
                  <?php 
                  $time = new DateTime();
                  // Conversion en UTC
                  $time->setTimezone(new DateTimeZone('Europe/Paris'));
                  $time->setTime(0,0,0,0);

                  $time->modify("+{$h} minutes");

                  $timeSuite = clone $time;
                  $timeSuite->modify("+{$minutes_to_add} minutes");
                  
                  for ($j=0; $j<30; $j++){?>
                      <?php
                          // 2024-01-07 16:04:47 2024-01-07 08:00
                          $dateTrouve =  $time->format('Y-m-d H:i:s');
                          $dateTrouveSuite =  $timeSuite->format('Y-m-d H:i:s');

                          $sql = "select * from calendrier where '$dateTrouve' <= horaire and horaire <= '$dateTrouveSuite' ";
                          
                          $reqHoraire = DbAccess::canFind($pdo,$sql);

                          //echo "<td class='".($reqHoraire == null ? "clOpen" : "clFerme")."'/>";

                          // Evenement onclick pour pouvoir pdre un rdv (redirigé sur rendezvous)
                          if ($reqHoraire == null) {
                            // onclick='prendreRendezVous(\"$dateTrouve\")'
                            ?>
                              <td class='clOpen'>
                                <a href="rendezvous.php?dateHeure=<?=$dateTrouve?>">
                                </a>
                              </td>
                            <?php
                          } else {
                          echo "<td class='clFerme'></td>";
                          }

                          // Important le décalage de la journée est en bas juste avant le retour de la boucle for
                          $time->modify('+1 day');
                          $timeSuite->modify('+1 day');
                      ?>
                  <?php } ?>
                </tr>
            <?php } 
                }
            
            
            ?>
        <?php

        ?>
        
        </table>
      </div>
  <div style="font-size: 2em; position: relative;">NOS <span style="color: #430d25">ENGAGEMENTS</span></div>

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
<script> // Script JavaScript for onclick 
function prendreRendezVous(dateHeure) {
    window.location.href = 'rendezvous.php?dateHeure=' + encodeURIComponent(dateHeure);
}
</script>
</body>
</html>
