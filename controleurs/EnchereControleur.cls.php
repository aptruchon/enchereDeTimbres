<?php

use FFI\CData;

class EnchereControleur extends Controleur
{

    function __construct($modele, $module, $action)
    {
        parent::__construct($modele, $module, $action);
    }



    /**
     * Méthode invoquée par défaut si aucune action n'est indiquée
     */
    public function index($params)
    {
        $this->gabarit->affecterActionParDefaut('tout');
        $this->tout($params);
    }



    /**
     * Méthode qui vas chercher toutes les enchères d'un utilisateur du membre et qui les affiches dans une vue.
     */
    public function portail()
    {
        $idUtilisateur = (int)$_SESSION["utilisateur"]->uti_id;
        $this->gabarit->affecter('encheres', $this->modele->encheresParUtilisateur($idUtilisateur));
    }



    /**
     * 'Méthode qui retourne toutes les informations par timbre sélectionné
     */
    public function un($params)
    {
        $idTimbre = $params[0];
        $this->gabarit->affecter('enchere', $this->modele->un($idTimbre));
    }



    /**
     * Méthode qui retourne toutes les enchères en cours dans une variables encheres
     */
    public function tout($params)
    {
        $this->gabarit->affecter('encheres', $this->modele->tout());
    }



    /**
     * Méthode qui ajoute une enchère à la DB
     */
    public function ajout($params)
    {
        if(!empty($_POST) && !empty($_FILES)){
            $name = $_FILES["img_nom"]["name"];
            $fichier = $_FILES["img_nom"]["tmp_name"];
            $chemin = "./ressources/img/photos/timbres/$name";

            if(move_uploaded_file($fichier, $chemin)){
                $this->modele->ajout($_POST, $chemin);
                Utilitaire::nouvelleRoute('enchere/portail');
            }
        }
        else {
            // Affectation de variables pour populer les inputs select du formulaire avec les informations actuelles de la DB
            $this->gabarit->affecter('pays', $this->modele->paysTout());
        
            $this->gabarit->affecter('categories', $this->modele->categorieTout());
            
            $this->gabarit->affecter('conditions', $this->modele->conditionTout());
        }
    }



    /**
     * Méthode qui modifie une enchère et les informations d'un timbre
     */
    public function modification()
    {
        // AJOUTER VALIDATION UTILISATEUR
        if(!empty($_POST)){
            // Scénario où l'utilisateur ne change pas la photo
            if($_FILES["img_nom"]["name"] == ""){
                $chemin = "";
                $this->modele->modification($_POST, $chemin);
                Utilitaire::nouvelleRoute('enchere/portail');
            }
            // Scénario où l'utilisateur change la photo
            else {
                $name = $_FILES["img_nom"]["name"];
                $fichier = $_FILES["img_nom"]["tmp_name"];
                $chemin = "./ressources/img/photos/timbres/$name";

                if(move_uploaded_file($fichier, $chemin)){
                    $this->modele->modification($_POST, $chemin);
                    Utilitaire::nouvelleRoute('enchere/portail');
                }
            }
        }
        else {
            $idTimbre = $_GET["tId"];
            $tim_uti_id_ce = $this->modele->un($idTimbre)->tim_uti_id_ce;

            // VALIDATION UTILISATEUR (un utilisateur ne peut que modifier les timbres qu'il a créé)
            if($tim_uti_id_ce === $_SESSION["utilisateur"]->uti_id){
                // Affectation de variables pour populer le formulaire avec les informations actuelles du timbre/enchère
                $this->gabarit->affecter('pays', $this->modele->paysTout());
                
                $this->gabarit->affecter('categories', $this->modele->categorieTout());
                
                $this->gabarit->affecter('conditions', $this->modele->conditionTout());
            
                $this->gabarit->affecter('enchere', $this->modele->enchereParId($idTimbre));
            }
            else {
                // Redirection si la validation a échoué
                Utilitaire::nouvelleRoute('accueil/index');
            }
        }
    }



    /**
     * Méthode qui supprime une enchère, son timbre, images et mises associé à celle-ci
     */
    public function suppression()
    {
        $idTimbre = $_GET["tId"];
        $tim_uti_id_ce = $this->modele->un($idTimbre)->tim_uti_id_ce;
        
        // VALIDATION UTILISATEUR (un utilisateur ne peut que supprimer les timbres qu'il a créé)
        if($tim_uti_id_ce === $_SESSION["utilisateur"]->uti_id){
            $enchereId = $_GET["eId"];
            
            $this->modele->suppression($idTimbre, $enchereId);
            Utilitaire::nouvelleRoute('enchere/portail');
        }
        else {
            // Redirection si la validation a échoué
            Utilitaire::nouvelleRoute('accueil/index');
        }
    }



    /**
     * Méthode qui effectue une mise sur une enchère
     */
    public function mise($params)
    {
        if(isset($_SESSION["utilisateur"])){
            $idUti = $params[0];
            $idEnchere = $params[1];
            $idTimbre = $params[2];
            $miseActuelle = $this->modele->miseActuelle($idEnchere)->mis_miseActuelle;
            $mise = $_POST["mise"];
    
            // Vérification que la mise entré par l'utilisateur soit plus grande que la miseActuelle dans la DB
            if($mise > $miseActuelle){
                $this->modele->mise($_POST, $idUti, $idEnchere);
                Utilitaire::nouvelleRoute("enchere/un/$idTimbre");
                die();
            }
            Utilitaire::nouvelleRoute("enchere/un/$idTimbre&maj=oui");
        }
        else {
            // Redirection si la validation a échoué
            Utilitaire::nouvelleRoute("utilisateur/connexion");
        }
    }
}