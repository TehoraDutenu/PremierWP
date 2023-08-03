<?php
/*  
Plugin Name: Plugin de l'ern23
Description: Plugin de l'ern23 qui va bien
Author: moi
Version: 1.0
*/

// on importe notre fichie ERN_Random_Photo_Widget.php
require_once plugin_dir_path(__FILE__) . "widget/Ern_Random_Photo_Widget.php";
// on importe notre fichier Ern_Databas_Service.php
require_once plugin_dir_path(__FILE__) . "service/Ern_Database_Service.php";
// on importe notre fichier Ern_list.php
require_once plugin_dir_path(__FILE__) . "Ern_list.php";


// création de la class du plugin
class Ern
{
    // appel du constructor
    public function __construct()
    {
        // fonction qui se charge dès l'instance de la classe

        // activation du plugin : création des tables à l'activation du plugin
        // __FILE__ : constante magique qui contient le chemin du fichier dans lequel on se trouve
        register_activation_hook(__FILE__, array("Ern_Database_Service", "create_db"));

        // désactivation du plugin : vidange des tables à la désactivation du plugin
        register_deactivation_hook(__FILE__, array("Ern_Database_Service", "empty_db"));

        // désinstallation du plugin : suppression des tables
        // ATTENTION LE PLUGIN SERA SUPPRIMÉ DU CODE SOURCE
        // register_uninstall_hook(__FILE__, array("Ern_Database_Service", "delete_db"));

        // on va enregistrer le widget
        add_action("widgets_init", function () {
            register_widget("Ern_Random_Photo_Widget");
        });

        // on va enregistrer le menu client
        add_action("admin_menu", array($this, "add_menu_client"));
    }

    // création d menu dans le backoffice pour gérer les clients
    public function add_menu_client()
    {
        // on a une méthode WP qui permet de le faire (elle attend 7 paramètres)
        // 1. titre de la page
        // 2. titre du menu
        // 3. droit admin
        // 4. slug
        // 5. callback
        // 6. icone du menu
        // 7. position dans le menu
        // liste des positions du menu :
        //  https://developer.wordpress.org/reference/functions/add_menu_page/
        add_menu_page(
            "Les clients de l'ERN", // titre de la page
            "Clients ERN", // titre de l'onglet
            "manage_options", // capacité de l'utilisateur à voir le menu
            "ern-clients", // slug de la page (construire l'url)
            array($this, "mesClients"), // callback qui va afficher la page ($this car on est dans la class Ern, mesClients() est la fonction de cette class)
            "dashicons-groups", // icon du menu
            "40" // position du menu
        );

        // on va ajouter un sous-menu pour ajouter un client
        // 1. son menu parent
        // 2. titre de la page
        // 3. titre du menu
        // 4. capabilité
        // 5. slug
        // 6. callback
        add_submenu_page(
            "ern-clients",
            "Ajouter un client",
            "Ajouter",
            "manage_options",
            "ern-client-add",
            array($this, "mesClients")
        );
    }

    // fonction d'affichage dans le menu
    public function mesClients()
    {
        // on va instancier la class Ern_Database_Service
        $db = new Ern_Database_Service();
        // on récupère le titre de la page
        echo "<h2>" . get_admin_page_title() . "</h2>";
        // on commence à construire la table avec des colonnes
        // si la page dans laquelle on est == ern-clients, on affiche la liste
        if ($_GET["page"] == "ern-clients" || $_POST["send"] == "ok" || $_POST["action"] == "delete-client") {
            // on va mettre une seconde condition
            // si les données du formulaire sont présentes on exécute la requête
            if (isset($_POST['send']) && $_POST['send'] == 'ok') {
                // on éxécute la méthode save_client
                $db->save_client();
            }

            // de la même manière que pour l'insertion
            // on utilise le flag action pour savoir si on doit supprimer ou pas
            if (isset($_POST['action']) && $_POST['action'] == 'delete-client') {
                // on éxécute la méthode delete_client
                $db->delete_client($_POST['delete-client']);
            }


            // on instancie la class Ern_list
            $table = new Ern_List();
            // on appelle la méthode prepare_items
            $table->prepare_items();
            // on génère le rendu HTML de la table grâce à la méthode display
            // que l'on imbrique dans le formulaire
            echo "<form method='post'>";
            $table->display();
            echo "</form>";



            // on va afficher le formulaire d'ajout de clients
            // echo "<table class='table-border'>";
            // echo "<tr>";
            // echo "<th>Nom</th>";
            // echo "<th>Prenom</th>";
            // echo "<th>Email</th>";
            // echo "<th>Téléphone</th>";
            // echo "<th>Fidélité</th>";
            // echo "<tr>";

            // // on boucle dans le tableau de clients pour afficher les clients
            // foreach ($db->findAll() as $client) {
            //     echo "<tr>";
            //     echo "<td>" . $client->nom . "</td>";
            //     echo "<td>" . $client->prenom . "</td>";
            //     echo "<td>" . $client->email . "</td>";
            //     echo "<td>" . $client->telephone . "</td>";
            //     echo "<td>" . (($client->fidelite == 0) ? "Client occasionnel" : "Client fidèle") . "</td>";

            //     // on ajoute un bouton pour supprimer le client
            //     echo "<td>";
            //     echo "<form method='post'>";
            //     echo "<input type='hidden' name='action' value='del' >";
            //     echo "<input type='hidden' name='id' value='" . $client->id . "' >";
            //     echo "<input type='submit' value='del' class='button button-secondary'>";
            //     echo "</form>";
            //     echo "</td>";

            //     echo "<tr>";
            // }
            // // on pense à fermer la table
            // echo "</table>";
        } else {
            // on crée le formulaire d'ajout de client
            echo "<form method='post'>";
            // on va ajouter un input de type hidden pour envoyer "ok" lorsqu'on poste le formulaire
            // cette valeur "ok" nous sert de flag pour faire du traitement
            echo "<input type='hidden' name='send' value='ok'>";
            // input nom
            echo "<div>" .
                "<label for='nom'>Nom</label>" .
                "<input type='test' name='nom' id='nom' class='widefat' required>" .
                "</div>";
            //input prenom
            echo "<div>" .
                "<label for='prenom'>Prénom</label>" .
                "<input type='test' name='prenom' id='prenom' class='widefat' required>" .
                "</div>";
            // input email
            echo "<div>" .
                "<label for='email'>Email</label>" .
                "<input type='test' name='email' id='email' class='widefat' required>" .
                "</div>";
            // input telephone
            echo "<div>" .
                "<label for='telephone'>Téléphone</label>" .
                "<input type='test' name='telephone' id='telephone' class='widefat' required>" .
                "</div>";
            // input fidelite
            echo "<div>" .
                "<label for='fidelite'>Fidélité</label>" .
                "<input type='radio' name='fidelite' class='widefat' value='0' checked>non" .
                "<input type='radio' name='fidelite' class='widefat' value='1' >oui" .
                "</div>";
            // submit
            echo "<div>" .
                "<input type='submit' value='Ajouter' class='button button-primary'>" .
                "</div>";
        }
    }
}

new Ern(); // on instancie la classe Ern