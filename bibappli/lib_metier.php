<?php

/**
 * Ernvoi la liste des prestations
 */
    function getPrestation($pdo,$typePrestation){
        /**
         * PDO::quote : echappe la valeur String et donc evite les injections SQL
         * Attention function non static à recupérer la classe PDO avec l'appel sous format ->
         */ 
        $sql = "SELECT * FROM prestation WHERE code_type_prestation = ".$pdo->quote($typePrestation)." ";
        return DbAccess::getRequeteSql($pdo,$sql);
    }

    function getLibelleProprieteVehicule($pdo,$idxVehicule,$codePropriete){
                $sql = "SELECT propriete_valeur.libelle FROM vehicule_propriete ".
                "left outer join propriete_valeur ".
                    "ON  propriete_valeur.code_propriete = vehicule_propriete.code_propriete ".
                    "AND propriete_valeur.code_valeur    = vehicule_propriete.code_valeur ".
                "where vehicule_propriete.idx_vehicule = $idxVehicule ".
                "and   vehicule_propriete.code_propriete = '$codePropriete' ";
        if ($reponse = DbAccess::canFind($pdo,$sql))
            return $reponse['libelle'];
        else
            return '';

    }
?>