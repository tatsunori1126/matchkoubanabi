<?php get_header(); ?>
<main class="l-main p-main">
    <div class="c-page__section-title-wrapper">
        <div class="c-page__section-title">トピックス</div>
    </div>
    <div class="p-topics">
        <div class="c-inner">
            <?php
            // WordPress ループ開始
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- 投稿タイトル -->
                <header class="p-topics__entry-header">
                    <h1 class="p-topics__entry-title"><?php the_title(); ?></h1>
                </header>
                <div class="p-topics__single-post-category-box">
                    <time class="p-topics__post-date"><?php the_time('Y / n / j'); ?></time>
                    <?php
                    // カテゴリー名を表示
                    $categories = get_the_terms($post->ID, 'topics_category');
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            echo '<span class="p-topics__post-category">' . esc_html($category->name) . '</span>';
                        }
                    }
                    ?>
                </div>
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full', array('class' => 'p-topics__contents-img')); ?>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.jpg" alt="" class="p-topics__contents-img" />
                <?php endif; ?>
                <div class="p-topics__contents">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
                endwhile; // ループ終了
            endif;
            ?>
            <div class="c-single__pagenavi-box">
                <?php if (get_previous_post()): ?>
                    <div class="post-previous"><?php previous_post_link('%link', '<i class="fa-solid fa-chevron-left"></i> <div class="post-previous-text">BACK</div>'); ?></div>
                <?php endif; ?>
                <div class="c-single__pagenavi-return-box">
                    <a class="c-single__pagenavi-return" href="<?php echo get_post_type_archive_link('topics'); ?>">一覧へ戻る</a>
                </div>
                <?php if (get_next_post()): ?>
                    <div class="post-next"><?php next_post_link('%link', '<div class="post-next-text">NEXT</div> <i class="fa-solid fa-chevron-right"></i>'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>