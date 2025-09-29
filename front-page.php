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
                <span class="c-section-subtitle p-top-area__subtitle">Area</span>
            </div>
            <p class="p-top-area__top-text">お近くの製造業パートナーを探したい企業様は、地域別の検索からご覧ください。</p>
            <?php
            /**
             * 地域→都道府県の階層タクソノミー一覧を出力
             * - タクソノミー名が異なる場合は $taxonomy を置き換え
             * - 「すべて表示したい」ので hide_empty は false
             */

            $taxonomy = 'area'; // ←ここをあなたのタクソノミー名に

            $regions = [
            [ 'title' => '北海道・東北', 'slug' => 'hokkaido-tohoku' ],
            [ 'title' => '関東',         'slug' => 'kanto' ],
            [ 'title' => '中部',         'slug' => 'chubu' ],
            [ 'title' => '関西',         'slug' => 'kansai' ],
            [ 'title' => '中国・四国',   'slug' => 'chugoku-shikoku' ],
            [ 'title' => '九州・沖縄',   'slug' => 'kyushu-okinawa' ],
            ];

            // 地域ごとにラッパーを出力
            echo '<div class="p-top-area__container">';

            foreach ( $regions as $region ) {
                $parent = get_term_by( 'slug', $region['slug'], $taxonomy );

                // 親タームが見つからない場合はスキップ
                if ( ! $parent || is_wp_error( $parent ) ) {
                    continue;
                }

                // 子（都道府県）タームを取得
                $prefectures = get_terms([
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,           // 投稿がなくても表示
                    'parent'     => (int) $parent->term_id,
                    'orderby'    => 'name',          // 50音順で並べたい場合は 'name' でOK
                    'order'      => 'ASC',
                ]);

                echo '<div class="p-top-area__wrapper">';
                echo '<h3 class="p-top-area__item-title">' . esc_html( $region['title'] ) . '</h3>';
                echo '<ul class="p-top-area__item-list">';

                if ( ! empty( $prefectures ) && ! is_wp_error( $prefectures ) ) {
                    foreach ( $prefectures as $pref ) {
                        $link = get_term_link( $pref, $taxonomy );
                        if ( is_wp_error( $link ) ) {
                            continue;
                        }
                        echo '<li class="p-top-area__item">';
                        echo '  <a href="' . esc_url( $link ) . '" class="p-top-area__item-link">' . esc_html( $pref->name ) . '</a>';
                        echo '</li>';
                    }
                }

                echo '</ul>';
                echo '</div>'; // .p-top-area__wrapper
            }

            echo '</div>'; // .p-top-area__container
            ?>
        </div>
    </section>

    <!-- 業種から選ぶ -->
    <section class="p-top-industry">
        <div class="c-inner">
            <div class="c-section-title-wrapper p-top-industry__title-wrapper">
                <h2 class="c-section-title p-top-industry__title">業種から選ぶ</h2>
                <span class="c-section-subtitle p-top-industry__subtitle">Industry</span>
            </div>
            <p class="p-top-industry__top-text">お近くの製造業パートナーを探したい企業様は、地域別の検索からご覧ください。</p>
            <?php
/**
 * 業種（industry）タクソノミー一覧出力
 * 親ターム（大分類）→ 子ターム（詳細業種）をHTML構造そのままで生成
 * - タクソノミー名：industry（変更時は $taxonomy を置き換え）
 * - 親の表示順は $parents の配列順に固定
 * - 子は name 昇順（必要ならタームメタで任意順序に変更可）
 */

$taxonomy = 'industry';

// 親ターム（大分類）のスラッグ順序を指定
$parents = [
  'automotive-transport', // 自動車・輸送機器
  'electronics',          // 電気・電子機器
  'machinery',            // 機械・設備
  'metal-steel',          // 金属・鉄鋼
  'chemical-plastic',     // 化学・プラスチック
  'food-beverage',        // 食品・飲料
  'other-manufacturing',  // その他製造業
];

echo '<div class="p-top-industry__container">';

foreach ( $parents as $parent_slug ) {

    // 親ターム取得
    $parent = get_term_by( 'slug', $parent_slug, $taxonomy );
    if ( ! $parent || is_wp_error( $parent ) ) {
        // 親が存在しない場合はスキップ（未作成時の崩れ防止）
        continue;
    }

    // 子ターム（詳細業種）取得
    $children = get_terms([
        'taxonomy'   => $taxonomy,
        'parent'     => (int) $parent->term_id,
        'hide_empty' => false,     // 投稿が無くても一覧に出したい
        'orderby'    => 'name',    // 50音順／アルファベット順
        'order'      => 'ASC',
    ]);

    echo '<div class="p-top-industry__wrapper">';

    // 見出し：親ターム名（例：自動車・輸送機器）
    echo '<h3 class="p-top-industry__item-title">' . esc_html( $parent->name ) . '</h3>';

    echo '<ul class="p-top-industry__item-list">';

    if ( ! empty( $children ) && ! is_wp_error( $children ) ) {
        foreach ( $children as $child ) {
            $link = get_term_link( $child, $taxonomy );
            if ( is_wp_error( $link ) ) {
                continue;
            }
            echo '<li class="p-top-industry__item">';
            echo '  <a href="' . esc_url( $link ) . '" class="p-top-industry__item-link">' . esc_html( $child->name ) . '</a>';
            echo '</li>';
        }
    }

    echo '</ul>';
    echo '</div>'; // .p-top-industry__wrapper
}

echo '</div>'; // .p-top-industry__container
?>
        </div>
    </section>

    <!-- contact -->
    <?php get_template_part('template-parts/contact'); ?>
</main>
<?php get_footer(); ?>