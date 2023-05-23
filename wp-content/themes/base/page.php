<?php
get_header();
while(have_posts()):the_post();
?>

<?php if(is_page('quem-somos')) : ?>

    <?php get_template_part('contents/content','quem-somos'); ?>

<?php elseif (is_page('servicos')) : ?>

    <?php get_template_part('contents/content','servicos'); ?>

<?php elseif (is_page('promocoes')) : ?>

    <?php get_template_part('contents/content','promocoes'); ?>

<?php elseif (is_page('dicas')) : ?>

    <?php get_template_part('contents/content','dicas'); ?>

<?php elseif (is_page('parceiros')) : ?>

    <?php get_template_part('contents/content','parceiros'); ?>

<?php elseif (is_page('contato')) : ?>

    <?php get_template_part('contents/content','contato'); ?>

<?php endif;
endwhile; ?>

<?php get_footer(); ?>

