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

require_once '../lib_page/header.php';

require_once '../class/classTemoignage.php';
//    <link rel="stylesheet" href="../css/qui_sommes_nous.css">

?>
<body>
<section id="qui-sommes-nous" class="section-container">
    <h1 class="titre-section">À propos du Garage V.Parrot</h1>      
    <div class="row">
        <div class="col-6">
            <p class="text-qui">Vincent Parrot, fort de ses 15 années d'expérience dans la réparation automobile, <br>a ouvert son propre garage à Toulouse en 2021.<br> Depuis 2 ans, nous vous proposons une large gamme de services:<br> réparation de la carrosserie et de la mécanique des voitures <br>ainsi que leur entretien régulier pour garantir leur performance et leur sécurité.<br>De plus le <b>Garage V.Parrot</b> met en vente des véhicules d'occasion.</b><br>Toute notre équipe est à votre écoute pour un service de qualité et personnalisé.</p>
        </div>
        <div class="col-6">
            <img src="assets/image-voiture-garage.png" alt="Logo de Garage V.Parrot" class="img_logo">
        </div>       
    </div> 
</section>
<div class="section-wrapper">
    <?php 
    if ($liste = Temoignage::getListePublie($pdo)){
    ?>
<section id="temoignages" class="container-fluid">
    <h2 class="titre-section">Témoignages de nos clients</h2>
    <div id="carouselExample" class="carousel slide">
<div class="carousel-inner">
    <?php 
            foreach ($liste as $key => $raw){
            ?>
                <div class="carousel-item <?= $key==0 ? "active" : ""?>">
                    <img src="assets/Client satisfait unsplash.jpg" alt="photo-de-client" class="photo_client">
                    <p class="texte-lorem"><?= $raw['commentaire']?>
                </div>
            <?php } ?>
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

</section>
    <?php } ?>

<a href="index.php" class="link-occasions">Voir nos véhicules d'occasion</a>

<?php include '../lib_page/footer.php'; 
        include '../lib_page/carousel.php'; /* ? pourquoi n'apparaît pas */ 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>