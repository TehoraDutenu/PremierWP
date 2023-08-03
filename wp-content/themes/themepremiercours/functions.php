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
    // On va appeler et surcharger la méthode start_el()
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



// SHORTCODE

// 1er exemple : shortcode sans paramètre
function monShortCode()
{
    // on retourne le shortcode que l'on souhaite afficher
    return "<div class='alert alert-success'>Mon super shortcode</div>";
}
// on ajoute le shortcode à notre thème
add_shortcode('monShort', 'monShortCode');


// 2è exemple : shortcode avec paramètre
function monShortPromo($atts) // on ajoute un paramètre
{
    // on va déclarer une variable, ici $a
    // on utilise la fonction WP 'shortcode_atts()" 
    // pour attribuer une valeur par défaut à notre paramètre
    $a = shortcode_atts(['percent' => 10], $atts);
    // on retourne le shortcode qu l'on souhaite afficher
    // la variable se met { }
    return "<div class='alert alert-success'>Promo de {$a['percent']}%</div>";
}
// on ajoute le shortcode à notre thème
add_shortcode('promo', 'monShortPromo');



// WIDGET
// fonction pour enregistrer le widget
function register_custom_widget_area()
{
    register_sidebar(
        array(
            'id' => 'new_widget_area',
            'name' => ('New Widget Area'),
            'description' => __('Widget area for the sidebar'),
            'before_widget' => '<div class="widget_content">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget_title">',
            'after_widget' => '</h3>'
        )
    );
}

// initialisation du widget
add_action('widgets_init', 'register_custom_widget_area');
