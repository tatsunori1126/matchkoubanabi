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
                        <a class="p-header__nav-link" href="<?php echo home_url('about'); ?>">企業一覧</a>
                    </li>
                    <li class="p-header__nav-item">
                        <a class="p-header__nav-link" href="<?php echo home_url('products'); ?>">採用情報</a>
                    </li>
                    <li class="p-header__nav-item">
                        <a class="p-header__nav-link" href="<?php echo home_url('equipment'); ?>">マッチ工場ナビとは</a>
                    </li>
                    <li class="p-header__nav-item">
                        <a class="p-header__nav-link" href="<?php echo home_url('company'); ?>">お問い合わせ</a>
                    </li>
                    <li class="p-header__nav-item">
                        <a class="p-header__nav-link" href="<?php echo get_post_type_archive_link('news'); ?>">お知らせ・ブログ</a>
                    </li>
                    <li class="p-header__nav-item">
                        <a class="p-header__nav-link" href="<?php echo home_url('recruit'); ?>">会員登録</a>
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