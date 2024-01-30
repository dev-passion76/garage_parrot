  <footer>
  <div id="horaires"><br>
    <h3>Horaires d'ouverture </h3><br/><br/>
    <ul>
      <?php
      require_once '../class/classHoraire.php';
        /**
         * Pour information le & sert à pointer l'information et non copié l'information recu 
         * gain mémoire et gain de vitesse
         * 
         */
        foreach (Horaire::getListe($pdo) as & $raw){
        ?>        
          <li><strong><?= GestionDate::$jourSemaine[$raw['jour_semaine'] - 1] ?> : </strong> 
          <?php if (GestionDate::dateHM($raw['is_ouvert'])=='1') { ?>
            <?= GestionDate::dateHM($raw['am_debut']) ?> - <?= GestionDate::dateHM($raw['am_fin']) ?>
            <?php if (GestionDate::dateHM($raw['pm_debut'])!='') { ?>
            , <?= GestionDate::dateHM($raw['pm_debut']) ?> - <?= GestionDate::dateHM($raw['pm_fin']) ?>
            <?php } ?>
          <?php } else {?>
            Fermé
          <?php } ?>
        </li>
        <?php
        }
      ?>        
    </ul>
</div>



    <div class="paper_plane">
      <?php if (!isset($isContactPage)) { ?>
            <a href="contact.php">Nous contacter</a>
            <img src="image/icone_contact.png" alt="icone de contact client">
      <?php } ?>
      <span>Retrouvez nous</span>

        <img
        src="assets/facebook-logo-108.png"
        alt="Logo facebook"
        />
    </div>
  
  <div class="col-md-4 d-flex align-items-center">
  <span class="my-4 mb-3 mb-md-0 text-body-secondary" >© 2023 Company, Inc</span>
  </div>
<script src="web/app.js"></script>
</footer>
