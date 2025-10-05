<?php get_header(); ?>
<main class="l-main p-main">
    <div class="p-application__inner">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php the_content(); // ← これがないとショートコードが実行されません ?>
        <?php endwhile; endif; ?>
    </div>
</main>
<?php get_footer(); ?>