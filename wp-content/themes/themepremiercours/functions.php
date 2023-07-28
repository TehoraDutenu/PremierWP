<?php

// Création d'un menu de navigation
// 1. On enregistre le menu
// 2. On initialise le menu
// 3. On l'active et on le configure dans le BO
// 4. On design le menu

// 1. ON ENREGISTRE LE MENU

function register_menu()
{
    // Fonction native de Wordpress qui permet d'enregistrer le menu
    register_nav_menus(
        array(
            'menu-sup' => __('Main menu'), // __() permet de traduire le mot dans les différents langages
            'menu-footer' => __('Footer menu')

        )
    );
}


// 2. ON INITIALISE LE MENU

add_action('init', 'register_menu');

// add_action permet d'exécuter une fonction à un moment précis
// 1er paramètre : le hook 'ini' permet d'exécuter la fonction au moment de l'initialisation du thème
// 2eme paramètre : le nom de la fonction à exécuter


// 3. ON L'ACTIVE ET ON LE CONFIGURE DANS LE BACK-OFFICE



// 4. ON DESIGN LE MENU
class Simple_menu extends Walker_Nav_Menu
{
    // On va appeler et surcherger la méthode start_el()
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        // $output : ce qui va être affiché (template)
        // $data_object : servira à récupérer les infos du menu (titre, lien, etc..)

        // 1. On récupère les datas du menu dans des variables
        $title = $data_object->title; // récupère les titres du menu
        $permalink = $data_object->url; // récupère les liens du menu

        // 2. On construit le template
        $output .= "<div class='nav-item'>"; // on ouvre une div
        $output .= "<a class='nav-link' href='$permalink'>"; // on ouvre un a et lui donne le $permalien
        $output .= $title; // on affiche le titre
        $output .= "</a>"; // on ferme le a
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= "</div>"; // on referme la div
    }
}
