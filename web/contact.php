<?php
require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../lib_page/header.php';

require_once '../class/classUser.php';

/**
 *  Acquisition des datas du formrulaire POST si mode soumission sinon les variables sont initialiés à null
 * 
 * objectif affichage de la page BODY en bas
 */ 
$nom     = POST::get('nom');
$prenom  = POST::get('prenom');
$email   = POST::get('email'); 
$phone   = POST::get('phone');
$adresse = POST::get('adresse');
$message = POST::get('message');
$valid_cgu = POST::get('valid_cgu');

/**
 * Initilisation de variable de traitements 
 * exemple zone de focus / libelle de message d'erreur
 */
$mesErr = '';
$zoneFocus = "";
/**
 * Processus normalement lié à la validation suite à l'action de cliquer sur le bouton se connecter
 */
$idxVehicule = null;

// acquisition en mode GET via les fiches véhicules pour la prise de contact via le <a href
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  $idxVehicule = GET::get('code_vehicule');
}

// acquisition du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  /**
   * Traitement des zones nom prenom email password adresse
   */
    $idxVehicule = POST::get('code_vehicule');

    // les controles a faire à minima sur les zones
    if ($nom == ''){
        $mesErr = "La saisie du nom est obligatoire";
        $zoneFocus = 'nom';
    }
    else
    if ($prenom == ''){
        $mesErr = "La saisie du prenom est obligatoire";
        $zoneFocus = 'prenom';
    }
    else
    if ($email == ''){
        $mesErr = "La saisie de l'adresse mail est obligatoire";
        $zoneFocus = 'email';
    }
    else
    if ($phone == ''){
        $mesErr = "La saisie du numéro de téléphone est obligatoire";
        $zoneFocus = 'phone';
    }
    else
    if ($adresse == ''){
        $mesErr = "La saisie de l'adresse est obligatoire";
        $zoneFocus = 'adresse';
    }
    else
    if ($message == ''){
        $mesErr = "La saisie du message est obligatoire";
        $zoneFocus = 'message';
    }    
    else
    if ($valid_cgu == null || $valid_cgu != 'on'){
      $mesErr = "Veuillez accepter les CGU";
      $zoneFocus = 'valid_cgu';
    }
    else {
        /**
         * Traitement de la demande
         * envoi de mail par exemple
         */

        if (ClientDemande::ajoute($pdo,$nom,$prenom,$email,$phone,$adresse,$message,$idxVehicule)){
          $mesErr = "Votre demande d'information a bien été prise en compte";
          $nom     = "";
          $prenom  = "";
          $email   = "";
          $phone   = "";
          $adresse = "";
          $message = "";
        }
        else{
          $mesErr = "Anomalie lors de la prise en compte de votre message";
        }  
        $zoneFocus = '';
    }
}
else{
    $mesErr = '';
}
?><body>
<?php if ($mesErr!='') { ?>
<div>
  <?=$mesErr?>
</div>
<?php } ?>
<div>
<!-- 
Dans un Form mettre 
method="POST" pour ne pas avoir les données affichés dans l'url lors du submit et sa taille est illimité alors qu'en GET c'est limité 
enctype="multipart/form-data", extremement important pour notamment l'envoi des champs de type INPUT type="file" sinon ces champs ne seront jamais soumis via le formulaire direction le serveur
-->
<form class="row col-6 m-5 " method="POST" enctype="multipart/form-data" name="frmSaisie">
  <input type="hidden" name="code_vehicule" class="" value="<?=$idxVehicule?>"/>
  <h3>Formulaire de contact</h3>
  <div class="col-md-6">
    <input type="text" name="nom" class="form-control" id="FirstName" placeholder="Nom" value="<?=$nom?>"/>
  </div>

  <div class="col-md-6">
    <input type="text" name="prenom" class="form-control" id="LastName" placeholder="Prénom" value="<?=$prenom?>"/>
  </div>

  <div class="col-md-12">
    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email" value="<?=$email?>"/>
  </div>

  <div class="col-md-12">
    <input type="phone" name="phone" class="form-control" id="inputPhone" placeholder="Téléphone (0601020304)" value="<?=$phone?>"/>
  </div>

  <div class="col-12">
    <input type="text" name="adresse" class="form-control" id="inputAddress" placeholder="Votre adresse postale complète" value="<?=$adresse?>"/>
  </div>

  <div class="col-md-6">
    <textarea type="text" name="message" class="form-control" id="idMessage" 
        placeholder="Votre message"><?=$message?></textarea>
  </div>

  <div class="col-12 my-2">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck" name="valid_cgu">
      <label class="form-check-label" for="gridCheck">
        En cliquant sur "Envoyer" j'accepte les conditions d'utilisations
      </label>
    </div>
  </div>

  <div class="col-12 my-2"> <!-- m=margin y=top-->
    <button type="submit" class="btn btn-primary">Envoyer</button>
  </div>
</form>
<?php 
if ($zoneFocus != ''){
  ?>
    <script type="text/javascript">
      document.forms['frmSaisie'].elements['<?=$zoneFocus?>'].focus();
    </script>
  <?php 
}
?>

</div>

<?php
require_once '../lib_page/footer.php';
?>
<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
