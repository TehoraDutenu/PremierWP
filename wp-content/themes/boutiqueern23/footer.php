<footer class="bg-success text-white p-3 flex-wrap">
    <div class="contact">
        <a class="text-dark" href="<?php echo get_bloginfo('wpurl') ?>">
            <h2><?php echo get_bloginfo('name') ?> </h2>
        </a>
        <p class="admin-email">Email <?php echo get_bloginfo('admin_email') ?> </p>
        <p class="admin-phone">Tel : 06 07 08 09 10</p>
    </div>

    <?php
    wp_nav_menu(array(
        "Footer menu" => __('Footer menu', 'generatepress'),
        "class" => 'footer-menu-class'
    ))
    ?>

</footer>
</body>

</html>