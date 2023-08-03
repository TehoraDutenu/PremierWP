<?php get_header();

// affichage de la page d'accueil
// si je suis dans la page d'accueil je l'affiche
if (is_page()) {
    // on affiche le contenu de la page d'accueil
    // si j'ai des posts ou pages à afficher
    if (have_posts()) {
        // je boucle dessus
        while (have_posts()) {
            // je récupère les données du post (ou de la page)
            the_post();
            // j'affiche le titre dans une balise h1
            the_title("<h1>", "</h1>");
            // j'affiche le contenu du post
            the_content();
        }
    }
} else if (is_shop()) {
    // si on est dans la boutique
    // je récupère le contenu général de la page 
    wc_get_template_part("archive", "product");
}


?>





<?php get_footer(); ?>