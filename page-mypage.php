<?php get_header(); ?>
<div class="p-application__inner">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>