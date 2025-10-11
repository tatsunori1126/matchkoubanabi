<?php get_header(); ?>
<main class="l-main p-main">
  <div class="c-page__section-title-wrapper">
    <h1 class="c-page__section-title">企業マイページ</h1>
  </div>
  <div class="p-mypage">
    <div class="c-inner">

      <!-- ▼ タブ切り替えナビ -->
      <div class="mypage-tabs">
        <button class="tab-btn active" data-target="company">企業情報</button>
        <button class="tab-btn" data-target="recruit">採用情報</button>
      </div>

      <?php
      $current_user = wp_get_current_user();
      ?>

      <div class="mypage-wrapper">
        <?php if ( is_user_logged_in() ) : ?>
          <?php if ( in_array('company_member', (array)$current_user->roles, true) || current_user_can('administrator') ) : ?>

            <!-- ▼ 企業情報 -->
            <div id="company" class="tab-content active">
              <h2 class="c-page__section-title">企業情報</h2>

              <?php
              // ===============================
              // 管理者ユーザーの場合
              // ===============================
              if ( current_user_can('administrator') ) :

                $companies = get_posts([
                  'post_type'      => 'company',
                  'posts_per_page' => -1,
                  'post_status'    => ['publish', 'draft', 'pending'],
                  'orderby'        => 'title',
                  'order'          => 'ASC',
                ]);

                if ( $companies ) :
                  ?>
                  <h3 class="c-page__sub-title">登録企業一覧</h3>
                  <ul class="admin-company-list">
                    <?php foreach ( $companies as $company ) :
                      $status_obj = get_post_status_object($company->post_status);
                      $status_label = $status_obj ? $status_obj->label : '不明';
                      ?>
                      <li class="admin-company-list__item">
                        <div class="admin-company-list__inner">
                          <!-- 左側：企業名＋ステータス -->
                          <div class="admin-company-list__info">
                            <strong class="admin-company-list__title">
                              <?php echo esc_html($company->post_title); ?>
                            </strong>
                            <span class="admin-company-list__status">
                              （<?php echo esc_html($status_label); ?>）
                            </span>
                          </div>

                          <!-- 右側：操作リンク -->
                          <div class="admin-company-list__links">
                            <a href="<?php echo esc_url(add_query_arg('edit_post', $company->ID, site_url('/company-edit/'))); ?>" class="edit">✏ 編集する</a>
                            <a href="<?php echo esc_url(get_permalink($company->ID)); ?>" target="_blank" class="view">👁 公開ページを見る</a>
                            <a href="<?php echo esc_url(get_delete_post_link($company->ID, '', true)); ?>" onclick="return confirm('この投稿を削除しますか？');" class="delete">🗑 削除</a>
                          </div>
                        </div>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                  <?php
                else :
                  echo '<p>現在、登録されている企業紹介はありません。</p>';
                endif;

              // ===============================
              // 一般企業ユーザーの場合
              // ===============================
              else :
                $company_post = get_posts([
                  'post_type'      => 'company',
                  'author'         => $current_user->ID,
                  'posts_per_page' => 1,
                  'post_status'    => ['publish', 'draft', 'pending'],
                ]);

                if ( $company_post ) :
                  $post = $company_post[0];
                  $post_id = $post->ID;
                  $status_label = get_post_status_object(get_post_status($post_id))->label;

                  echo '<p class="p-mypage__status">現在の状態：' . esc_html($status_label) . '　|　<a href="' . esc_url(get_permalink($post_id)) . '" target="_blank">公開ページを確認</a></p>';

                  // ▼ フィールド取得
                  $company_image_id = get_field('company_image', $post_id);
                  $address     = get_field('company_address', $post_id);
                  $tel         = get_field('company_tel', $post_id);
                  $site        = get_field('company_site', $post_id);
                  $established = get_field('company_established', $post_id);
                  $employees   = get_field('company_employees', $post_id);
                  $capital     = get_field('company_capital', $post_id);
                  $area_terms  = get_the_terms($post_id, 'area');
                  $industry_terms = get_the_terms($post_id, 'industry');
                  $area_name     = $area_terms ? esc_html($area_terms[0]->name) : '';
                  $industry_name = $industry_terms ? esc_html($industry_terms[0]->name) : '';

                  $intro   = get_field('company_intro', $post_id);
                  $message = get_field('company_message', $post_id);
                  $facilities = get_field('company_facilities', $post_id);
                  $materials  = get_field('company_materials', $post_id);
                  $processes  = get_field('company_processes', $post_id);
                  $str1 = get_field('company_strength_1', $post_id);
                  $str2 = get_field('company_strength_2', $post_id);
                  $str3 = get_field('company_strength_3', $post_id);
                  $clients  = get_field('company_clients', $post_id);
                  $products = get_field('company_products', $post_id);
                  ?>

                  <!-- ▼ 企業詳細（一般企業向け） -->
                  <div class="p-mypage__container">
                    <div class="p-mypage__base-card">

                      <!-- 基本情報 -->
                      <section class="p-mypage__basic">
                        <div class="p-mypage__basic-inner">
                          <div class="p-mypage__image">
                            <?php if ($company_image_id) : ?>
                              <?php echo wp_get_attachment_image($company_image_id, 'large', false, ['alt' => get_the_title($post_id), 'class' => 'p-mypage__img']); ?>
                            <?php else : ?>
                              <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="No Image" class="p-mypage__img no-image" />
                            <?php endif; ?>
                          </div>

                          <div class="p-mypage__info">
                            <h2 class="p-mypage__name"><?php echo esc_html(get_the_title($post_id)); ?></h2>
                            <ul class="p-mypage__list">
                              <?php if ($address) : ?><li>住所：<?php echo esc_html($address); ?></li><?php endif; ?>
                              <?php if ($tel) : ?><li>電話番号：<a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $tel)); ?>"><?php echo esc_html($tel); ?></a></li><?php endif; ?>
                              <?php if ($area_name) : ?><li>地域：<?php echo $area_name; ?></li><?php endif; ?>
                              <?php if ($industry_name) : ?><li>業種：<?php echo $industry_name; ?></li><?php endif; ?>
                              <?php if ($established) : ?><li>設立：<?php echo esc_html($established); ?></li><?php endif; ?>
                              <?php if ($employees) : ?><li>従業員数：<?php echo esc_html($employees); ?>名</li><?php endif; ?>
                              <?php if ($capital) : ?><li>資本金：<?php echo esc_html($capital); ?></li><?php endif; ?>
                              <?php if ($site) : ?><li>ホームページ：<a href="<?php echo esc_url($site); ?>" target="_blank" rel="noopener"><?php echo esc_html($site); ?></a></li><?php endif; ?>
                            </ul>
                          </div>
                        </div>
                      </section>

                      <?php if ($intro) : ?>
                        <section class="p-mypage__section">
                          <h2 class="p-mypage__sub-title">会社紹介</h2>
                          <div class="p-mypage__text"><?php echo wp_kses_post($intro); ?></div>
                        </section>
                      <?php endif; ?>

                      <?php if ($message) : ?>
                        <section class="p-mypage__section">
                          <h2 class="p-mypage__sub-title">代表メッセージ</h2>
                          <div class="p-mypage__text"><?php echo wp_kses_post($message); ?></div>
                        </section>
                      <?php endif; ?>

                      <?php if ($facilities || $materials || $processes) : ?>
                        <section class="p-mypage__section">
                          <h2 class="p-mypage__sub-title">対応設備・加工内容</h2>
                          <?php if ($facilities) : ?><p>■主要設備：<?php echo esc_html($facilities); ?></p><?php endif; ?>
                          <?php if ($materials) : ?><p>■対応素材：<?php echo esc_html($materials); ?></p><?php endif; ?>
                          <?php if ($processes) : ?><p>■加工内容：<?php echo esc_html($processes); ?></p><?php endif; ?>
                        </section>
                      <?php endif; ?>

                      <?php if ($str1 || $str2 || $str3) : ?>
                        <section class="p-mypage__section">
                          <h2 class="p-mypage__sub-title">自社の強み</h2>
                          <ul class="p-mypage__strength">
                            <?php if ($str1) : ?><li>■<?php echo esc_html($str1); ?></li><?php endif; ?>
                            <?php if ($str2) : ?><li>■<?php echo esc_html($str2); ?></li><?php endif; ?>
                            <?php if ($str3) : ?><li>■<?php echo esc_html($str3); ?></li><?php endif; ?>
                          </ul>
                        </section>
                      <?php endif; ?>

                      <?php if ($clients || $products) : ?>
                        <section class="p-mypage__section">
                          <?php if ($clients) : ?>
                            <h2 class="p-mypage__sub-title">主な取引先</h2>
                            <div class="p-mypage__text"><?php echo nl2br(esc_html($clients)); ?></div>
                          <?php endif; ?>
                          <?php if ($products) : ?>
                            <h2 class="p-mypage__sub-title">主要製品・事例紹介</h2>
                            <div class="p-mypage__text"><?php echo wp_kses_post($products); ?></div>
                          <?php endif; ?>
                        </section>
                      <?php endif; ?>

                      <div class="p-mypage__edit">
                        <a href="<?php echo esc_url(add_query_arg('edit_post', $post_id, site_url('/company-edit/'))); ?>" class="c-btn-edit">✏ 編集する</a>
                      </div>
                    </div>
                  </div>
                <?php else : ?>
                  <p>企業情報がまだ登録されていません。</p>
                <?php endif; ?>
              <?php endif; ?>
            </div>

            <!-- ▼ 採用情報フォーム＆一覧 -->
            <div id="recruit" class="tab-content" style="display:none;">
              <div class="recruit-header">
                <h2 class="c-page__section-title">新しく求人を募集する</h2>
                <button id="toggleRecruitForm" class="c-btn-toggle">＋ 新規募集フォームを開く</button>
              </div>

              <!-- ▼ 非表示フォーム -->
              <div id="recruitFormWrapper" class="recruit-form-wrapper" style="display:none;">
                <?php echo do_shortcode('[frontend_admin form="100"]'); ?>
              </div>

              <hr class="mypage-divider">

              <h2 class="c-page__section-title">公開中採用情報一覧</h2>

              <?php
              $args = [
                'post_type'      => 'recruit',
                'posts_per_page' => 10,
                'post_status'    => ['publish', 'draft', 'pending'],
              ];

              if ( ! current_user_can('administrator') ) {
                $args['author'] = $current_user->ID;
              }

              $recruit_query = new WP_Query($args);

              if ( $recruit_query->have_posts() ) :
                echo '<ul class="admin-company-list">';
                while ( $recruit_query->have_posts() ) : $recruit_query->the_post();
                  $status_obj = get_post_status_object(get_post_status());
                  $status_label = $status_obj ? $status_obj->label : '不明';
                  ?>
                  <li class="admin-company-list__item">
                    <div class="admin-company-list__inner">
                      <div class="admin-company-list__info">
                        <strong class="admin-company-list__title"><?php the_title(); ?></strong>
                        <span class="admin-company-list__status">（<?php echo esc_html($status_label); ?>）</span>
                      </div>
                      <div class="admin-company-list__links">
                        <a href="<?php the_permalink(); ?>" target="_blank" class="view">👁 公開ページを見る</a>
                        <a href="<?php echo esc_url(add_query_arg('edit_post', get_the_ID(), site_url('/mypage-edit/'))); ?>" class="edit">✏ 編集する</a>
                        <a href="<?php echo get_delete_post_link(get_the_ID(), '', true); ?>" onclick="return confirm('この投稿を削除しますか？');" class="delete">🗑 削除</a>
                      </div>
                    </div>
                    <?php if (has_post_thumbnail()) : ?>
                      <div class="admin-company-list__thumb">
                        <?php the_post_thumbnail('medium'); ?>
                      </div>
                    <?php endif; ?>
                  </li>
                  <?php
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
              else :
                echo '<p>まだ採用情報は投稿されていません。</p>';
              endif;
              ?>
            </div>
          <?php else : ?>
            <p>このページを表示する権限がありません。</p>
          <?php endif; ?>
        <?php else : ?>
          <p>ログインしてください。</p>
        <?php endif; ?>
      </div><!-- /.mypage-wrapper -->
    </div><!-- /.c-inner -->
  </div><!-- /.p-mypage -->
</main>
<?php get_footer(); ?>
