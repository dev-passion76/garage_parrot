<?php
    class Horaire{

        /**
         * Retourne la liste des horairess
         */
        public static function getListe($pdo){
            $sql = "select * from horaire";
            return DbAccess::getRequeteSql($pdo,$sql);
        }

        /**
         * Retourne l'element de la table horaire pour une journée demandée
         */
        public static function getRaw($pdo,$jourSemaine){
            $sql = "select * from horaire where jour_semaine = $jourSemaine";
            return DbAccess::canFind($pdo,$sql);
        }

        /**
         * fonction permettant de switcher le mode ouverture / fermeture d'un jour
         */
        public static function switchOuverture($pdo,$jourSemaine){
            $sql = "update horaire setw is_ouvert = 1 - is_ouvert where jour_semaine = ".$jourSemaine;
            
            $stmt= $pdo->prepare($sql);
            $stmt->execute();

            return Horaire::getRaw($pdo,$jourSemaine);
        }

        public static function modifieHoraire($pdo,$jourSemaine,$zone,$value){
            /**
             * Test impératif car le poste client peut envoyer les zones exactes correspondant au colonne de la base de donnée
             * et comme c'est nom pas valeur que l'on peut échapper mais un nom colonne, evidemment un nom de colonne NE PEUT ETRE echapper
             */
            if ($zone=='am_debut' || $zone=='am_fin' || $zone=='pm_debut' || $zone=="pm_fin"){
                /**
                 * Controle de la saisie du time https://digitalfortress.tech/tips/top-15-commonly-used-regex/
                 */
                if ($value == '' || preg_match('#^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$#', $value)){

                    $raw = Horaire::getRaw($pdo,$jourSemaine);
                    switch ($zone){
                        case 'am_debut':
                            $ok = ($raw['am_fin']=='' || $raw['am_fin'] > $value || $value == '');
                            break;
                        case 'am_fin':
                            $ok = ($raw['am_debut']=='' || $raw['am_debut'] < $value || $value == '');
                            break;
                        case 'pm_debut':
                            $ok = ($raw['pm_fin']=='' || $raw['pm_fin'] > $value || $value == '');
                            break;
                        case 'pm_fin':
                            $ok = ($raw['pm_debut']=='' || $raw['pm_debut'] < $value || $value == '');
                            break;
                        default:
                            $ok = false;
                            break;
                    }

                    if ($ok){
                        $sql = "update horaire set $zone = ".($value == '' ? "NULL" : $pdo->quote($value))." where jour_semaine = ".$jourSemaine;
                        
                        $stmt= $pdo->prepare($sql);
                        $stmt->execute();
                        return Horaire::getRaw($pdo,$jourSemaine);
                    }
                }
            }
            return null;
        }
    }
?>