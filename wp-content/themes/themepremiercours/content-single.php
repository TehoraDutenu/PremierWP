<!-- Nous avons accès ici aux valeurs renvoyées par "the_post()"
On a donc accès à tous les champs de la table wp-posts
On peut donc afficher le titre, le contenu, la date, l'auteur, etc... 
-->

<a href="<?php the_permalink() ?>">
    <h4 class="text-primary blog-post-title">
        <?php the_title() ?>
    </h4>
</a>

<div class="mt-3">
    <?php the_date() ?> par <a href="#"> <?php the_author() ?> </a>
</div>

<div class="mt-3">
    <p>Catégorie : <?php the_category() ?> </p>
</div>

<?php if (has_tag()) : ?>
    <p>Tags : <?php the_tags() ?> </p>
<?php endif; ?>

<div class="mt-3">
    <p> <?php the_content() ?> </p>
</div>