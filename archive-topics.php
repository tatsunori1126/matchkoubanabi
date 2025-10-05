<?php get_header(); ?>
<main class="l-main p-main">
    <div class="c-page__section-title-wrapper">
        <h1 class="c-page__section-title">トピックス</h1>
    </div>
    <div class="p-topics">
        <div class="c-inner">
            <ul class="p-topics__category-container">
                <!-- すべて（アーカイブページへのリンク） -->
                <li>
                    <a class="p-topics__category-link p-topics__category-link-all<?php if (is_post_type_archive('topics')) echo ' active'; ?>" href="<?php echo get_post_type_archive_link('topics'); ?>">
                        全て
                    </a>
                </li>
        
                <?php
                // voice_categoryのターム（カテゴリ）を取得
                $categories = get_terms('topics_category');
                
                // カテゴリをループで表示
                if (!empty($categories) && !is_wp_error($categories)) {
                    foreach ($categories as $category) {
                        // 現在のタームかどうかをチェック
                        $active_class = '';
                        if (is_tax('topics_category', $category->slug)) {
                            $active_class = ' active'; // 現在のタームに「active」クラスを追加
                        }
        
                        echo '<li><a class="p-topics__category-link' . $active_class . '" href="' . get_term_link($category) . '">' . esc_html($category->name) . '</a></li>';
                    }
                }
                ?>
            </ul>
            <div class="p-topics__contents-container">
                <?php
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'topics',
                        'posts_per_page' => 16,
                        'paged' => $paged,
                    );
                    $the_query = new WP_Query($args);
                ?>
                <?php
                if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
                ?>
                <a class="p-topics__contents-wrapper" href="<?php the_permalink(); ?>">
                    <div class="p-topics__contents-img-wrapper">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('full', array('class' => 'p-topics__contents-img')); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.jpg" alt="Dance Studio XD" class="p-topics__contents-img no-image" />
                        <?php endif; ?>
                        <div class="p-topics__contents-category-box">
                            <?php
                            $terms = get_the_terms( get_the_ID(), 'topics_category' );
                            if ( $terms && ! is_wp_error( $terms ) ) {
                                echo '<ul class="p-topics__item-categories">';
                            foreach ( $terms as $term ) {
                                echo '<li><span class="p-topics__contents-category"' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</span></li>';
                            }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="p-topics__contents-text-box">
                        <time class="p-topics__contents-date"><?php the_time('Y.n.j'); ?></time>
                        <h2 class="p-topics__contents-title"><?php the_title(); ?></h2>
                    </div>
                </a>
                <?php
                    endwhile;
                else :
                    // 該当する記事がない場合の表示
                    echo '<p class="none-post-text">該当する記事がありません。</p>';
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