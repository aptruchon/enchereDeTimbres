<?php
class EnchereModele extends AccesBd
{
    /**
     * Cherche un enregistrement de timbres/encheres
     */
    public function un($idTimbre)
    {
        
        return $this->lireUn('SELECT tim.*, enc.*, img_nom, cat_nom, mis_miseActuelle
                              FROM timbre tim
                              JOIN enchere enc ON enc_id = tim_enc_id_ce
                              JOIN image ON img_tim_id_ce = tim_id
                              JOIN categorie ON cat_id = tim_cat_id_ce
                              JOIN (SELECT MAX(mis_miseActuelle) AS mis_miseActuelle, mis_enc_id_ce
                                        FROM mise
                                        GROUP BY mis_enc_id_ce)
                                AS sq
                                ON mis_enc_id_ce = enc_id
                              WHERE tim_id = '.$idTimbre.'
                              ');
    }



    /**
     * Cherche tout les enregistrements de timbres/encheres
     */
    public function tout()
    {
        return $this->lireTout('SELECT tim.*, enc.*, img.*, mis_miseActuelle
                                FROM timbre tim
                                JOIN image img ON img_tim_id_ce = tim_id
                                JOIN enchere enc ON enc_id = tim_enc_id_ce
                                JOIN (SELECT MAX(mis_miseActuelle) AS mis_miseActuelle, mis_enc_id_ce
                                        FROM mise
                                        GROUP BY mis_enc_id_ce)
                                AS sq
                                ON mis_enc_id_ce = enc_id
                                WHERE enc_dateDebut < NOW()
                                AND enc_dateFin > NOW()
                                ORDER BY tim_dateDeCreation DESC');
    }


    
    /**
     * Cherche tout les enregistrements de timbres/encheres par utilisateurs
     */
    public function encheresParUtilisateur($idUtilisateur)
    {
        return $this->lireTout('SELECT tim.*, enc.*, img.*
                                FROM timbre tim
                                JOIN image img ON img_tim_id_ce = tim_id
                                JOIN enchere enc ON enc_id = tim_enc_id_ce
                                WHERE tim_uti_id_ce =' .$idUtilisateur. '
                                ORDER BY tim_dateDeCreation DESC');
    }



    /**
     * Cherche un enregistrement de timbre/enchere par id
     */
    public function enchereParId($id)
    {
        $id = $id;
        return $this->lireUn('SELECT tim.*, enc.*, img.*
                                FROM timbre tim
                                JOIN image img ON img_tim_id_ce = tim_id
                                JOIN enchere enc ON enc_id = tim_enc_id_ce
                                WHERE tim_id =' .$id. '
                                ORDER BY tim_dateDeCreation DESC');
    }



    /**
     * Cherche la miseActuelle d'un timbre/enchere par id
     */
    public function miseActuelle($id)
    {
        return $this->lireUn('SELECT MAX(mis_miseActuelle) AS mis_miseActuelle
                                FROM mise
                                WHERE mis_enc_id_ce =' .$id. '
                                GROUP BY mis_enc_id_ce');
    }


    /**
     * Cherche tous les pays de la table pays
     */
    public function paysTout()
    {
        return $this->lireTout("SELECT * FROM pays ORDER BY pay_nom");
    }


    /**
     * Cherche toutes les catégories de la table categorie
     */
    public function categorieTout()
    {
        return $this->lireTout("SELECT * FROM categorie ORDER BY cat_nom");
    }


    /**
     * Cherche toutes les conditions de la table condition
     */
    public function conditionTout()
    {
        return $this->lireTout("SELECT tim_condition FROM timbre");
    }



    /**
     * Insertion d'une mise dans la table mise et incrémentation du nombre de mise dans la table enchere
     */
    public function mise($data, $idUti, $idEnchere)
    {
        extract($data);
        $idUtilisateur = (int)$_SESSION["utilisateur"]->uti_id;

        $this->creer("INSERT INTO mise (mis_uti_id_ce, mis_enc_id_ce, mis_miseActuelle) VALUES (:mis_uti_id_ce, :mis_enc_id_ce, :mis_miseActuelle)",
        [
            "mis_uti_id_ce" => htmlspecialchars($idUti),
            "mis_enc_id_ce" => htmlspecialchars($idEnchere),
            "mis_miseActuelle" => htmlspecialchars($mise)
        ]);
        
        $this->modifier("UPDATE enchere
                            SET 
                                enc_nombreDeMise = enc_nombreDeMise + 1
                            WHERE
                                enc_id = :enc_id",
                            [
                                "enc_id" => htmlspecialchars($idEnchere)
                            ]);
    }



    /**
     * Insertion d'une enchère ainsi que le timbre, la mise de départ et l'image associé à celle-ci 
     */
    public function ajout($data, $chemin)
    {
        extract($data);
        $idUtilisateur = (int)$_SESSION["utilisateur"]->uti_id;
        /* INSERT INTO enchere (enc_estimation, enc_dateDebut, enc_dateFin, enc_prixPlancher, enc_uti_id_ce) VALUES (12, '2018-06-12T19:30', '2018-06-22T19:30', 12, 1) */

        $dernierEnchereId = $this->creer("INSERT INTO enchere (enc_estimation, enc_dateDebut, enc_dateFin, enc_prixPlancher, enc_nombreDeMise, enc_uti_id_ce) VALUES (:enc_estimation, :enc_dateDebut, :enc_dateFin, :enc_prixPlancher, :enc_nombreDeMise, :enc_uti_id_ce)",
                        [   
                            "enc_estimation" => htmlspecialchars($enc_estimation),
                            "enc_dateDebut" => htmlspecialchars($enc_dateDebut),
                            "enc_dateFin" => htmlspecialchars($enc_dateFin),
                            "enc_prixPlancher" => htmlspecialchars($enc_prixPlancher),
                            "enc_nombreDeMise" => 0,
                            "enc_uti_id_ce" => htmlspecialchars($idUtilisateur)
                        ]);

        $this->creer("INSERT INTO mise (mis_uti_id_ce, mis_enc_id_ce, mis_miseActuelle) VALUES (:mis_uti_id_ce, :mis_enc_id_ce, :mis_miseActuelle)",
        [
            "mis_uti_id_ce" => htmlspecialchars($idUtilisateur),
            "mis_enc_id_ce" => htmlspecialchars($dernierEnchereId),
            "mis_miseActuelle" => 0
        ]);
        
        $dernierTimbreId = $this->creer("INSERT INTO timbre (tim_nom, tim_description, tim_dateDeCreation, tim_couleurs, tim_tirage, tim_dimensions, tim_condition, tim_certification, tim_enc_id_ce, tim_cat_id_ce, tim_pay_id_ce, tim_uti_id_ce) VALUES (:tim_nom, :tim_description, NOW(), :tim_couleurs, :tim_tirage, :tim_dimensions, :tim_condition, :tim_certification, :tim_enc_id_ce, :tim_cat_id_ce, :tim_pay_id_ce, :tim_uti_id_ce)",
                        [   
                            ":tim_nom" => htmlspecialchars($tim_nom),
                            ":tim_description" => htmlspecialchars($tim_description),
                            ":tim_couleurs" => htmlspecialchars($tim_couleurs),
                            ":tim_tirage" => htmlspecialchars($tim_tirage),
                            ":tim_dimensions" => htmlspecialchars($tim_dimensions),
                            ":tim_condition" => htmlspecialchars($tim_condition),
                            ":tim_certification" => htmlspecialchars($tim_certification),
                            ":tim_enc_id_ce" => htmlspecialchars($dernierEnchereId),
                            ":tim_cat_id_ce" => htmlspecialchars($cat_nom),
                            ":tim_pay_id_ce" => htmlspecialchars($pay_nom),
                            ":tim_uti_id_ce" => htmlspecialchars($idUtilisateur)
                        ]);

        $this->creer("INSERT INTO image (img_nom, img_tim_id_ce) VALUES (:img_nom, :img_tim_id_ce)",
                        [
                            ":img_nom" => htmlspecialchars($chemin),
                            "img_tim_id_ce" => htmlspecialchars($dernierTimbreId)
                        ]);
    }



    /**
     * Modification d'une enchère ainsi que le timbre et l'image associé à celle-ci 
     */
    public function modification($data, $chemin)
    {
        extract($data);
        
        $this->modifier("UPDATE enchere
                            SET 
                                enc_estimation = :enc_estimation,
                                enc_dateDebut = :enc_dateDebut,
                                enc_dateFin = :enc_dateFin,
                                enc_prixPlancher = :enc_prixPlancher
                            WHERE
                                enc_id = :enc_id",
                            [
                                "enc_estimation" => htmlspecialchars($enc_estimation),
                                "enc_dateDebut" => htmlspecialchars($enc_dateDebut),
                                "enc_dateFin" => htmlspecialchars($enc_dateFin),
                                "enc_prixPlancher" => htmlspecialchars($enc_prixPlancher),
                                "enc_id" => htmlspecialchars($enc_id)
                            ]);

        $this->modifier("UPDATE timbre
                            SET 
                                tim_nom = :tim_nom,
                                tim_description = :tim_description,
                                tim_couleurs = :tim_couleurs,
                                tim_tirage = :tim_tirage,
                                tim_dimensions = :tim_dimensions,
                                tim_condition = :tim_condition,
                                tim_certification = :tim_certification,
                                tim_cat_id_ce = :tim_cat_id_ce,
                                tim_pay_id_ce = :tim_pay_id_ce
                            WHERE
                                tim_id = :tim_id",
                            [
                                "tim_nom" => htmlspecialchars($tim_nom),
                                "tim_description" => htmlspecialchars($tim_description),
                                "tim_couleurs" => htmlspecialchars($tim_couleurs),
                                "tim_tirage" => htmlspecialchars($tim_tirage),
                                "tim_dimensions" => htmlspecialchars($tim_dimensions),
                                "tim_condition" => htmlspecialchars($tim_condition),
                                "tim_certification" => htmlspecialchars($tim_certification),
                                "tim_cat_id_ce" => htmlspecialchars($cat_nom),
                                "tim_pay_id_ce" => htmlspecialchars($pay_nom),
                                "tim_id" => htmlspecialchars($tim_id)
                            ]);

        //Requête UPDATE avec image
        if($chemin !== ""){
            // Suppression de l'enregistrement de la table image qu'on ne veut plus utiliser
            $this->supprimer("DELETE FROM image WHERE img_tim_id_ce = :img_tim_id_ce",
            [
                "img_tim_id_ce" => htmlspecialchars($tim_id)
            ]);
            
            // Chargement du nouveau path dans la table image
            $this->creer("INSERT INTO image (img_nom, img_tim_id_ce) VALUES (:img_nom, :img_tim_id_ce)",
                            [
                                ":img_nom" => htmlspecialchars($chemin),
                                "img_tim_id_ce" => htmlspecialchars($tim_id)
                            ]);
        }
    }



    /**
     * Méthode qui prépare une transaction sql de type DELETE pour supprimer une enchère ainsi que le timbre, les mises et image associé
     * 
     */
    public function suppression($timbreId, $enchereId)
    {
        $this->supprimer("  BEGIN;
                                DELETE FROM mise WHERE mis_enc_id_ce = :mis_enc_id_ce;
                                DELETE FROM image WHERE img_tim_id_ce = :img_tim_id_ce;
                                DELETE FROM timbre WHERE tim_id = :tim_id;
                                DELETE FROM enchere WHERE enc_id = :enc_id;
                            COMMIT",
                        [   
                            'mis_enc_id_ce' => $enchereId,
                            'img_tim_id_ce' => $timbreId,
                            'tim_id' => $timbreId,
                            'enc_id' => $enchereId
                        ]);
    }
}