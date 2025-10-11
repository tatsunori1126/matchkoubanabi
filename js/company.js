document.addEventListener('DOMContentLoaded', function() {
    const allBtn = document.getElementById('js-filter-all-btn');
    const toggleBtn = document.getElementById('js-filter-toggle-btn');
    const panel = document.getElementById('js-filter-panel');

    // ✅ body クラスからタクソノミーページかどうかを判定
    const isTaxPage = document.body.classList.contains('tax-area') || document.body.classList.contains('tax-industry');

    // ✅ タクソノミーページの場合は初期状態を固定
    if (isTaxPage) {
        toggleBtn.classList.add('active');
        allBtn.classList.remove('active');
    }

    // 「全て」ボタン
    allBtn.addEventListener('click', () => {
        // ✅ taxonomy ページでは「全て」ボタン無効
        if (isTaxPage) return;

        panel.style.maxHeight = null;
        panel.classList.remove('open');
        allBtn.classList.add('active');
        toggleBtn.classList.remove('active');
    });

    // 「地域・業種から選ぶ」ボタン
    toggleBtn.addEventListener('click', () => {
        const isOpen = panel.classList.contains('open');

        if (isOpen) {
            // 閉じるアニメーション
            panel.style.maxHeight = panel.scrollHeight + "px";
            setTimeout(() => {
                panel.style.maxHeight = "0";
            }, 10);
            panel.classList.remove('open');

            // ✅ taxonomy ページでは閉じても常に青を維持
            if (!isTaxPage) {
                toggleBtn.classList.remove('active');
                allBtn.classList.add('active');
            }

        } else {
            // 開くアニメーション
            panel.classList.add('open');
            panel.style.maxHeight = panel.scrollHeight + "px";
            toggleBtn.classList.add('active');
            allBtn.classList.remove('active');
        }
    });

    // アニメーション終了後にmaxHeightリセット
    panel.addEventListener('transitionend', () => {
        if (panel.classList.contains('open')) {
            panel.style.maxHeight = 'none';
        }
    });
});

// ✅ jQuery部分（共通）
jQuery(function ($) {
    $('#js-filter-all-btn').on('click', function () {
        const archiveUrl = '/company/'; // ← カスタム投稿タイプ「company」のアーカイブURL
        const isTaxPage = $('body').hasClass('tax-area') || $('body').hasClass('tax-industry');

        // ✅ taxonomy ページでは「全て」ボタン無効化
        if (isTaxPage) return;

        window.location.href = archiveUrl;
    });
});
