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

/* recaptchaをcontactページ以外で読み込まない */
function load_recaptcha_js() {
  if (!is_page(array('contact-input'))) {
      wp_deregister_script('google-recaptcha');
  }
}
add_action('wp_enqueue_scripts', 'load_recaptcha_js', 100);

/* Contact Form 7の自動Pタグ無効化 */
add_filter('wpcf7_autop_or_not', '__return_false');

/* セッション管理 */
function start_session() {
  if (!session_id()) {
    session_start();
  }
}
add_action('init', 'start_session');

function end_session() {
  session_destroy();
}
add_action('wp_logout', 'end_session');
add_action('wp_login', 'end_session');

/***********************************************************
* Contact Form7 確認モーダル用スクリプト読み込み
***********************************************************/
function enqueue_contact_modal_script() {
  if (is_page('contact-input')) {
    wp_enqueue_script(
      'contact-modal',
      get_template_directory_uri() . '/js/contact-modal.js',
      array('jquery'),
      filemtime(get_template_directory() . '/js/contact-modal.js'),
      true
    );
  }
}
add_action('wp_enqueue_scripts', 'enqueue_contact_modal_script');




// /application の登録フォームだけ、label + div_* を1行ラッパーで包む
add_filter('wpmem_register_form', function($form_html){
  if ( ! is_page('application') ) return $form_html;

  // <label>…</label><div class="div_…">…</div> を <div class="wpmem-row">…</div> で包む
  $pattern     = '/(<label\b[^>]*>.*?<\/label>)(\s*<div class="div_[^"]*">.*?<\/div>)/s';
  $replacement = '<div class="wpmem-row">$1$2</div>';
  $form_html   = preg_replace($pattern, $replacement, $form_html);

  return $form_html;
}, 10);


/**
 * =========================================
 * 設定
 * =========================================
 */
define('MKN_COMPANY_CPT', 'company'); // 企業CPTスラッグ
define('MKN_FA_FORM_ID', 25);         // Frontend Admin のフォームID

/**
 * =========================================
 * 1) 掲載企業ロール（company_member）を用意
 * =========================================
 */
add_action('init', function () {
  if ( ! get_role('company_member') ) {
    add_role('company_member', '掲載企業', ['read' => true]);
  }
  if ( $role = get_role('company_member') ) {
    $role->add_cap('read', true);
    $role->add_cap('upload_files', true);
    $role->add_cap('edit_posts', true);
    $role->add_cap('publish_posts', true);
    $role->add_cap('edit_published_posts', true);
    $role->add_cap('delete_posts', false);
    $role->add_cap('delete_published_posts', false);
  }
});

/**
 * =========================================
 * 2) 新規ユーザー登録時にロールを company_member にする
 *    & 専用の企業投稿を作る（タイトルは会社名）
 * =========================================
 */
add_action('user_register', function($user_id){
  $user = new WP_User($user_id);

  if ( ! user_can($user, 'manage_options') ) {
    $user->set_role('company_member');
  }

  // 会社名（ユーザーメタに保存されていると仮定）
  $company_name = get_user_meta($user_id, 'company_name', true);

  // Fallback: 未入力ならユーザー名
  $title = $company_name ?: ($user->display_name ?: $user->user_login);

  // 投稿を作成（まだ存在しなければ）
  $existing = get_user_meta($user_id, 'company_post_id', true);
  if ( ! $existing ) {
    $post_id = wp_insert_post([
      'post_type'   => MKN_COMPANY_CPT,
      'post_status' => 'draft',
      'post_title'  => sanitize_text_field($title),
      'post_author' => $user_id,
    ]);
    if ( $post_id && !is_wp_error($post_id) ) {
      update_user_meta($user_id, 'company_post_id', (int)$post_id);
    }
  }
}, 20);

// WP-Members 承認時にも会社名でタイトルを補正
add_action('wpmem_user_activated', function($user_id){
  $user = new WP_User($user_id);
  if ( ! user_can($user, 'manage_options') ) {
    $user->set_role('company_member');
  }

  $post_id = mkn_get_company_post_id($user_id);
  if ( $post_id ) {
    $company_name = get_user_meta($user_id, 'company_name', true);
    if ( $company_name ) {
      wp_update_post([
        'ID'         => $post_id,
        'post_title' => sanitize_text_field($company_name),
      ]);
    }
  }
}, 20);

/**
 * =========================================
 * 3) 掲載企業ユーザーは管理バー非表示
 * =========================================
 */
add_filter('show_admin_bar', function ($show) {
  if ( is_user_logged_in() ) {
    $u = wp_get_current_user();
    if ( in_array('company_member', (array)$u->roles, true) ) {
      return false;
    }
  }
  return $show;
}, 20);

/**
 * =========================================
 * 4) 未ログインは /mypage へ入れない
 * =========================================
 */
add_action('template_redirect', function () {
  if ( is_page('mypage') && ! is_user_logged_in() ) {
    wp_safe_redirect( site_url('/login/') );
    exit;
  }
});

/**
 * =========================================
 * 5) ユーザー専用の企業投稿を保証する
 * =========================================
 */
