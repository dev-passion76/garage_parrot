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
?>