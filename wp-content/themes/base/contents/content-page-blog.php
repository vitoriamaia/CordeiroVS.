<!-- Main -->
<main class="main">
    <div class="container">
        <section class="main-container">
            <div class="row">
                <div class="col-md-9 col-sm-9">
                    <?php get_template_part('contents/content','loop-news'); ?>
                </div>
                <div class="col-md-3 col-sm-3">
                    <?php dynamic_sidebar('sidebar-blog'); ?>
                </div>
            </div>
        </section>
    </div>
</main>
<!--/ Main -->