<?php 
    class User {
        // On enregistre les information de connexion du driver pdo
        private $user;
        
        /**
         * le verbe __construct est relatif au constructeur de class
         * quand on 
         * @param unknown $pdo
         */
        public function __construct() {
        }
        
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

        /**
         * Renvoi le code type de l'utilisateur
         * @return unknown
         */
        public function getTypeUser(){
            return  $this->user['type_utilisateur'];
        }

        /**
         * Renvoi true false pour savoir si l'utilisateur est admin
         * @return boolean
         */
        public function isAdmin(){
            return  $this->user['type_utilisateur'] == 'A';
        }
        
        /**
         * Fonction pour l'ajout d'utilisateur
         * @param unknown $identifiant
         * @param unknown $mot_de_passe
         * @param unknown $nom
         * @param unknown $prenom
         * @param unknown $type_utilisateur
         */
        public function ajouteUtilisateur($pdo,$identifiant,$mot_de_passe,$nom,$prenom,$type_utilisateur){
            $data = [
                'tidentifiant' => $identifiant,
                'tmdp' => $mot_de_passe,
                'tnom' => $nom,
                'tprenom' => $prenom,
                'ttype_utilisateur' => $type_utilisateur,
            ];
            $sql = "INSERT INTO utilisateur (identifiant,mdp,nom,prenom,type_utilisateur) VALUES (:tidentifiant, :tmdp, :tnom, :tprenom, :ttype_utilisateur)";
            
            $stmt= $pdo->prepare($sql);
            $stmt->execute($data);
            
            return true;
        }
    }
?>