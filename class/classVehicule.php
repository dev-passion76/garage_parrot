<?php 
class Vehicule{
    
    public function __construct(){
        
    }
    
    
    /**
     * Methode liste des vehicules
     */
    public function getListe($pdo){
        $sql = "select * from vehicule ".
                "left outer join marque on marque.code = vehicule.code_marque";
        return DbAccess::getRequeteSql($pdo, $sql);
        
    }
    
    /**
     * 
     * @param unknown $pdo
     * @param unknown $identifiant
     * @param unknown $mot_de_passe
     * @param unknown $nom
     * @param unknown $prenom
     * @param unknown $type_utilisateur
     */
    public static function ajoute($pdo,$codeMarque,$description,$prix,$anneeCirculation,$km,$nomFichierImage){
        $data = [
            'tcodeMarque' => $codeMarque,
            'tdescription' => $description,
            'tprix' => $prix,
            'tannee' => $anneeCirculation,
            'tkm' => $km,
            'urlimage' => $nomFichierImage
        ];
        $sql = "INSERT INTO vehicule (code_marque,description,prix,annee_circulation,km,url_img) VALUES (:tcodeMarque, :tdescription, :tprix, :tannee, :tkm , :urlimage)";
        
        $stmt= $pdo->prepare($sql);
        $stmt->execute($data);
        
        return true;
        
        
    }
}
?>