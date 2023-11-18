<?php

/** Ici je définie ma fonction vendreVehicule en reprenant le tableau vehicule et l'idxVehicule pr le marquer comme vendu dans la DB
 * cela suppose que j'ai créer une autre colonne en DB : 'status_vente'. La méthode prend l'indice du véhicule (idxVehicule) comme paramètre et met à jour son statut de vente.
*/
class Status_vente {
    public function vendreVehicule($pdo, $idxVehicule) {
        $stmt = $pdo->prepare("UPDATE vehicule SET status_vente = 'vendu' WHERE idx_vehicule = :idx_vehicule");
        $stmt = $stmt->execute([':idx_vehicule' => $idxVehicule]);

        /*vérification des erreurs pr déterminer si la mise à jour a réussi.*/

        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false; /**La mise à jour a échoué si le véhicule n'a pas été trouvé */
        }
}
}

/**
     * Marquer un véhicule comme vendu.
     * Cette méthode prend l'identifiant du véhicule et le marque comme vendu dans la base de données.
     * @param PDO $pdo L'objet PDO pour la connexion à la base de données.
     * @param int $idxVehicule L'identifiant du véhicule à marquer comme vendu. Le type de données attendu pour ce paramètre, ici un entier (integer).
     * @return bool Retourne true si la mise à jour a été effectuée avec succès, sinon false.
     */
?>