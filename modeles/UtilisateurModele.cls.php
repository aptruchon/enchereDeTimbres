<?php
class UtilisateurModele extends AccesBd
{
    /**
     * Méthode qui prépare une requête pour aller chercher toutes les informations de la table utilisateur pour un courriel donné
     * 
     * @param $courriel string
     */
    public function un($courriel)
    {
        return $this->lireUn("SELECT * FROM utilisateur 
                                WHERE uti_courriel=:email"
                        , ['email'=>$courriel]);
    }


    /**
     * Méthode qui prépare une requête sql avec les données reçus via $utilisateur (POST), pour l'ajout d'un utilisateur
     * + hashing du mdp
     * 
     * @param $utilisateur array
     */
    public function ajout($utilisateur)
    {
        extract($utilisateur);
        $cc = uniqid("stampee", true);
        $this->creer("INSERT INTO utilisateur VALUES (0, :prenom, :nom, :courriel, :mdp, NOW(), '$cc', 2)",
                    [
                        ":prenom" => $prenom,
                        ":nom" => $nom,
                        ":courriel" => $courriel,
                        ":mdp"      => password_hash($mdp, PASSWORD_DEFAULT)
                    ]
                    );
    }

        /**
     * Modifier un utilisateur pour vider le code de confirmation.
     * @param string $cc Code de confirmation.
     */
    public function confirmer($cc)
    {
        $res = $this->modifier("UPDATE utilisateur SET uti_confirmation='' WHERE uti_confirmation=:cc"
                        , ['cc'  => $cc]);
        return $res;
    }
}