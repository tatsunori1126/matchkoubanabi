jQuery(function() {
    const speed = 700; // スクロールスピード

    // ページ全体がロードされた後に実行
    jQuery(window).on('load', function() {
        const headerH = jQuery('.l-header').height(); // ヘッダーの高さを取得
        const hash = window.location.hash;

        // URLにハッシュが存在する場合、対象の位置までスクロール
        if (hash !== '' && hash !== undefined) {
            let target = jQuery(hash);
            target = target.length ? target : jQuery('[name=' + hash.slice(1) + ']');
            if (target.length) {
                let position = target.offset().top;
                jQuery('html,body').animate({ scrollTop: position }, speed, 'swing');
            }
        }
    });

    // ページトップへスクロール
    jQuery('[data-pagetop]').on('click', function(e) {
        e.preventDefault();
        jQuery('html, body').animate({ scrollTop: 0 }, speed, 'swing');
    });

    // ページ内リンクによるスクロール
    jQuery('[data-scroll-link]').on('click', function (e) {
        e.preventDefault();
        let href = jQuery(this).attr('href');
        let target = jQuery(href === '#' || href === '' ? 'html' : href);
    
        // ヘッダーの高さを取得（追従固定ヘッダー）
        const headerH = jQuery('.l-header').outerHeight(); // `outerHeight` で高さを取得（パディング含む）
        
        // ターゲットの位置を計算してヘッダーの高さ分調整
        let position = target.offset().top - headerH;
    
        // アニメーションでスクロール
        jQuery('html, body').animate({ scrollTop: position }, speed, 'swing');
    });
});

// ハンバーガーボタンのクリックイベント
jQuery('.hamburger-btn').on('click', function () {
jQuery('.btn-line').toggleClass('open');
jQuery('.p-header__nav').fadeToggle(500).toggleClass('active'); // メニューのフェードイン・フェードアウトとクラスの追加
});

// メニュー項目クリック時のイベント
jQuery(".p-header__nav-list a").click(function () {
if (jQuery(window).width() < 1000) {
    jQuery(".btn-line").removeClass('open');
    jQuery('.p-header__nav').fadeOut(500).removeClass('active');
}
});

// ブラウザリサイズ時に処理をリセット（リサイズ時のみ発動するように）
jQuery(window).on('resize', function () {
if (jQuery(window).width() >= 1000) {
    jQuery('.p-header__nav').show(); // メニューを表示
    jQuery('.btn-line').removeClass('open'); // ハンバーガーボタンの状態をリセット
    jQuery('.p-header__nav').removeClass('active'); // メニューの状態をリセット
} else if (!jQuery('.btn-line').hasClass('open')) {
    jQuery('.p-header__nav').hide(); // 999px以下で、メニューが開かれていない時は非表示にする
}
});

