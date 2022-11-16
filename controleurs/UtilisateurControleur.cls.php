<?php
class UtilisateurControleur extends Controleur
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
        // Aucun code ici pour le moment...
    }

    
    /**
     * Méthode qui appelle la méthode ajout de UtilisateurModel en lui envoyant les données de formulaire en POST
     * et qui redirige vers utilisateur/index (Fenêtre de connexion)
     */
    public function inscription($params)
    {
        if(isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['courriel']) && isset($_POST['mdp'])){
            $regEx = "/(.+)@(.+){1,}\.(.+){1,}/";
            
            if(preg_match($regEx, $_POST['courriel'])){
                $this->modele->ajout($_POST);
                $message = "**Un courriel de confirmation vous a été envoyé**";
                $_SESSION['message'] = $message;
                Utilitaire::nouvelleRoute("utilisateur/connexion");
            }
            else {
                $erreur = "**Mauvais format d'adresse courriel**";
                $this->gabarit->affecter('erreur', $erreur);
            }
        }
    }


    /**
     * Méthode qui vérifie les informations de connexion récupéré en POST et qui traite les erreurs possibles
     */
    public function connexion()
    {
        if(isset($_SESSION['utilisateur'])) {
            Utilitaire::nouvelleRoute('enchere/portail');
        }
        else {
            if(isset($_POST['courriel']) && isset($_POST['mdp'])){
                $courriel = $_POST['courriel'];
                $mdp = $_POST['mdp'];
                $regEx = "/(.+)@(.+){1,}\.(.+){1,}/";
    
                if(preg_match($regEx, $courriel)){
                    $utilisateur = $this->modele->un($courriel);
                    $erreur = false;

                    if(!$utilisateur || !password_verify($mdp, $utilisateur->uti_mdp)) {
                        $erreur = "**Combinaison courriel/Mot de passe erronée**";
                        var_dump($erreur);
                    }
                    else if($utilisateur->uti_confirmation != '') {
                        $erreur = "**Compte non confirmé. Vérifiez vos courriels**";
                    }
                    
                    if(!$erreur) {
                        // Sauvegarder l'état de connexion
                        $_SESSION['utilisateur'] = $utilisateur;
                        unset($_SESSION["message"]);
            
                        // Rediriger vers accueil/index
                        Utilitaire::nouvelleRoute('enchere/portail');
                    }
                    else {
                        $this->gabarit->affecter('erreur', $erreur);
                    }
                }
                else {
                    $erreur = "**Mauvais format d'adresse courriel**";
                    $this->gabarit->affecter('erreur', $erreur);
                }
            }
        }
    }


    /**
     * Méthode qui met fin à la session utilisateur
     */
    public function deconnexion()
    {
        unset($_SESSION['utilisateur']);
        Utilitaire::nouvelleRoute('accueil');
    }
}