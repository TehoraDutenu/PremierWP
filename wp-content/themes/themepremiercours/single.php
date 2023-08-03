    <!-- on appelle notre header -->
    <?php get_header(); ?>

    <!-- partie réservé au main -->
    <main>
        <h2>
            C'est mon article
        </h2>
        <div class="d-flex">
            <div class="col-sm-8 bloc-main bg-secondary">
                <?php
                // SI j'ai au moins un post, je boucle dessus pour récupérer chaque post
                if (have_posts()) : while (have_posts()) : the_post();
                        get_template_part('content', 'single', get_post_format());
                    // on ferme la boucle while
                    endwhile;
                // on ferme la condition
                endif;

                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>

    </main>

    <!-- on appelle notre footer -->
    <?php get_footer(); ?>