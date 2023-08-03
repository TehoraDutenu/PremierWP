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
// on design un menu qui gère les sous-menus
class Depth_menu extends Walker_Nav_Menu
{
    // fonction pour démarrer le niveau de menu
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= "<ul class='sub-menu'>"; // on ouvre une ul
    }

    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        // on récupère les titres
        $title = $data_object->title;

        // on récupère les liens
        $permalink = $data_object->url;

        // on gère l'indentation des liens
        $indentation = str_repeat("\t", $depth);

        // les css à ajouter
        $classes = empty($data_object->classes) ? array() : (array) $data_object->classes;
        $class_name = join(' ', apply_filters('nav_menu_css_array', array_filter($classes), $data_object));

        if ($depth > 0) {
            $output .= $indentation . '<li class= "' . esc_attr($class_name) . '">'; // esc_attr pour échapper les caractères spéciaux
        } else {
            $output .= '<li class= "' . esc_attr($class_name) . '">'; // esc_attr pour échapper les caractères spéciaux
        }

        $output .= '<a href="' . $permalink . '">' . $title . '</a>';
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= "</li>"; // on ferme le li
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= "</ul>"; // on ferme la ul
    }
}

// ajout de la fonctionnalité 'logo' pour changer l'image du header
function custom_header_logo()
{
    $args = [
        "default-image" => get_template_directory_uri() . "/img/banniere.jpeg",
        "default-text-color" => "000",
        "width" => 1000,
        "height" => 250,
        "flex-width" => true,
        "flex-height" => true
    ];
    // add_theme_support : 1er argument, le nom de la fonctionnalité, le 2nd le tableau de paramètres
    add_theme_support("custom-header", $args);
}
// add_action : 1, le hook, 2, le nom de la fonction
add_action("after_setup_theme", "custom_header_logo");
