<?php get_header(); ?>
<main class="l-main p-main">
    <div class="c-page__section-title-wrapper">
        <h1 class="c-page__section-title">お問い合わせ</h1>
    </div>
    <div class="p-contact">
        <div class="c-inner">
            <?php if(!is_front_page()): ?>
                <div class="c-breadcrumbs">
                    <div class="c-breadcrumbs__inner" typeof="BreadcrumbList" vocab="https://schema.org/">
                        <?php if(function_exists('bcn_display')) {
                            bcn_display();
                        } ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="p-contact__input-container">
                <h2 class="p-contact__input-title">サービス内容や掲載申請などに関するお問い合わせを受け付けております。<br>お気軽にご相談ください。</h2>
                <p class="p-contact__input-text">下記フォームよりお問い合わせを承ります。各項目にご入力後、「確認画面へ」ボタンを押してください。</p>
                <?php echo do_shortcode('[contact-form-7 id="394867d" title="お問い合わせ"]'); ?>
                <!-- モーダル（確認画面） -->
                <div id="confirmation-modal" class="modal">
                    <div class="modal-content">
                        <h2 class="p-contact__confirm-title">お問い合わせ<br class="c-pc-hidden">（確認画面）</h2>
                        <p class="p-contact__confirm-text">入力内容をご確認いただき「送信する」ボタンを押してください。</p>
                        <div class="p-contact__confirm-contents-container">
                        <div class="p-contact__confirm-contents-wrapper"><h3 class="p-contact__confirm-contents-title">■お名前</h3><span class="p-contact__confirm-item" id="confirm-your-name"></span></div>
                        <div class="p-contact__confirm-contents-wrapper"><h3 class="p-contact__confirm-contents-title">■会社名</h3><span class="p-contact__confirm-item" id="confirm-company-name"></span></div>
                        <div class="p-contact__confirm-contents-wrapper"><h3 class="p-contact__confirm-contents-title">■メールアドレス</h3><span class="p-contact__confirm-item" id="confirm-your-email"></span></div>
                        <div class="p-contact__confirm-contents-wrapper"><h3 class="p-contact__confirm-contents-title">■電話番号</h3><span class="p-contact__confirm-item" id="confirm-tel-number"></span></div>
                        <div class="p-contact__confirm-contents-wrapper"><h3 class="p-contact__confirm-contents-title">■お問い合わせ内容</h3><div class="p-contact__confirm-item-wrapper"><span class="p-contact__confirm-item" id="confirm-radio-kinds"></span><span id="confirm-contents"></span></div></div>
                        <div class="p-contact__confirm-contents-wrapper"><h3 class="p-contact__confirm-contents-title">■添付ファイル</h3><span class="p-contact__confirm-item" id="confirm-your-file"></span></div>
                    </div>
                        <div class="p-contact__confirm-button-wrapper">
                            <button type="button" class="confirm-button p-contact__confirm-prev-button" id="back-button"><i class="fa-solid fa-chevron-left"></i>入力画面に戻る</button>
                            <button type="submit" class="confirm-button p-contact__confirm-thanks-button" id="submit-button">送信する<i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php get_footer(); ?>