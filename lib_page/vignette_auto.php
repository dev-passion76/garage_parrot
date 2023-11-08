<?php
require_once '../lib/bib_composant_affiche.php';
// Attention cet include permet l'affichage d'un vehicule sur la base de la variable array $raw
?>
<!--Ligne de vignette -->

<div class="vignette-v2">
<div >
  <div class="visuel_conteneur">
        <a href="fiche_voiture.php?code_vehicule=<?= $raw['idx_vehicule']?>" class="visuel">
        <img width="400" height="300" class="lazymage loaded" src="assets/photos_vehicules/<?= $raw['url_img']?>" alt="<?= $raw['description']?>" title="<?= $raw['description']?>">
        </a>
  </div>
  <h2>
    <a href="fiche_voiture.php?code_vehicule=<?= $raw['idx_vehicule']?>"><span class="h2-marque"><?= $raw['description']?></span></a>
  </h2>
  <div class="annonce-icons">
    <?php 
        // Recherche du type de motorisation
        $chaineRetour = getLibelleProprieteVehicule($pdo,$raw['idx_vehicule'],'MO');
        if ($chaineRetour!=null){
    ?>
    <span class="annonce-ico"><?=$chaineRetour?></span>
        <?php }?>

    <span class="annonce-ico"><?= $raw['annee_circulation']?></span>
    <?php 
        // Recherche du type de motorisation
        $chaineRetour = getLibelleProprieteVehicule($pdo,$raw['idx_vehicule'],'BO');
        if ($chaineRetour!=null){
    ?>
    <span class="icon-gearshift-shift-svgrepo-com"></span><?=$chaineRetour?>
<?php }?>

<br/>

<span class="annonce-ico"><?= afficheKm($raw['km'])?> km</span>

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

<div class="annonce_contenu">
  <span class="prix"><?= afficheMontant($raw['prix'])?>&nbsp;€</span> 
</div>

<a href="fiche_voiture.php?code_vehicule=<?= $raw['idx_vehicule']?>" class="btn btn-custom btn-sm btn-block btn-voir">Voir le véhicule</a>
<a href="contact?code_vehicule=<?= $raw['idx_vehicule']?>" class="btn btn-custom btn-sm btn-block btn-voir">Nous contacter</a>
</div>
</div>
<!--Fin de vignette 1ère vignette-->

