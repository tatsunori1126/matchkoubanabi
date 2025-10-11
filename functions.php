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
  // --- CSS ---
  wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), filemtime(get_template_directory() . '/style.css'));

  // Swiper CSS
  wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), null);

  // Font Awesome CSS
  wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v6.6.0/css/all.css', array(), null);

  // Google Fonts
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap', array(), null);

  // Custom CSS
  wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/style.min.css', array(), filemtime(get_template_directory() . '/css/style.min.css'));


  // --- JavaScript ---
  // jQuery
  wp_enqueue_script('jquery');

  // Swiper JS
  wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);

  // GSAP（本体 + ScrollTrigger）
  wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), null, true);
  wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array('gsap'), null, true);

  // --- カスタムJS（共通） ---
  wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/script.min.js', array('jquery'), filemtime(get_template_directory() . '/js/script.min.js'), true);

  // --- ✅ マイページ専用スクリプト ---
  if (is_page('mypage')) { // 固定ページスラッグが "mypage" の場合のみ読み込む
      wp_enqueue_script(
          'mypage',
          get_template_directory_uri() . '/js/mypage.js',
          array('jquery'),
          filemtime(get_template_directory() . '/js/mypage.js'),
          true
      );
  }
  // --- ✅ 企業一覧・タクソノミー専用スクリプト ---
  if (is_post_type_archive('company') || is_tax(array('area', 'industry'))) {
    wp_enqueue_script(
        'company',
        get_template_directory_uri() . '/js/company.js',
        array('jquery'),
        filemtime(get_template_directory() . '/js/company.js'),
        true
    );
  }
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');



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

// ✅ ←この関数は「mkn_ensure_company_post_for_user()」の後に置く！
function mkn_get_company_post_id($user_id){
  $pid = (int) mkn_ensure_company_post_for_user($user_id);

  // 管理者の場合：自分の投稿がなくても最初の企業紹介を開けるようにする
  if ( !$pid && current_user_can('administrator') ) {
    $first_company = get_posts([
      'post_type'      => MKN_COMPANY_CPT,
      'posts_per_page' => 1,
      'fields'         => 'ids',
      'post_status'    => ['draft','pending','publish'],
    ]);
    if ( $first_company ) {
      return (int)$first_company[0];
    }
  }

  return $pid;
}




/**
 * =========================================
 * 6) マイページ用ショートコード（管理者は全企業表示）
 * =========================================
 */
