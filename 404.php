<?php get_header(); ?>
<main class="l-main p-main">
    <div class="p-error-404">
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
            <div class="error-404-container">
                <div class="error-404-box">
                    <h1 class="error-404-title">404 NOT FOUND.</h1>
                    <p class="error-404-text">お探しのページが見つかりませんでした。</p>
                </div>
                <a href="<?php echo esc_url( home_url('/')); ?>" class="error-404-toppage">トップページ</a>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>