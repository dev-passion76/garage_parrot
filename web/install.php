<?php
/**
 * Programme qui doit être déclencher au début afin de pouvoir initialiser la base de donnée d'au moins un utilisateur (administrateur)
 */


require_once '../lib/bib_connect.php';

require_once '../lib/bib_sql.php';

require_once '../lib_page/header.php';

require_once '../class/classUtilisateur.php';

$identifiant = "";
$mdp = "";
$nom = "";
$prenom = "";
/**
 * module d'installation de l'application
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nom         = POST::get('nom');
    $prenom      = POST::get('prenom');
    $identifiant = POST::get('username');
    $mdp = POST::get('password');
    
    if ($nom == null || $nom == '')
        $mes = "La saisie du nom est obligatoire";
    else
    if ($prenom == null || $prenom == '')
        $mes = "La saisie du prenom est obligatoire";
    else
    if ($identifiant == null || $identifiant == '')
        $mes = "La saisie de l'identifiant est obligatoire";
    else
    if ($mdp == null ||$mdp == '')
        $mes = "La saisie du mot de passe est obligatoire";
    else
    if (Utilisateur::isExiste($pdo, $identifiant))
        $mes = "Utilisateur déjà existant";
    else {
        $type_utilisateur = 'A';
        
        if (Utilisateur::ajoute($pdo,$identifiant,$mot_de_passe,$nom,$prenom,$type_utilisateur)){
            header("Location:index.php");
            exit;
        }
        else
           $mes = "Anomalie lors de la création du site";
    }
}
else{
    $mes = 'Connectez-vous pour accéder à votre compte.';
}
?><body>
	<div id="app">
		<form method="POST" class="signin h-screen overflow-y-auto px-4 py-4 md:flex md:items-center md:justify-center md:pb-32">
			<div
				class="signin-inner h-full flex flex-col justify-between md:block md:h-auto">
				<div class="signin-header">
					<h1 class="text-center">Paramétrage pour l'installation du site</h1>
					<div class="text-center">
						<p class="junipero text text-secondary"><?= $mes ?></p>
					</div>
					<div class="mt-12 p3-auth-form">
						<div>	
							<div class="junipero field text-input labeled empty !w-full">
								<input id="nom" name="nom" required="" type="text" placeholder="Votre nom" value="<?= $nom?>">
							</div>
						</div>
						<div>	
							<div class="junipero field text-input labeled empty !w-full">
								<input id="prenom" name="prenom" required="" type="text" placeholder="Votre Prénom" value="<?= $prenom?>">
							</div>
						</div>
						<div>	
							<div class="junipero field text-input labeled empty !w-full">
								<input id="username" name="username" required="" type="text" placeholder="Identifiant" value="<?= $identifiant?>">
							</div>
						</div>
						<div class="mt-4">
							<div class="textfield-with-actions flex">
								<div class="junipero field text-input labeled empty">
									<input id="password" name="password" required="" type="password" placeholder="Mot de passe" value="<?= $mdp?>">
								</div>
							</div>
						</div>
						<div class="flex justify-end mt-8 md:justify-between">
							<div class="flex-none">
								<a href="oublie_mdp.php"><span>Mot de passe oublié ?</span></a>
							</div>
						</div>
					</div>
				</div>
				<div class="signin-buttons">
					<div class="flex flex-col justify-between items-center mt-12 md:flex-row">
						<div class="flex-none w-full order-first md:w-auto md:order-none">
							<button type="submit" onclick="this.form.submit()"
								class="junipero button disabled flex w-full justify-center items-center primary md:w-auto">
								<span>Activer le site</span>
							</button>
						</div>
						<div class="flex-none w-full order-first md:w-auto md:order-none">
							<a href="index.php" class="junipero button disabled flex w-full justify-center items-center primary md:w-auto">
								<span>Retour sur le site</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
<?php
require_once '../lib_page/footer.php';
?>
<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/plugins/bootstrap.bundle.min.js"></script>
</body>
</html>
