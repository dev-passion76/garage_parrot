<?php
    class Temoignage{

        public function __construct(){
        
        }

        public static function getListe($pdo){
            $sql = "select * from temoignage";
            return DbAccess::getRequeteSql($pdo, $sql);
        }

        public static function getListePublie($pdo){
            $sql = "select * from temoignage where is_publie = 1 and is_interdit = 0";
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

        public static function switchPublic($pdo,$idxTemoignage){
            $sql = "update temoignage set is_publie = 1 - is_publie where idx_temoignage = ".$idxTemoignage;
            
            $stmt= $pdo->prepare($sql);
            $stmt->execute();

            return Temoignage::getRaw($pdo,$idxTemoignage);
        }

        public static function switchInterdit($pdo,$idxTemoignage){
            $sql = "update temoignage set is_interdit = 1 - is_interdit where idx_temoignage = ".$idxTemoignage;
            
            $stmt= $pdo->prepare($sql);
            $stmt->execute();

            return Temoignage::getRaw($pdo,$idxTemoignage);
        }

        public static function getRaw($pdo,$idxTemoignage){
            $sql = "select * from temoignage where idx_temoignage = ".$idxTemoignage;
            return DbAccess::canFind($pdo,$sql);
        }
    }
?>