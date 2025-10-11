<?php get_header(); ?>
<main class="l-main p-main">
  <div class="c-page__section-title-wrapper">
    <h1 class="c-page__section-title">企業マイページ</h1>
  </div>
  <div class="p-mypage-edit">
    <div class="c-inner">
      <div class="p-mypage-edit__container">
        <h2 class="c-page__section-title">採用情報の編集</h2>

        <?php if ( is_user_logged_in() ) : ?>
          <?php
          $current_user = wp_get_current_user();
          $edit_post_id = isset($_GET['edit_post']) ? intval($_GET['edit_post']) : 0;
  
          // 権限チェック（掲載企業 or 管理者）
          if ( in_array('company_member', (array)$current_user->roles, true) || current_user_can('administrator') ) :
  
            // 編集対象が指定されているか確認
            if ( $edit_post_id ) :
  
              // 投稿タイプが「recruit」か確認してセキュリティ強化
              $post_type = get_post_type($edit_post_id);
              if ( $post_type === 'recruit' ) {
                echo do_shortcode('[frontend_admin form="126" edit_post="' . esc_attr($edit_post_id) . '"]');
              } else {
                echo '<p>この投稿は編集できません（投稿タイプが不正です）。</p>';
              }

            else :
              echo '<p>編集する採用情報が指定されていません。</p>';
            endif;

          else : ?>
            <p>このページを表示する権限がありません。</p>
          <?php endif; ?>

        <?php else : ?>
          <p>ログインしてください。</p>
        <?php endif; ?>

        <div class="p-mypage-edit__back-link">
          <a href="<?php echo esc_url(site_url('/mypage/#recruit')); ?>">
            ← 採用情報マイページに戻る
          </a>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>
