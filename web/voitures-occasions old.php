<?php

require_once '../lib/bib_connect.php';
require_once '../lib/bib_sql.php';

/**
 * Récuperations infos données
 */
if (isset($_POST['from_home_modele']))
    $codeMarque = $_POST['from_home_modele'];
else
    $codeMarque = null;


    echo $codeMarque;

    $sql = "select * from marque where code = '$codeMarque'";

    print $sql;
    $reqMarque = DbAccess::getRequeteSql($pdo,$sql);

    $sql = "select * from vehicule where code_marque = '$codeMarque'";
    $reqVehicule =DbAccess::getRequeteSql($pdo,$sql);

    ?><table><?php

    foreach ($reqVehicule as $raw){
require_once '../lib_page/header.php';
?><body>
    <!-- <tr>
        <td><?=$raw['code_marque']?></td>
        <td><?=$raw['description']?></td>
        <td><?=$raw['prix']?></td>
        <td><?=$raw['annee_circulation']?></td>
        <td><?=$raw['km']?></td>
        <td><img src="assets/photos_vehicules/<?=$raw['url_img']?>"/></td>
    </tr> -->



<div class="col-lg-3 col-sm-4 vignette-v2">
		<div data-link="https://www.saintmerri.fr/voitures-occasions/bmw-f32-coupe-430da-xdrive-258-m-sport-11709/" data-annonce_id="18470" class="annonce annonce_caroussel">
			<div class="visuel_conteneur">
				<div class="carousel slide caroussel-initiate">
					<div class="carousel-inner">
						<div class="item active">
							<a href="#" class="visuel">
									<picture class="">
							<img width="400" height="300"  class="lazymage loaded" src="assets/photos_vehicules/<?=$raw['url_img']?>" alt="FIAT" title="FIAT Citadine">
						</picture>	<noscript>
							</noscript>
							</a>
						</div>
					
				</div>
			</div>

			<h2>
				<a href="#"><span class="h2-marque"><?=$raw['description']?></span><br><span class="a_version" title="">FIAT Citadine</span></a>
			</h2>

			<div class="annonce-icons">
				
				<span class="annonce-ico">
					<span class="icon-3213107_drawn_fuel_hand_location_navigation_icon"></span>Essence</span>
				
				<span class="annonce-ico">
					<span class="icon-calendar"></span> 02/2016
				</span>


				<span class="annonce-ico">
					<span class="icon-gearshift-shift-svgrepo-com"></span>Manuelle
				</span>

				<br>

				<span class="annonce-ico">
					<span class="icon-tachometer-alt-solid-svgrepo-com"></span>32.000km
				</span>
					<span class="annonce-ico">
						<span class="icon-warranty-term-svgrepo-com"></span> Garantie 12 mois
					</span>
			</div>

			<div class="annonce_contenu">
				<div class="row text-center">
					<div class="col-xs-6">
						<span class="prix">12&nbsp;890&nbsp;€</span>
					</div>

				</div>

				<div class="clear_1"></div></div>

			<!-- <a href="https://www.saintmerri.fr/voitures-occasions/bmw-f32-coupe-430da-xdrive-258-m-sport-11709/" class="btn btn-primary btn-sm btn-block btn-voir">Voir le véhicule</a> -->
		</div>
			</div>

			<div class="col-lg-3 col-sm-4 vignette-v2">
		<div data-link="https://www.saintmerri.fr/voitures-occasions/bmw-f32-coupe-430da-xdrive-258-m-sport-11709/" data-annonce_id="18470" class="annonce annonce_caroussel">
			<div class="visuel_conteneur">
				<div class="carousel slide caroussel-initiate">
					<div class="carousel-inner">
						<div class="item active">
							<a href="#" class="visuel">
									<picture class="">
							<img width="400" height="300"  class="lazymage loaded" src="assets/photos_vehicules/<?=$raw['url_img']?>" alt="FIAT" title="FIAT Citadine">
						</picture>	<noscript>
							</noscript>
							</a>
						</div>
					
				</div>
			</div>

			<h2>
				<a href="#"><span class="h2-marque"><?=$raw['description']?></span><br><span class="a_version" title="">Mini sport</span></a>
			</h2>

			<div class="annonce-icons">
				
				<span class="annonce-ico">
					<span class="icon-3213107_drawn_fuel_hand_location_navigation_icon"></span>Essence</span>
				
				<span class="annonce-ico">
					<span class="icon-calendar"></span> 02/2016
				</span>


				<span class="annonce-ico">
					<span class="icon-gearshift-shift-svgrepo-com"></span>Manuelle
				</span>

				<br>

				<span class="annonce-ico">
					<span class="icon-tachometer-alt-solid-svgrepo-com"></span>32.000km
				</span>
					<span class="annonce-ico">
						<span class="icon-warranty-term-svgrepo-com"></span> Garantie 12 mois
					</span>
			</div>

			<div class="annonce_contenu">
				<div class="row text-center">
					<div class="col-xs-6">
						<span class="prix">12&nbsp;890&nbsp;€</span>
					</div>

				</div>

				<div class="clear_1"></div></div>
		</div>
			</div>

<?php
    }
?>
</table>
<?php
require_once '../lib_page/footer.php';
?>
</body>
</html>
