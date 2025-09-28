<?php
/***********************************************************
* テーマサポートの追加
***********************************************************/
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'custom-logo' );
add_theme_support( 'wp-block-styles' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'align-wide' );

/***********************************************************
* SEO対策のためのタイトルタグのカスタマイズ
***********************************************************/
function seo_friendly_title( $title ) {
  // トップページの場合
  if ( is_front_page() ) {
      $title = get_bloginfo( 'name', 'display' ); // トップページではサイトのタイトルのみを表示
  } 
  // トップページ以外の場合
  elseif ( is_singular() ) {
      $title = single_post_title( '', false ) . ' | ' . get_bloginfo( 'name', 'display' ); // ページタイトル | サイトタイトル
  }
  return $title;
}
add_filter( 'pre_get_document_title', 'seo_friendly_title' );


/***********************************************************
* 不要なwp_headアクションを削除（パフォーマンス向上）
***********************************************************/
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles');

/***********************************************************
* 絵文字機能を無効化（パフォーマンス向上）
***********************************************************/
function disable_emoji_feature() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'emoji_svg_url', '__return_false' ); // さらに絵文字を無効化
}
add_action( 'init', 'disable_emoji_feature' );

/***********************************************************
* CSSとJavaScriptの読み込み
***********************************************************/
function enqueue_theme_assets() {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));

    // Swiper CSS
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), null);

    // Font Awesome CSS
    wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v6.6.0/css/all.css', array(), null);

    // Google Fonts（preconnectを追加）
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap', array(), null);

    // Custom CSS
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/style.min.css', array(), filemtime(get_template_directory() . '/css/style.min.css'));

    // jQuery
    wp_enqueue_script('jquery');

    // Swiper JS
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);

    // Custom JS - 圧縮版を読み込むように修正
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');

// GSAPとScrollTriggerの読み込み
function enqueue_gsap_with_scrolltrigger() {
    // GSAP本体を読み込む
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), null, true);
    wp_script_add_data('gsap', 'async', true); // 非同期読み込み

    // ScrollTriggerプラグインを読み込む
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array('gsap'), null, true);
    wp_script_add_data('gsap-scrolltrigger', 'async', true); // 非同期読み込み
}
add_action('wp_enqueue_scripts', 'enqueue_gsap_with_scrolltrigger');


/***********************************************************
* カスタム投稿によって表示件数を変える
***********************************************************/
// function change_posts_per_page($query) {
//   if ( is_admin() || ! $query->is_main_query() )
//       return;

//   // カスタム投稿タイプ "news" のアーカイブページの場合
//   if ( $query->is_post_type_archive('news') ) {
//       $query->set( 'posts_per_page', 12 );
//       return;
//   }

//   // カスタム投稿タイプ "achievements" のアーカイブページの場合
//   if ( $query->is_post_type_archive('achievements') ) {
//       $query->set( 'posts_per_page', 12 );
//       return;
//   }

//   // タクソノミー "news_category" のアーカイブページの場合
//   if ( $query->is_tax('news_category') ) {
//       $query->set( 'posts_per_page', 12 );
//       return;
//   }
// }
// add_action( 'pre_get_posts', 'change_posts_per_page' );


/***********************************************************
* Options Page
***********************************************************/
// if( function_exists('acf_add_options_page') ) {
//   acf_add_options_page(array(
//     'page_title' 	=> 'RECRUIT - 数字でみる',
//     'menu_title'	=> 'RECRUIT - 数字でみる',
//     'menu_slug' 	=> 'top-data',
//     'capability'	=> 'edit_posts',
//     'redirect'		=> false
//   ));
// }



/***********************************************************
* Contact Form7
***********************************************************/
/* 確認用メールアドレス入力欄を設置 */
function wpcf7_custom_email_validation_filter($result, $tag) {
  if ('email_confirmation' == $tag->name) {
    $your_email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $your_email_confirm = isset($_POST['email_confirmation']) ? trim($_POST['email_confirmation']) : '';
    if ($your_email != $your_email_confirm) {
      $result->invalidate($tag, "メールアドレスが一致しません");
    }
  }
  return $result;
}
add_filter('wpcf7_validate_email', 'wpcf7_custom_email_validation_filter', 20, 2);
add_filter('wpcf7_validate_email*', 'wpcf7_custom_email_validation_filter', 20, 2);

/* recaptchaの読み込みを設定したページ以外読み込ませないように */
function load_recaptcha_js() {
  if (!is_page(array('contact-input', 'contact-confirm'))) {
      wp_deregister_script('google-recaptcha');
  }
}
add_action('wp_enqueue_scripts', 'load_recaptcha_js', 100);

/* 自動挿入されるPタグ、brタグを削除 */
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false() {
  return false;
}


// Contact Form 7のフックを使って送信ステータスをセッションに保存
add_action('wpcf7_mail_sent', 'my_wpcf7_mail_sent');
add_action('wpcf7_mail_failed', 'my_wpcf7_mail_failed');

function my_wpcf7_mail_sent($contact_form) {
    session_start();
    $_SESSION['cf7_status'] = 'success';
}

function my_wpcf7_mail_failed($contact_form) {
    session_start();
    $_SESSION['cf7_status'] = 'fail';
}

// セッションの開始
function start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session');

// セッションの終了
function end_session() {
    session_destroy();
}
add_action('wp_logout', 'end_session');
add_action('wp_login', 'end_session');




