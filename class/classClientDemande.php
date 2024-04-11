<?php 
    class ClientDemande {
        // On enregistre les information de connexion du driver pdo
        private $demande;
        
        /**
         * le verbe __construct est relatif au constructeur de class
         * quand on 
         * @param unknown $pdo
         */
        public function __construct() {
        }
        
        /**
         * Liste des utilisateurs
         *
         * @param unknown $pdo
         * @return unknown
         */
        public static function getListe($pdo){
            $sql = "select * from client_demande ";
            return DbAccess::getRequeteSql($pdo, $sql);
        }
        
        /**
         * Fonction pour l'ajout d'utilisateur
         * @param unknown $identifiant
         * @param unknown $mot_de_passe
         * @param unknown $nom
         * @param unknown $prenom
         * @param unknown $type_utilisateur
         */
        public static function ajoute($pdo,$nom,$prenom,$email,$phone,$adresse,$message,$idxVehicule){
        $data = [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'phone' => $phone,
            'adresse' => $adresse,
            'message' => $message,
            'idxVehicule' => $idxVehicule
        ];
        $sql = "INSERT INTO client_demande (nom,prenom,email,phone,adresse,message,idx_vehicule) VALUES (:nom, :prenom, :email, :phone, :adresse, :message , :idxVehicule)";
            
            $stmt= $pdo->prepare($sql);
            return $stmt->execute($data);
        }

        public static function modifie($pdo,$identifiant,$mot_de_passe,$nom,$prenom,$type_utilisateur){
            $data = [
                'tidentifiant' => $identifiant,
                'tmdp' => $mot_de_passe,
                'tnom' => $nom,
                'tprenom' => $prenom,
                'ttype_utilisateur' => $type_utilisateur,
            ];
            $sql = "UPDATE utilisateur SET mdp=:tmdp, nom=:tnom, prenom=:tprenom, type_utilisateur=:ttype_utilisateur WHERE identifiant=:tidentifiant";
            
            $stmt= $pdo->prepare($sql);
            return $stmt->execute($data);
        }
        
        public static function supprime($pdo,$identifiant) {
            $data = [
                'id' => $identifiant,
            ];
            $sql = "DELETE FROM utilisateur WHERE identifiant = :id";
            $stmt= $pdo->prepare($sql);
            return $stmt->execute($data);
        }

        /**
         * Procesus de connex
         *
         * @param unknown $pdo
         * @param unknown $identifiant
         * @param unknown $motDePasse
         * @return boolean
         */
        public function verifieConnection($pdo,$identifiant,$motDePasse) {
            $sql = 'select * from utilisateur '.
                'where utilisateur.identifiant = '.$pdo->quote($identifiant).' '.
                'and   utilisateur.mdp = '.$pdo->quote($motDePasse).' ';
            if ($reqUser = DbAccess::canFind($pdo,$sql)){
                $this->user = $reqUser;
                return true;
            }
            else{
                return false;
            }
        }
        
        /**
         * Renvoi tout les colonnes de la requetes de connexion utilisateur
         * @return unknown
         */
        public function getUser() {
            return $this->user;
        }
    }
?>