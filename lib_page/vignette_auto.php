<?php
require_once '../lib/bib_composant_affiche.php';
// Attention cet include permet l'affichage d'un vehicule sur la base de la variable array $raw
?>
<!--Ligne de vignette -->

<div class="col-lg-3 col-sm-4 vignette-v2">
<div data-link="https://www.saintmerri.fr/voitures-occasions/bmw-118da-150ch-m-sport-8cv-2659/" data-annonce_id="17081" class="annonce">
<div class="visuel_conteneur">
<div class="carousel slide">
<div class="carousel-inner">
<div class="item active">
<a href="fiche_voiture.php?code_vehicule=<?= $raw['idx_vehicule']?>" class="visuel">
<img width="400" height="300" class="lazymage loaded" src="assets/photos_vehicules/<?= $raw['url_img']?>" alt="<?= $raw['description']?>" title="<?= $raw['description']?>">
</a>
</div>
</div> 
</div>
</div>
<h2>
<a href="fiche_voiture.php?code_vehicule=<?= $raw['idx_vehicule']?>"><span class="h2-marque"><?= $raw['description']?></span></a>
</h2>

<div class="annonce-icons">
<?php
?>
<?php 
    // Recherche du type de motorisation
    $chaineRetour = getLibelleProprieteVehicule($pdo,$raw['idx_vehicule'],'MO');
    if ($chaineRetour!=null){
?>
<span class="annonce-ico">
<span class="icon-3213107_drawn_fuel_hand_location_navigation_icon"></span> 
<?=$chaineRetour?>
</span>
<?php }?>

<span class="annonce-ico">
<?= $raw['annee_circulation']?>
</span>


<?php 
    // Recherche du type de motorisation
    $chaineRetour = getLibelleProprieteVehicule($pdo,$raw['idx_vehicule'],'BO');
    if ($chaineRetour!=null){
?>
<span class="annonce-ico">
<span class="icon-gearshift-shift-svgrepo-com"></span><?=$chaineRetour?>
</span>
<?php }?>

<br>

<span class="annonce-ico">
<?= afficheKm($raw['km'])?> km
</span>

<?php 
    // Recherche du type de garantie
    $chaineRetour = getLibelleProprieteVehicule($pdo,$raw['idx_vehicule'],'GA');
    if ($chaineRetour!=null){
?>
<span class="annonce-ico">
<span class="icon-warranty-term-svgrepo-com"></span> Garantie <?=$chaineRetour?>
</span>
<?php }?>
</div>

<div class="annonce_badges_c annonce_badges_c_empty">
<div class="annonce_badges"><div><span class="badge_vo badge_pb">Prix en baisse</span></div><div><span class="badge_vo badge_fk">Faible kilométrage</span></div></div>
</div>

<div class="annonce_contenu">
<div class="row text-center">
<div class="col-xs-6">
<span class="prix"><?= afficheMontant($raw['prix'])?>&nbsp;€</span> </div>
</div>

<div class="clear_1"></div></div>

<a href="fiche_voiture.php?code_vehicule=<?= $raw['idx_vehicule']?>" class="btn btn-primary btn-sm btn-block btn-voir">Voir le véhicule</a>
</div>
</div>
<!--Fin de vignette 1ère vignette-->

