<?php
require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../lib_page/header.php';

require_once '../lib/bib_general.php';

require_once '../class/classTemoignage.php';

require_once '../lib/bib_mail.php';

/**
 *  Acquisition des datas du formrulaire POST si mode soumission sinon les variables sont initialiés à null
 * 
 * objectif affichage de la page BODY en bas
 */ 
$nom     = POST::get('nom');
$commentaire  = POST::get('commentaire');
$note   = POST::get('note'); 
$valid_cgu = POST::get('valid_cgu');
/**
 * Initilisation de variable de traitements 
 * exemple zone de focus / libelle de message d'erreur
 */
$mesErr = '';
$zoneFocus = "";

// acquisition du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  /**
   * Traitement des zones nom prenom email password adresse
   */

    // les controles a faire à minima sur les zones
    if ($nom == ''){
        $mesErr = "La saisie du nom est obligatoire";
        $zoneFocus = 'nom';
    }
    else
    if ($commentaire == ''){
        $mesErr = "La saisie du commentaire est obligatoire";
        $zoneFocus = 'commentaire';
    }
    else
    if ($note == ''){
        $mesErr = "La saisie de la note est obligatoire";
        $zoneFocus = 'note';
    }
    else
    if ($valid_cgu == null || $valid_cgu != 'on'){
      $mesErr = "Veuillez accepter les CGU";
      $zoneFocus = 'valid_cgu';
    }
    else
    {
        /**
         * Traitement de la demande
         * envoi de mail par exemple
         */

        if (Temoignage::ajoute($pdo,$nom,$commentaire,$note)){

            $mail = Mail::getMail();

          $from = "sandrineECF@laposte.net";

          $email = "archi.sandrineblandamour@gmail.com";

          $mail->setFrom($from, $from);
          $mail->addAddress($email, $email);
          $mail->addReplyTo($from, $from);

          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = "Commentaire de : ". $nom;
          $mail->Body    = "$commentaire <b> Note $note</b>";
          $mail->AltBody = "Commentaire de : $commentaire\nNote $note";

          if ($mail->send()) {
            $mesErr = "Votre demande d'information a bien été prise en compte";
          } else {
            $mesErr = "Erreur lors la prise en compte de votre message";
          }
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

/* Jeu de test pour recharger ma page  
$nom     = 'toto';
$prenom  = 'toto';
$email   = 'archi.sandrineblandamour@gmail.com';
$phone   = 'toto';
$adresse = 'toto';
$message = 'toto';
$valid_cgu = "";*/

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
  <h3>Formulaire de témoignage</h3>
  <div class="col-md-6">
    <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom" value="<?=$nom?>"/>
  </div>

  <div class="col-md-6">
    <textarea type="text" name="commentaire" class="form-control" id="idMessage" 
        placeholder="Votre commentaire"><?=$commentaire?></textarea>
  </div>

  <div class="col-md-12">
    <input type="note" name="note" class="form-control" id="node" placeholder="note" value="<?=$note?>"/>
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
