<?php get_header(); ?>
<main class="l-main p-main">
    <div class="c-page__section-title-wrapper">
        <h1 class="c-page__section-title">企業一覧</h1>
    </div>
    <div class="p-company">
        <div class="c-inner">
            <div class="p-company__container">
                <?php
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'company',
                        'posts_per_page' => 12,
                        'paged' => $paged,
                    );
                    $the_query = new WP_Query($args);
                ?>
                <?php
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        // ACFの画像フィールドを取得（返り値 = 画像ID）
                        $company_image_id = get_field('company_image');
                    ?>
                    <a class="p-company__wrapper" href="<?php the_permalink(); ?>">
                        <div class="p-company__box">
                            <?php if ( $company_image_id ) : ?>
                                <?php echo wp_get_attachment_image( $company_image_id, 'medium', false, [
                                    'class' => 'p-company__item-img',
                                    'alt'   => get_the_title()
                                ] ); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="マッチ工場ナビ" class="p-company__item-img no-image" />
                            <?php endif; ?>
                            <div class="p-company__item-detail-wrapper">
                                <h2 class="p-company__item-title"><?php the_title(); ?></h2>
                            </div>
                        </div>
                    </a>
                    <?php
                    endwhile;
                else :
                    // 該当する記事がない場合の表示
                    echo '<p class="m-none-post-text">該当する記事がありません。</p>';
                endif;
                ?>

                <?php wp_reset_postdata(); ?>
            </div>
            <div class="c-arrow">
                <div class="c-pagination">
                    <?php if ( function_exists( 'wp_pagenavi' ) ) { wp_pagenavi(); } ?>
                    <?php wp_link_pages(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>