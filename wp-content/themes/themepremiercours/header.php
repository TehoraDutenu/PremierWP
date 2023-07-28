<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thème custom</title>

    <!-- import de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- on importe notre css -->
    <!-- <link rel="stylesheet" href=<?php // echo get_stylesheet_uri(); 
                                        ?>"> -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . "/style.css"; ?>">
</head>

<body>
    <!-- partie réservé au header -->
    <header class="bg-success text-white p-3">
        <a class="text-light" href="<?php echo get_bloginfo('wpurl') ?>">
            <h2><?php echo get_bloginfo('name') ?> </h2>
        </a>
        <em class="blog-description"><?php echo get_bloginfo('description') ?> </em>

        <!-- On affiche le menu -->
        <?php wp_nav_menu(array(
            "theme_location" => "menu-sup", // on indique le menu à afficher
            "container" => "nav", // on indique que le menu sera dans une balise nav
            "container_class" => "navbar navbar-expand-sm navbar-light", // on ajoute des class bootstrap
            "menu_class" => "navbar-nav me-auto", // on ajoute des class bootstrap
            "menu_id" => "menu-principal", // on ajoute un id
            "walker" => new Simple_menu() // récupération de notre template du menu
        )) ?>

    </header>