function mkn_ensure_company_post_for_user($user_id){
  $meta_key = 'company_post_id';
  $cpt      = MKN_COMPANY_CPT;

  $pid = (int) get_user_meta($user_id, $meta_key, true);
  if ( $pid && get_post_type($pid) === $cpt ) return $pid;

  $found = get_posts([
    'post_type'      => $cpt,
    'author'         => $user_id,
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'post_status'    => ['draft','pending','publish'],
  ]);
  if ( $found ) {
    update_user_meta($user_id, $meta_key, (int)$found[0]);
    return (int)$found[0];
  }
  return 0;
}

function mkn_get_company_post_id($user_id){
  return (int) mkn_ensure_company_post_for_user($user_id);
}

/**
 * =========================================
 * 6) マイページ用ショートコード
 * =========================================
 */
add_shortcode('company_mypage_form', function () {
  if ( ! is_user_logged_in() ) {
    auth_redirect();
    return '';
  }

  $user = wp_get_current_user();
  if ( !in_array('company_member', (array)$user->roles, true) && !current_user_can('administrator') ) {
    return '<p>このページを表示する権限がありません。</p>';
  }

  $post_id = mkn_get_company_post_id($user->ID);
  if ( ! $post_id ) {
    return '<p>企業プロフィールの初期化に失敗しました。管理者へご連絡ください。</p>';
  }

  if ( ! current_user_can('edit_post', $post_id) ) {
    return '<p>この投稿を編集する権限がありません。</p>';
  }

  $form_id = MKN_FA_FORM_ID;
  $html = do_shortcode(sprintf('[frontend_admin form="%d" post_id="%d"]', $form_id, $post_id));

  $status_obj = get_post_status_object(get_post_status($post_id));
  $status     = $status_obj ? $status_obj->label : '不明';

  $meta = sprintf(
    '<div class="company-mypage-meta" style="margin:1rem 0;">
       <small>現在の状態：%s　|　
         <a href="%s" target="_blank" rel="noopener">公開ページを確認</a>
       </small>
     </div>',
    esc_html($status),
    esc_url(get_permalink($post_id))
  );

  return $meta . $html;
});

/**
 * =========================================
 * 7) マイページアクセス時に自動的に post_id を付与
 *    & 他人の post_id を指定したら自分のにリダイレクト
 * =========================================
 */
add_action('template_redirect', function () {
  if ( is_page('mypage') && is_user_logged_in() ) {
    $user    = wp_get_current_user();
    $post_id = mkn_get_company_post_id($user->ID);

    if ( ! $post_id ) return;

    $req_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

    if ( current_user_can('administrator') ) {
      // 管理者は自由にアクセス可
      return;
    }

    if ( $req_id !== $post_id ) {
      wp_safe_redirect( add_query_arg('post_id', $post_id, get_permalink()) );
      exit;
    }
  }
});

/**
 * =========================================
 * 8) 保存時に必ず「公開」へ変更（掲載企業ユーザーのみ）
 * =========================================
 */
add_action('save_post_company', function($post_id, $post, $update){
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
  if ( wp_is_post_revision($post_id) ) return;
  if ( current_user_can('administrator') ) return;

  if ( $post->post_status !== 'publish' ) {
    wp_update_post([
      'ID'          => $post_id,
      'post_status' => 'publish',
    ]);
  }
}, 10, 3);



// フロントでは ACF の company_image フィールドを独自UIに差し替え
add_filter('acf/render_field/name=company_image', function($field) {
  if ( is_admin() ) return $field;

  $value = $field['value']; // 現在の添付ID
  ob_start();
  ?>
  <div class="company-upload-wrapper">
      <?php if ($value): ?>
          <p>現在の画像:</p>
          <?php echo wp_get_attachment_image($value, 'medium', false, ['id' => 'company_image_preview']); ?>
      <?php else: ?>
          <img id="company_image_preview" src="" style="display:none;max-width:200px;margin-bottom:10px;">
      <?php endif; ?>

      <!-- hidden input（ACF用・ここはそのまま残す） -->
      <input type="hidden" name="acf[<?php echo esc_attr($field['key']); ?>]" value="<?php echo esc_attr($value); ?>" />

      <p>
          <label>会社画像をアップロード:</label><br>
          <input type="file" name="company_image_file" accept="image/*" onchange="previewCompanyImage(event)" />
      </p>
  </div>

  <script>
  function previewCompanyImage(e) {
      var reader = new FileReader();
      reader.onload = function(){
          var img = document.getElementById("company_image_preview");
          img.src = reader.result;
          img.style.display = "block";
      };
      reader.readAsDataURL(e.target.files[0]);
  }
  </script>
  <?php
  echo ob_get_clean();
  return false; // 元のUIは出さない
});

// 保存時にファイルを強制的に ACF に反映
add_action('acf/save_post', function($post_id) {
  if ( is_admin() ) return;

  if ( !empty($_FILES['company_image_file']['name']) ) {
      require_once ABSPATH . 'wp-admin/includes/file.php';
      require_once ABSPATH . 'wp-admin/includes/media.php';
      require_once ABSPATH . 'wp-admin/includes/image.php';

      $attachment_id = media_handle_upload('company_image_file', $post_id);

      if ( !is_wp_error($attachment_id) ) {
          // フィールドキーで強制保存
          update_field('field_68db76f81ce99', $attachment_id, $post_id);

          // アイキャッチにも設定（任意）
          set_post_thumbnail($post_id, $attachment_id);
      }
  }
}, 20); // 20優先度で確実にACF保存後に実行


