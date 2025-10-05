<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="" />
    <meta property="og:url" content="<?php echo (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/ogp.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="apple-mobile-web-app-title" content="" />
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/common/favicon.ico" />
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/common/favicon.png"/>
    <?php wp_head(); ?>
</head>
<body ontouchstart="" <?php body_class(); ?>> <!-- ontouchstart="" スマホ2回タップしないとリンク先に飛ばない問題の対策 -->
    <?php wp_body_open(); ?>
    <header class="l-header p-header">
        <div class="p-header__inner">
        <?php if (is_front_page() || is_home()) : ?>
            <div class="p-header__logo-link">
                <img class="p-header__logo" src="<?php echo get_template_directory_uri(); ?>/images/common/logo.png" alt="マッチ工場ナビ">
            </div>
        <?php else : ?>
            <a class="p-header__logo-link" href="<?php echo esc_url( home_url('/')); ?>">
                <img class="p-header__logo" src="<?php echo get_template_directory_uri(); ?>/images/common/logo.png" alt="マッチ工場ナビ">
            </a>
        <?php endif; ?>
        <nav class="p-header__nav">
    <ul class="p-header__nav-list-pc">
        <li class="p-header__nav-item">
            <a class="p-header__nav-link" href="<?php echo get_post_type_archive_link('company'); ?>">企業一覧</a>
        </li>
        <li class="p-header__nav-item">
            <a class="p-header__nav-link" href="<?php echo get_post_type_archive_link('recruit'); ?>">採用情報</a>
        </li>
        <li class="p-header__nav-item">
            <a class="p-header__nav-link" href="<?php echo home_url('about'); ?>">サービスについて</a>
        </li>
        <li class="p-header__nav-item">
            <a class="p-header__nav-link" href="<?php echo get_post_type_archive_link('topics'); ?>">トピックス</a>
        </li>

        <?php if ( is_user_logged_in() ) : ?>
            <li class="p-header__nav-item">
                <a class="p-header__nav-link" href="<?php echo home_url('mypage'); ?>">企業様マイページ</a>
            </li>
            <li class="p-header__nav-item">
                <a class="p-header__nav-link" href="<?php echo wp_logout_url( home_url() ); ?>">ログアウト</a>
            </li>
        <?php else : ?>
            <li class="p-header__nav-item">
                <a class="p-header__nav-link" href="<?php echo home_url('login'); ?>">掲載企業様ログイン</a>
            </li>
        <?php endif; ?>

        <li class="p-header__nav-item">
            <a class="p-header__nav-link" href="<?php echo home_url('application'); ?>">掲載申請</a>
        </li>
        <li class="p-header__nav-item">
            <a class="p-header__nav-link-contact" href="<?php echo home_url('contact-input'); ?>">お問い合わせ<i class="fa-solid fa-arrow-right"></i></a>
        </li>
    </ul>
</nav>


            <button type="button" class="hamburger-btn">
                <span class="btn-line"></span>
            </button>
        </div>
    </header>