add_shortcode('company_mypage_form', function () {
  if ( ! is_user_logged_in() ) {
    auth_redirect();
    return '';
  }

  $user = wp_get_current_user();

  // =======================================================
  // ▼ 管理者は全ての企業投稿を一覧表示
  // =======================================================
  if ( current_user_can('administrator') ) {
    $companies = get_posts([
      'post_type'      => MKN_COMPANY_CPT,
      'posts_per_page' => -1,
      'post_status'    => ['publish', 'draft', 'pending'],
      'orderby'        => 'title',
      'order'          => 'ASC',
    ]);

    if ( ! $companies ) {
      return '<p>現在、登録されている企業紹介はありません。</p>';
    }

    ob_start();
    ?>
    <div class="admin-company-list" style="margin-top:30px;">
  <h2 style="margin-bottom:20px;">登録企業一覧</h2>
  <ul class="mypage-recruit-list" style="list-style:none;padding:0;">
    <?php foreach ( $companies as $company ) : ?>
      <?php $status = get_post_status_object($company->post_status); ?>
      <li style="border-bottom:1px solid #ccc;padding:15px 0;">
        <strong style="font-size:18px;"><?php echo esc_html($company->post_title); ?></strong>
        <span style="color:#666;margin-left:10px;">（<?php echo esc_html($status->label); ?>）</span><br>

        <?php if ( has_post_thumbnail($company->ID) ) : ?>
          <div style="margin-top:10px;">
            <?php echo get_the_post_thumbnail($company->ID, 'medium'); ?>
          </div>
        <?php endif; ?>

        <div style="margin-top:10px;">
          <a href="<?php echo get_permalink($company->ID); ?>" target="_blank" style="margin-right:10px;">▶ 公開ページを見る</a>
          <a href="<?php echo esc_url( add_query_arg('edit_post', $company->ID, site_url('/company-edit/')) ); ?>" style="margin-right:10px;">✏ 編集する</a>
          <a href="<?php echo get_delete_post_link($company->ID, '', true); ?>" onclick="return confirm('この企業情報を削除しますか？');" style="color:red;">
            🗑 削除する
          </a>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
    <?php
    return ob_get_clean();
  }

  // =======================================================
  // ▼ 一般企業ユーザー用（自社情報フォーム）
  // =======================================================
  if ( !in_array('company_member', (array)$user->roles, true) ) {
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
 * 7) マイページアクセス時のリダイレクト（企業ユーザーのみ）
 * =========================================
 */
add_action('template_redirect', function () {
  // 管理者は何もしない（一覧を見せたいのでリダイレクト禁止）
  if ( current_user_can('administrator') ) {
    return;
  }

  if ( is_page('mypage') && is_user_logged_in() ) {
    $user    = wp_get_current_user();
    $post_id = mkn_get_company_post_id($user->ID);

    if ( ! $post_id ) return;

    $req_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

    // 他人の投稿IDを指定してアクセスしている場合はリダイレクト
    if ( $req_id !== $post_id ) {
      wp_safe_redirect( add_query_arg('post_id', $post_id, get_permalink()) );
      exit;
    }
  }
});




// 投稿保存時に投稿者を現在のユーザーに設定
add_filter('frontend_admin/default_post_author', function($author, $form, $post_id){
  return get_current_user_id();
}, 10, 3);



// 掲載企業ロールに必要な権限を追加
function add_recruit_capabilities_to_publisher() {
  $role = get_role('掲載企業');
  if ($role) {
    $role->add_cap('read');
    $role->add_cap('edit_posts');
    $role->add_cap('delete_posts');
    $role->add_cap('publish_posts'); // ← ここが公開権限
    $role->add_cap('upload_files');
  }
}
add_action('init', 'add_recruit_capabilities_to_publisher');


// Frontend Admin 送信後のエラーメッセージ非表示
add_filter('frontend_admin/error_message', function($message, $form_id) {
  // 特定フォーム（採用情報）の場合のみ
  if ($form_id == 100) {
    return ''; // メッセージを空にする
  }
  return $message;
}, 10, 2);


// ---------------------------------------------
// ログイン時に自動的に company_post_id を保証する
// ---------------------------------------------
add_action('wp_login', function($user_login, $user) {
  if ( in_array('company_member', (array)$user->roles, true) ) {
    $post_id = mkn_get_company_post_id($user->ID);

    // 投稿が存在しない場合 → 自動生成
    if ( !$post_id ) {
      $company_name = get_user_meta($user->ID, 'company_name', true);
      $title = $company_name ?: ($user->display_name ?: $user->user_login);

      $new_post_id = wp_insert_post([
        'post_type'   => MKN_COMPANY_CPT,
        'post_status' => 'draft',
        'post_title'  => sanitize_text_field($title),
        'post_author' => $user->ID,
      ]);

      if ( $new_post_id && !is_wp_error($new_post_id) ) {
        update_user_meta($user->ID, 'company_post_id', (int)$new_post_id);
      }
    }
  }
}, 10, 2);


// ACFタクソノミーを投稿タームに同期
add_action('acf/save_post', function($post_id) {
  if (get_post_type($post_id) !== 'company') return;

  // 業種
  $industry = get_field('company_industry', $post_id);
  if ($industry) {
      wp_set_post_terms($post_id, $industry, 'company_industry', false);
  }

  // 地域
  $area = get_field('company_area', $post_id);
  if ($area) {
      wp_set_post_terms($post_id, $area, 'company_area', false);
  }
});


/**
 * =======================================================
 * Frontend Admin 経由で投稿された ACF タクソノミーフィールドを確実に同期
 * =======================================================
 */
add_action('frontend_admin/after_save_post', function($form, $post_id) {
  if (get_post_type($post_id) !== 'company') return;

  // 業種（industry）
  $industry_field = get_field('company_industry', $post_id);
  if (!empty($industry_field)) {
    $industry_terms = is_array($industry_field)
      ? array_map('intval', $industry_field)
      : [(int)$industry_field];
    wp_set_post_terms($post_id, $industry_terms, 'industry', false); // ← 修正
  }

  // 地域（area）
  $area_field = get_field('company_area', $post_id);
  if (!empty($area_field)) {
    $area_terms = is_array($area_field)
      ? array_map('intval', $area_field)
      : [(int)$area_field];
    wp_set_post_terms($post_id, $area_terms, 'area', false); // ← 修正
  }

}, 20, 2);

add_action('init', function(){
  $role = get_role('company_member');
  if ($role) {
    $role->add_cap('edit_posts');
    $role->add_cap('edit_others_posts');
    $role->add_cap('publish_posts');
    $role->add_cap('upload_files');
    $role->add_cap('edit_published_posts');
  }
});


/**
 * =========================================
 * 企業編集ページ（/company-edit/）の不正アクセス防止
 * =========================================
 */
add_action('template_redirect', function () {
  if ( ! is_page('company-edit') || ! is_user_logged_in() ) {
    return;
  }

  $user = wp_get_current_user();

  // 管理者は制限しない
  if ( current_user_can('administrator') ) {
    return;
  }

  // 掲載企業ユーザー以外はアクセス禁止
  if ( ! in_array('company_member', (array)$user->roles, true) ) {
    wp_safe_redirect(site_url('/'));
    exit;
  }

  // ユーザー自身の企業投稿IDを取得
  $own_post_id = (int) get_user_meta($user->ID, 'company_post_id', true);
  if ( ! $own_post_id ) {
    wp_safe_redirect(site_url('/'));
    exit;
  }

  // URLに ?edit_post=xxx が付いている場合を確認
  $req_id = isset($_GET['edit_post']) ? (int) $_GET['edit_post'] : 0;

  // 違うIDを指定されたら強制的に自分の投稿IDにリダイレクト
  if ( $req_id !== $own_post_id ) {
    wp_safe_redirect( add_query_arg('edit_post', $own_post_id, site_url('/company-edit/')) );
    exit;
  }
});



/**
 * =========================================
 * 採用情報編集ページ（/mypage-edit/）の不正アクセス防止＋自動補正
 * =========================================
 */
add_action('template_redirect', function () {
  if ( ! is_page('mypage-edit') || ! is_user_logged_in() ) {
    return;
  }

  $user = wp_get_current_user();

  // 管理者は制限しない
  if ( current_user_can('administrator') ) {
    return;
  }

  // 掲載企業ユーザー以外はアクセス禁止
  if ( ! in_array('company_member', (array)$user->roles, true) ) {
    wp_safe_redirect(site_url('/'));
    exit;
  }

  // 現在のリクエストIDを取得
  $req_id = isset($_GET['edit_post']) ? (int) $_GET['edit_post'] : 0;

  // そのユーザーが投稿した採用情報をすべて取得
  $user_recruits = get_posts([
    'post_type'      => 'recruit',
    'author'         => $user->ID,
    'posts_per_page' => 1,
    'post_status'    => ['publish', 'draft', 'pending'],
    'orderby'        => 'ID',
    'order'          => 'DESC',
    'fields'         => 'ids',
  ]);

  // 採用情報がまだ1件もない場合はマイページへ戻す
  if ( empty($user_recruits) ) {
    wp_safe_redirect(site_url('/mypage/'));
    exit;
  }

  // 自分の最新の採用情報IDを取得
  $own_post_id = (int) $user_recruits[0];

  // 不正な投稿IDを指定された場合、自分の採用情報編集ページにリダイレクト
  if ( $req_id !== $own_post_id ) {
    wp_safe_redirect( add_query_arg('edit_post', $own_post_id, site_url('/mypage-edit/')) );
    exit;
  }
});


// 🔧 Frontend Admin アップロード上限バリデーション強制上書き
add_action('init', function() {
  // JS側のファイル検証を無効化
  add_filter('frontend_admin/validate/file_size', '__return_false');
});

// PHPサーバー側の最大アップロードサイズを10MBに設定
@ini_set('upload_max_filesize', '10M');
@ini_set('post_max_size', '12M');
@ini_set('max_execution_time', '300');
@ini_set('max_input_time', '300');


/**
 * 会社画像を変更した際、古い画像を自動削除（最新1枚だけ保持）
 */
add_action('acf/update_value/name=company_image', function($new_value, $post_id, $field) {

    // 投稿タイプを限定（例：company）※あなたのCPTスラッグに合わせて変更
    if (get_post_type($post_id) !== 'company') {
        return $new_value;
    }

    // 現在DBに保存されている古い画像IDを取得
    $old_value = get_field('company_image', $post_id);

    // 古い画像と新しい画像が異なる場合のみ削除処理
    if ($old_value && $old_value !== $new_value) {
        wp_delete_attachment($old_value, true); // サーバーから完全削除
    }

    return $new_value;
}, 10, 3);



/**
 * 企業情報投稿の公開フロー制御
 */
add_action('save_post_company', function($post_id, $post, $update) {

  // 自動保存やリビジョンをスキップ
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (wp_is_post_revision($post_id)) return;

  // 投稿タイプをチェック
  if (get_post_type($post_id) !== 'company') return;

  $author_id       = (int) $post->post_author;
  $current_user_id = get_current_user_id();
  $current_status  = get_post_status($post_id);

  // --------------------------------------------------------
  // ① 新規作成（初回登録） → draft（下書き）
  // --------------------------------------------------------
  if (!$update && $current_status !== 'publish') {
      wp_update_post([
          'ID'          => $post_id,
          'post_status' => 'draft',
      ]);
      return;
  }

  // --------------------------------------------------------
  // ② 管理者が公開したら → publish に変更
  // --------------------------------------------------------
  if (current_user_can('administrator')) {
      if ($current_status !== 'publish') {
          wp_update_post([
              'ID'          => $post_id,
              'post_status' => 'publish',
          ]);
      }
      return;
  }

  // --------------------------------------------------------
  // ③ 掲載企業ユーザーが編集した場合 → 常に公開維持
  // --------------------------------------------------------
  $user = get_userdata($current_user_id);
  if ($user && in_array('company_member', (array) $user->roles, true)) {

      // 自分の投稿だけ対象にする
      if ($current_user_id === $author_id) {
          wp_update_post([
              'ID'          => $post_id,
              'post_status' => 'publish', // 常に公開を維持
          ]);
      }
  }

}, 20, 3);




/**
 * 掲載企業ユーザーが削除されたら、その企業の投稿（企業情報・採用情報）をすべて削除する
 */
add_action('delete_user', function($user_id) {

  // ▼ 投稿タイプごとの削除対象を定義（必要に応じて増減OK）
  $post_types = ['company', 'recruit'];

  foreach ($post_types as $post_type) {

      // 該当ユーザーが投稿した記事を取得
      $posts = get_posts([
          'post_type'      => $post_type,
          'author'         => $user_id,
          'posts_per_page' => -1,
          'post_status'    => ['publish', 'pending', 'draft', 'private'],
      ]);

      // 投稿が存在すれば削除処理
      if ($posts) {
          foreach ($posts as $post) {
              wp_delete_post($post->ID, true); // true で完全削除（ゴミ箱経由しない）
          }
      }
  }

}, 10, 1);
