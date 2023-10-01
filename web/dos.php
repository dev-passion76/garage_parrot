<?php
/**
 * Cette bilbliotheque a été crée pour confiner les informations de connexion 
 * a la base de donnée en dehors de la visibilité de l'alais du serveur Apache
 * Comme cela si suite a un deny de service qui aurait laisser seulement le serveur apache opérationnel
 * la page brut de php que verrait l'utilisateur n'aura pas les identifiants en base de donnée
 */
require_once '../lib/bib_connect.php';

/**
 * Cette bibliotheque est prevu pour avoir les fonctions de base pour les interrog et mise en mise a jour
 * en base de donnée
 * A savoir interrogation Muti Record et Mone Record
 * Creation / modification / suppression de record 
 * Gestion des transactions au sens du Begin transaction et du commit transaction
 *
 */
require_once '../lib/bib_sql.php';

require_once '../bibappli/lib_metier.php';

$reqPrestation = getPrestation($pdo,"RP");

$sql = "SELECT * FROM marque  ";
$reqMarque = getRequeteSql($pdo,$sql);


?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Garage Vincent Parrot</title>
<!--    <link
      rel="stylesheet"
      href="/node_modules/bootstrap/dist/css/bootstrap.min.css"
    />
-->
    <link
      rel="stylesheet"
      href="css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="js/bootstrap.bundle.min.js"
    />
<link
      rel="stylesheet"
      href="js/jquery.min.js"
    />

    <style>
      .large-margin {
        margin-left: 100px;
      }
      .centered-nav-items {
        text-align: center;
      }
      .centered-nav-items .nav-item {
        display: inline-block;
      }
      .garage-text {
        color: #531429;
      }
      .nav-item-text {
        color: #aa4672;
      }
      .nav-container {
        margin-bottom: 50px;
      }

      .custom-select {
        border: none;
        background-color: transparent;
        color: #aa4672;
        outline: none;
        cursor: pointer;
        margin-right: 20px;
        appearance: none; /* Supprime la flèche de la liste déroulante sur certains navigateurs */
        -webkit-appearance: none; /* Safari and Chrome */
        -moz-appearance: none; /* Firefox */
        /*background-image: url('path_to_your_custom_arrow.png'); /* flèche personnalisée */
        background-repeat: no-repeat;
        background-position: right center;
        padding-right: 20px; /* Pour que le texte ne chevauche pas la flèche */
      }

      .custom-select:focus {
        box-shadow: none; /* Supprime l'ombre lorsqu'il est en focus */
      }

      .navbar-custom {
        background-color: white;
      }
      .bg-custom {
        background-color: #6d6d6d !important;
      }
      .height-custom {
        min-height: 200px;
      }
      .garage-text {
        font-size: 140%;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-custom">
      <div class="container-fluid d-flex nav-container">
        <a class="navbar-brand large-margin" href="index.html">
          <img
            src="./assets/image-voiture garage removebg-preview.png"
            alt="Logo du garage"
            width="230"
            class="d-inline-block align-text-top"
          />
          <br /><span class="garage-text" style="color: #531424"
            >Garage V.Parrot</span
          >
        </a>
        <div class="d-flex justify-content-center" style="flex-grow: 1">
          <ul class="navbar-nav flex-row centered-nav-items">
            <li class="nav-item me-5">
              <a class="nav-link nav-item-text" href="#">Nos occasions</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link nav-item-text" href="#">Réparations</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link nav-item-text" href="#">Qui sommes-nous ?</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div
      class="shadow-sm mb-5 bg-body bg-custom height-custom text-center"
      style="font-size: 2em"
    >
      TROUVEZ <span style="color: #430d25">VOTRE PROCHAIN VÉHICULE</span>
    </div>
    <div class="dropdown">
  
    <select name="from_home_modele[]" class="form-control custom-select"> 
    <!-- Pr avoir le v check, mettre fieldset > legend ou label > select > option -->
    <option value="Selection">Sélectionnez votre marque</option>
        <?php foreach($reqMarque as $raw){ ?>
        <option value="<?=$raw["code"]?>"><?=$raw["libelle"]?></option>  
        <?php } ?>
      </select>
      <select name="from_home_modele[]" class="form-control custom-select">
        <option value="">Réparations</option>
        <?php foreach($reqPrestation as $raw){ ?>
          <option value="<?=$raw["code"]?>"><?=$raw["libelle"]?></option>  
        <?php } ?>
      </select> 

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <li class="ms-3">
        <a class="text-body-secondary" href="#"
          ><svg class="bi" width="24" height="24"></svg>
            <use xlink:href="#twitter"></use>
        </a>
      </li>
      <li class="ms-3">
        <a class="text-body-secondary" href="#"
          ><svg class="bi" width="24" height="24">
            <use xlink:href="#instagram"></use></svg>
          </a>
      </li>
      <li class="ms-3">
        <a class="text-body-secondary" href="#">
          <svg class="bi" width="24" height="24">
            <use xlink:href="#facebook"></use></svg>
        </a>
      </li>
    </ul>

    <footer
      class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top"
    >
      <div class="col-md-4 d-flex align-items-center">
        <a
          href="/"
          class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1"
        >
          <svg class="bi" width="30" height="24">
            <use xlink:href="#bootstrap"></use>
          </svg>
        </a>
        <span class="mb-3 mb-md-0 text-body-secondary"
          >© 2023 Company, Inc</span
        >
      </div>
      <div class="d-flex justify-content-end">
        <img class="ms-3" src="assets/linkedin-112.png" alt="logo linkedin" />
        <img
          class="ms-3"
          src="assets/black-instagram-transparent-logo-10671.png"
          alt="Logo instagram"
        />
        <img
          class="ms-3"
          src="assets/facebook-logo-108.png"
          alt="Logo facebook"
        />
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- 
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="app.js"></script>
    -->
  </body>
</html>
