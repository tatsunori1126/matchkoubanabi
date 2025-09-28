<?php get_header(); ?>
<main class="l-main p-main">
    <div class="p-top-fv">
        <div class="c-inner">
            <div class="p-top-fv__title-wrapper">
                <h1 class="p-top-fv__title">製造業界の未来をつなぐ</h1>
                <h2 class="p-top-fv__subtitle">企業同士のビジネスマッチングから人材採用まで<br>製造業に特化したワンストップソリューション</h2>
                <div class="p-top-fv__link-wrapper">
                    <a href="<?php echo esc_url(home_url('/service/')); ?>" class="c-btn p-top-fv__search-link">企業を探す<i class="fa-solid fa-arrow-right"></i></a>
                    <a href="<?php echo esc_url(home_url('/recruit/')); ?>" class="c-btn p-top-fv__register-link">求人情報を見る<i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- マッチ工場ナビとは -->
    <section class="p-top-about">
        <div class="c-inner">
            <div class="c-section-title-wrapper p-top-about__title-wrapper">
                <h2 class="c-section-title p-top-about__title">マッチ工場ナビとは</h2>
                <span class="c-section-subtitle p-top-about__subtitle">About</span>
            </div>
            <p class="p-top-about__top-text">製造業に特化したビジネスマッチング＆採用プラットフォームです。<br>発注企業は地域・業種からから最適なパートナー企業を検索・相談でき、<br>町工場や中小製造業は自社の強みを発信しながら新たな取引や採用の機会を広げられます。</p>
            <div class="p-top-about__item-container">
                <div class="p-top-about__item-wrapper">
                    <div class="p-top-about__item-icon-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="p-top-about__item-title-wrapper">
                        <h3 class="p-top-about__item-title">最適なマッチング</h3>
                        <p class="p-top-about__item-text">地域・業種をもとに最適な製造パートナーを探せます。</p>
                    </div>
                </div>
                <div class="p-top-about__item-wrapper">
                    <div class="p-top-about__item-icon-wrapper">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="p-top-about__item-title-wrapper">
                        <h3 class="p-top-about__item-title">安心・信頼</h3>
                        <p class="p-top-about__item-text">掲載企業様は審査を通過した製造業者のみなので安心性と信頼性を重視しています。</p>
                    </div>
                </div>
                <div class="p-top-about__item-wrapper">
                    <div class="p-top-about__item-icon-wrapper">
                        <i class="fa-solid fa-arrow-up-right-dots"></i>
                    </div>
                    <div class="p-top-about__item-title-wrapper">
                        <h3 class="p-top-about__item-title">成長を支援</h3>
                        <p class="p-top-about__item-text">掲載・採用情報発信・露出強化などを通じて、中小製造業の新しいビジネスチャンスをサポートします。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 地域から選ぶ -->
    <section class="p-top-area">
        <div class="c-inner">
            <div class="c-section-title-wrapper p-top-area__title-wrapper">
                <h2 class="c-section-title p-top-area__title">地域から選ぶ</h2>
                <span class="c-section-subtitle p-top-area__subtitle">AreaSelect</span>
            </div>
            <p class="p-top-area__top-text">お近くの製造業パートナーを探したい企業様は、地域別の検索からご覧ください。</p>
        </div>
    </section>

    <!-- contact -->
    <?php get_template_part('template-parts/contact'); ?>
</main>
<?php get_footer(); ?>