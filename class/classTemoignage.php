<?php
    class Temoignage{

        public function __construct(){
        
        }

        public static function getListe($pdo){
            $sql = "select * from temoignage";
            return DbAccess::getRequeteSql($pdo, $sql);
        }
        
        public static function ajoute($pdo,$nom, $commentaire, $note){
            $data = [
                'nom' => $nom,
                'commentaire' => $commentaire,
                'note' => $note,
            ];
            $sql = "INSERT INTO temoignage (nom,commentaire,note) VALUES (:nom, :commentaire, :note)";
            
            $stmt= $pdo->prepare($sql);
            return $stmt->execute($data);
        }

    }
?>