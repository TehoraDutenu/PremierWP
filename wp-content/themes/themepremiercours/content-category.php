<!-- Template pour afficher la liste des articles d'une catégorie -->
<div>
    <h3><a href="<?php the_permalink() ?>"> <?php the_title() ?> </a></h3>

    <?php if ('post' == get_post_type()) : ?>
        <div class="blog-postmeta">
            <p class="post-date">
                <?php echo get_the_date() ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<div class="entry-summary">
    <!-- the_excerpt() est une fonction native qui permet d'afficher un extrait de l'article -->
    <?php the_excerpt() ?>
    <!-- on ajoute un bouton "voir plus..." pour lire l'intégralité du post -->
    <a href="<?php the_permalink() ?>">
        <!-- esc_html_e permet d'interpréter le code hexadécimal -->
        <?php esc_html_e("Lire plus &rarr;") ?>
    </a>
</div>