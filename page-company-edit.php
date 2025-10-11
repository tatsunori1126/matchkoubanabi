<?php
/*
Template Name: 企業紹介 編集ページ
*/

acf_form_head(); // 必ず一番上！

function enqueue_acf_scripts_for_edit_page() {
  if (is_page_template('page-company-edit.php')) {
    wp_enqueue_script('jquery');
    wp_enqueue_media();
    wp_enqueue_script('acf-input');
  }
}
add_action('wp_enqueue_scripts', 'enqueue_acf_scripts_for_edit_page');

get_header();
?>

<main class="l-main p-main">
  <div class="c-page__section-title-wrapper">
    <h1 class="c-page__section-title">企業マイページ</h1>
  </div>
  <div class="p-mypage-edit">
    <div class="c-inner">
      <div class="p-mypage-edit__container">
        <h2 class="c-page__section-title">企業情報の編集</h2>
  
        <?php
        if ( is_user_logged_in() ) :
  
          $edit_post_id = isset($_GET['edit_post']) ? intval($_GET['edit_post']) : 0;
  
          if ( $edit_post_id ) {
            // ✅ ACFの標準関数で編集フォームを表示（JS制限なし）
            acf_form(array(
              'post_id'       => $edit_post_id,
              'field_groups'  => array('group_68db76f81ce99'), // ←会社情報のフィールドグループIDを指定
              'submit_value'  => '更新する',
              'updated_message' => '企業情報を更新しました。',
            ));
          } else {
            echo '<p>編集対象の企業情報が指定されていません。</p>';
          }
  
        else :
          echo '<p>このページを表示するにはログインが必要です。</p>';
        endif;
        ?>
  
        <div class="p-mypage-edit__back-link">
          <a href="<?php echo esc_url(site_url('/mypage')); ?>">← マイページに戻る</a>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>
