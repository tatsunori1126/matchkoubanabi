<?php get_header(); ?>
<main class="l-main p-main">
    <div class="c-page__section-title-wrapper">
        <h1 class="c-page__section-title">企業一覧</h1>
    </div>
    <div class="p-company">
        <div class="c-inner">
            <!-- ▼ フィルタ切り替えボタン -->
            <div class="p-company__filter-toggle">
                <button id="js-filter-all-btn" class="p-company__filter-toggle-btn active">全て</button>
                <button id="js-filter-toggle-btn" class="p-company__filter-toggle-btn">地域・業種から選ぶ</button>
            </div>
            <!-- ▼ 絞り込みパネル -->
            <div class="p-company__filter-panel" id="js-filter-panel">
                <div class="p-company__filter-block">
                    <h2 class="p-company__filter-title">地域から選ぶ</h2>
                    <div class="p-company__terms">
                    <?php
                    $areas = get_terms([
                        'taxonomy'   => 'area',
                        'hide_empty' => false,
                        'orderby'    => 'id',
                        'order'      => 'ASC',
                    ]);

                    if (!empty($areas)) :
                        foreach ($areas as $area) :
                        if ($area->parent !== 0) { // ✅ 子タームのみ表示
                            echo '<a href="' . esc_url(get_term_link($area)) . '" class="p-company__term-btn">' . esc_html($area->name) . '</a>';
                        }
                        endforeach;
                    endif;
                    ?>
                    </div>
                </div>
                <div class="p-company__filter-block">
                    <h2 class="p-company__filter-title">業種から選ぶ</h2>
                    <div class="p-company__terms">
                    <?php
                    $industries = get_terms([
                        'taxonomy'   => 'industry',
                        'hide_empty' => false,
                        'orderby'    => 'id',
                        'order'      => 'ASC',
                    ]);

                    if (!empty($industries)) :
                        foreach ($industries as $industry) :
                        if ($industry->parent !== 0) { // ✅ 子タームのみ表示
                            echo '<a href="' . esc_url(get_term_link($industry)) . '" class="p-company__term-btn">' . esc_html($industry->name) . '</a>';
                        }
                        endforeach;
                    endif;
                    ?>
                    </div>
                </div>
            </div>


            <!-- ▼ 企業一覧 -->
            <div class="p-company__container">
                <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = array(
                'post_type'      => 'company',
                'post_status'    => 'publish',
                'posts_per_page' => 12,
                'paged'          => $paged,
                );
                $the_query = new WP_Query($args);
                ?>

                <?php if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <?php
                    $company_image_id = get_field('company_image');
                    $address          = get_field('company_address');
                    $tel              = get_field('company_tel');
                    $site             = get_field('company_site');
                    $area_terms       = get_the_terms(get_the_ID(), 'area');
                    $industry_terms   = get_the_terms(get_the_ID(), 'industry');
                    $area_name        = $area_terms ? esc_html($area_terms[0]->name) : '';
                    $industry_name    = $industry_terms ? esc_html($industry_terms[0]->name) : '';
                ?>
                <div class="p-company__wrapper">
                    <div class="p-company__box">
                        <div class="p-company__item-img-wrapper">
                        <?php if ($company_image_id) : ?>
                            <?php echo wp_get_attachment_image($company_image_id, 'medium', false, [
                            'class' => 'p-company__item-img',
                            'alt'   => get_the_title()
                            ]); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="マッチ工場ナビ" class="p-company__item-img no-image" />
                        <?php endif; ?>
                        </div>

                        <div class="p-company__item-detail-wrapper">
                            <h2 class="p-company__item-title"><?php the_title(); ?></h2>
                            <ul class="p-company__item-info">
                                <?php if ($area_name) : ?><li><div class="p-company__item-sub-title">地域：</div><div class="p-company__item-action"><?php echo $area_name; ?></div></li><?php endif; ?>
                                <?php if ($industry_name) : ?><li><div class="p-company__item-sub-title">業種：</div><div class="p-company__item-action"><?php echo $industry_name; ?></div></li><?php endif; ?>
                                <?php if ($address) : ?><li><div class="p-company__item-sub-title">住所：</div><div class="p-company__item-action"><?php echo esc_html($address); ?></div></li><?php endif; ?>
                                <?php if ($tel) : ?><li><div class="p-company__item-sub-title">電話番号：</div><a class="p-company__item-action" href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $tel)); ?>"><?php echo esc_html($tel); ?></a></li><?php endif; ?>
                                <?php if ($site) : ?><li><div class="p-company__item-sub-title">ホームページ：</div><a class="p-company__item-action" href="<?php echo esc_url($site); ?>" target="_blank" rel="noopener"><?php echo esc_html($site); ?></a></li><?php endif; ?>
                            </ul>
                            <a class="c-btn p-company__btn" href="<?php the_permalink(); ?>">詳しくみる</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php else : ?>
                <p class="m-none-post-text">該当する記事がありません。</p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <div class="c-arrow">
                <div class="c-pagination">
                <?php if (function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
