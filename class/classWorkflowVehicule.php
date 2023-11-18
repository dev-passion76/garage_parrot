<?php

/** Ici je définie ma fonction vendreVehicule en reprenant le tableau vehicule et l'idxVehicule pr le marquer comme vendu dans la DB
 * cela suppose que j'ai créer une autre colonne en DB : 'status_vente'. La méthode prend l'indice du véhicule (idxVehicule) comme paramètre et met à jour son statut de vente.
*/
require_once '../class/classVehicule.php';

class WorkflowVehicule {
    /**
     * Process pour faire la mise du statut du véhicule
     *   
     */
    public function annule($pdo,$idxVehicule){
        return Vehicule::modifierStatus($pdo,$idxVehicule,'A');
    } 

    public function vente($pdo,$idxVehicule){
        return Vehicule::modifierStatus($pdo,$idxVehicule,'V');
    } 

    public function reserve($pdo,$idxVehicule){
        return Vehicule::modifierStatus($pdo,$idxVehicule,'R');
    } 

    public function publie($pdo,$idxVehicule){
        return Vehicule::modifierStatus($pdo,$idxVehicule,'P');
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