<?php
class Ern_Database_Service
{
    public function __construct()
    {
        // pour l'instant rien dedans        
    }


    // fonction qui va créer une nouvelle table dans la DB
    public static function create_db()
    {
        // on appelle la variable globale $wpdb
        global $wpdb;
        // création de la table en BDD
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}ern_client (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(150) NOT NULL,
            prenom VARCHAR(150) NOT NULL,
            email VARCHAR(150) NOT NULL,
            telephone VARCHAR(50) NOT NULL,
            fidelite BOOLEAN DEFAULT false)");

        // on regarde si la table contient des lignes (rows)
        $count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}ern_client");

        // si la table est vide je vais lui insérer des valeurs par défaut
        if ($count == 0) {
            $wpdb->insert("{$wpdb->prefix}ern_client", [
                "nom" => "Doe",
                "prenom" => "John",
                "email" => "john.doe@gmail.com",
                "telephone" => "0612345678",
                "fidelite" => true
            ]);
        }
    }

    // fonction qui vide la table lors de la désactivation du plugin
    // À NE PAS FAIRE EN CAS RÉEL

    public static function empty_db()
    {
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}ern_client");
    }

    // fonction qui supprime la table lors de la désinstallation du plugin
    public static function delete_db()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ern_client");
    }

    // fonction qui va récupérer tous les clients
    public function findAll()
    {
        global $wpdb;
        $res = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ern_client");
        return $res;
    }

    // fonction pour enregistrer un client
    public function save_client()
    {
        global $wpdb;
        // on va récupérer les données du formulaire dans une variable
        $data = [
            "nom" => $_POST["nom"],
            "prenom" => $_POST["prenom"],
            "email" => $_POST["email"],
            "telephone" => $_POST["telephone"],
            "fidelite" => $_POST["fidelite"]
        ];

        // on vérifie que le client n'existe pas déjà
        $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}ern_client WHERE email = '" . $data["email"] . "'");
        if (is_null($row)) {
            // si le client n'existe pas on l'insère dans la table
            $wpdb->insert("{$wpdb->prefix}ern_client", $data);
        } else {
            // TODO: : message d'erreur
        }
    }

    // fonction qui supprime un ou plusieurs clients
    public function delete_client($ids) // $ids est un tableau d'id
    {
        global $wpdb;
        // on check si $ids est dans un tableau, sinon on le met dans un tableau
        // pour avoir la possibilité de supprimer plusieurs clients
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        // effectuer la requête de suppression
        // implode : transforme un tableau en chaîne de caractères
        $wpdb->query("DELETE FROM {$wpdb->prefix}ern_client WHERE id IN (" . implode(",", $ids) . ")");
    }
}
