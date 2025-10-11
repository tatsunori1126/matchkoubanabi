<?php get_header(); ?>
<main class="l-main p-main">
  <div class="c-page__section-title-wrapper">
    <h1 class="c-page__section-title">採用情報一覧</h1>
  </div>

  <div class="p-recruit">
    <div class="c-inner">
      <div class="p-recruit__container">
        <?php
          $paged = get_query_var('paged') ? get_query_var('paged') : 1;
          $args = array(
            'post_type' => 'recruit',
            'posts_per_page' => 12,
            'paged' => $paged,
            'post_status' => 'publish'
          );
          $the_query = new WP_Query($args);
        ?>

        <?php if ( $the_query->have_posts() ) : ?>
          <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <?php
              // アイキャッチ画像を取得
              $recruit_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');

              // タクソノミーを取得
              $area_terms = get_the_terms(get_the_ID(), 'area');
              $industry_terms = get_the_terms(get_the_ID(), 'industry');
              $job_terms = get_the_terms(get_the_ID(), 'job_type');
              $employment_terms = get_the_terms(get_the_ID(), 'employment_type');
            ?>
            <a class="p-recruit__wrapper" href="<?php the_permalink(); ?>">
              <div class="p-recruit__box">
                <?php if ( $recruit_image ) : ?>
                  <img src="<?php echo esc_url($recruit_image); ?>" alt="<?php the_title(); ?>" class="p-recruit__item-img">
                <?php else : ?>
                  <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="求人情報" class="p-recruit__item-img no-image">
                <?php endif; ?>

                <div class="p-recruit__item-detail-wrapper">
                  <h2 class="p-recruit__item-title"><?php the_title(); ?></h2>

                  <ul class="p-recruit__taxonomy">
                    <?php if ( $job_terms ) : ?>
                      <li class="p-recruit__taxonomy-item">職種：
                        <?php foreach ( $job_terms as $term ) echo esc_html($term->name) . ' '; ?>
                      </li>
                    <?php endif; ?>

                    <?php if ( $employment_terms ) : ?>
                      <li class="p-recruit__taxonomy-item">雇用形態：
                        <?php foreach ( $employment_terms as $term ) echo esc_html($term->name) . ' '; ?>
                      </li>
                    <?php endif; ?>

                    <?php if ( $industry_terms ) : ?>
                      <li class="p-recruit__taxonomy-item">業種：
                        <?php foreach ( $industry_terms as $term ) echo esc_html($term->name) . ' '; ?>
                      </li>
                    <?php endif; ?>

                    <?php if ( $area_terms ) : ?>
                      <li class="p-recruit__taxonomy-item">地域：
                        <?php foreach ( $area_terms as $term ) echo esc_html($term->name) . ' '; ?>
                      </li>
                    <?php endif; ?>
                  </ul>

                  <div class="p-recruit__excerpt">
                    <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
                  </div>
                </div>
              </div>
            </a>
          <?php endwhile; ?>
        <?php else : ?>
          <p class="m-none-post-text">現在、募集情報はありません。</p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
      </div>

      <div class="c-arrow">
        <div class="c-pagination">
          <?php if ( function_exists( 'wp_pagenavi' ) ) { wp_pagenavi(array('query' => $the_query)); } ?>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>
