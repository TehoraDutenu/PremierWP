<div class="col-sm-3 offset-1 bg-warning">
    <div class="sidebar-module sidebar-module-insert">

        <?php if (is_single()) :  ?> <!-- is_single permet de savoir si on est dans le détail d'un post -->

            <h5>À propos</h5>
            <!-- ici on affiche la biographie de l'auteur -->
            <p>
                <?php the_author_meta('description'); ?>
            </p>

            <!-- Montrer tous les articles de l'auteur -->
            <h5>Articles du même auteur</h5>

            <ol class="list-unstyled">
                <!-- On doit intérroger la BDD pour récupérer les posts de l'auteur -->

                <?php
                $author_post = new WP_Query(array(  // WP_Query permet de construire une requête personnalisée
                    'author' => get_the_author_meta('ID')
                    // Va chercher tous les articles du même auteur 
                    // pourrait se traduire par :
                    // SELECT * FROM wp_posts WHERE post_author = id
                ));
                while ($author_post->have_posts()) : $author_post->the_post();
                ?>
                    <li>
                        <!-- the_permalink() permet de récupérer le lien vers le post -->
                        <!-- the_title() permet de récupérer le titre du post -->
                        <a href="<?php the_permalink() ?>"><?php the_title() ?> </a>
                    </li>

                <?php endwhile; ?>

            </ol>
        <?php endif; ?>

        <h5>Archives</h5>
        <!-- ici on affiche les archives des posts -->
        <?php wp_get_archives('type=monthly'); ?>
    </div>
</div>