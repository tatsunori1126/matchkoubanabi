<?php get_header(); ?>
<main class="l-main p-main">
    <div class="c-page__section-title-wrapper">
        <div class="c-page__section-title">企業詳細</div>
    </div>

    <div class="p-company-single">
        <div class="c-inner">
            <div class="p-company-single__base-card">
                <?php
                // ===============================
                // 企業イメージ画像＋基本情報
                // ===============================
                $company_image_id = get_field('company_image');
                $address     = get_field('company_address');
                $tel         = get_field('company_tel');
                $site        = get_field('company_site');
                $established = get_field('company_established');
                $employees   = get_field('company_employees');
                $capital     = get_field('company_capital');
                $area_terms  = get_the_terms(get_the_ID(), 'area');
                $industry_terms = get_the_terms(get_the_ID(), 'industry');
    
                $area_name     = $area_terms ? esc_html($area_terms[0]->name) : '';
                $industry_name = $industry_terms ? esc_html($industry_terms[0]->name) : '';
    
                if (
                    $company_image_id ||
                    $address || $tel || $site ||
                    $established || $employees || $capital ||
                    $area_name || $industry_name
                ) :
                ?>
                <section class="p-company-single__basic">
                    <div class="p-company-single__basic-inner">
                        <div class="p-company-single__image">
                            <?php if ($company_image_id) : ?>
                                <?php echo wp_get_attachment_image($company_image_id, 'large', false, [
                                    'alt' => get_the_title(),
                                    'class' => 'p-company-single__img'
                                ]); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png"
                                    alt="マッチ工場ナビ"
                                    class="p-company-single__img no-image" />
                            <?php endif; ?>
                        </div>
    
                        <div class="p-company-single__info">
                            <h1 class="p-company-single__name"><?php the_title(); ?></h1>
                            <ul class="p-company-single__list">
                                <?php if ($address) : ?>
                                    <li>住所：<?php echo esc_html($address); ?></li>
                                <?php endif; ?>
    
                                <?php if ($tel) : ?>
                                    <li>電話番号：
                                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $tel)); ?>">
                                            <?php echo esc_html($tel); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
    
                                <?php if ($area_name) : ?>
                                    <li>地域：<?php echo $area_name; ?></li>
                                <?php endif; ?>
    
                                <?php if ($industry_name) : ?>
                                    <li>業種：<?php echo $industry_name; ?></li>
                                <?php endif; ?>
    
                                <?php if ($established) : ?>
                                    <li>設立：<?php echo esc_html($established); ?></li>
                                <?php endif; ?>
    
                                <?php if ($employees) : ?>
                                    <li>従業員数：<?php echo esc_html($employees); ?>名</li>
                                <?php endif; ?>
    
                                <?php if ($capital) : ?>
                                    <li>資本金：<?php echo esc_html($capital); ?></li>
                                <?php endif; ?>
    
                                <?php if ($site) : ?>
                                    <li>ホームページ：
                                        <a href="<?php echo esc_url($site); ?>" target="_blank" rel="noopener">
                                            <?php echo esc_html($site); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
    
                <?php
                // ===============================
                // 会社紹介・代表メッセージ
                // ===============================
                $intro   = get_field('company_intro');
                $message = get_field('company_message');
                ?>
                <?php if ($intro) : ?>
                    <section class="p-company-single__section">
                        <h2 class="p-company-single__sub-title">会社紹介</h2>
                        <div class="p-company-single__text"><?php echo wp_kses_post($intro); ?></div>
                    </section>
                <?php endif; ?>
    
                <?php if ($message) : ?>
                    <section class="p-company-single__section">
                        <h2 class="p-company-single__sub-title">代表メッセージ</h2>
                        <div class="p-company-single__text"><?php echo wp_kses_post($message); ?></div>
                    </section>
                <?php endif; ?>
    
                <?php
                // ===============================
                // 設備・加工内容・素材
                // ===============================
                $facilities = get_field('company_facilities');
                $materials  = get_field('company_materials');
                $processes  = get_field('company_processes');
                if ($facilities || $materials || $processes) :
                ?>
                    <section class="p-company-single__section">
                        <h2 class="p-company-single__sub-title">対応設備・加工内容</h2>
                        <div class="p-company-single__list-wrapper">
                            <?php if ($facilities) : ?><p>■主要設備：<?php echo esc_html($facilities); ?></p><?php endif; ?>
                            <?php if ($materials) : ?><p>■対応素材：<?php echo esc_html($materials); ?></p><?php endif; ?>
                            <?php if ($processes) : ?><p>■加工内容：<?php echo esc_html($processes); ?></p><?php endif; ?>
                        </div>
                    </section>
                <?php endif; ?>
    
                <?php
                // ===============================
                // 自社の強み
                // ===============================
                $str1 = get_field('company_strength_1');
                $str2 = get_field('company_strength_2');
                $str3 = get_field('company_strength_3');
                if ($str1 || $str2 || $str3) :
                ?>
                    <section class="p-company-single__section">
                        <h2 class="p-company-single__sub-title">自社の強み</h2>
                        <ul class="p-company-single__strength">
                            <?php if ($str1) : ?><li>■<?php echo esc_html($str1); ?></li><?php endif; ?>
                            <?php if ($str2) : ?><li>■<?php echo esc_html($str2); ?></li><?php endif; ?>
                            <?php if ($str3) : ?><li>■<?php echo esc_html($str3); ?></li><?php endif; ?>
                        </ul>
                    </section>
                <?php endif; ?>
    
                <?php
                // ===============================
                // 製品紹介・取引先
                // ===============================
                $clients  = get_field('company_clients');
                $products = get_field('company_products');
                if ($clients || $products) :
                ?>
                    <section class="p-company-single__section">
                        <?php if ($clients) : ?>
                            <h2 class="p-company-single__sub-title">主な取引先</h2>
                            <div class="p-company-single__text"><?php echo nl2br(esc_html($clients)); ?></div>
                        <?php endif; ?>
                        <?php if ($products) : ?>
                            <h2 class="p-company-single__sub-title">主要製品・事例紹介</h2>
                            <div class="p-company-single__text"><?php echo wp_kses_post($products); ?></div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
