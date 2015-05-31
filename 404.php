<?php
/**
 * The template for displaying 404 pages.
 *
 */
?>
<?php get_header(); ?>
    <div id="primary">
        <main id="main" class="clearfix" role="main">
            <section class="error-404 not-found">
                <div class="page-content">
                    <header class="page-header">
                        <h1 class="page-title">Oops! That page can&rsquo;t be found.</h1>
                    </header>
                    <p>It looks like nothing was found at this location. Try the search below.</p>
                    <?php get_template_part('searchform', 'two'); ?>
                </div>
                <!-- .page-content -->
            </section>
            <!-- .error-404 -->
        </main>
        <!-- #content -->
    </div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>