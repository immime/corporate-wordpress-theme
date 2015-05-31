<?php
/**
 * Theme Footer Section for our theme.
 *
 */
?>
</div><!-- #main -->
<footer id="colophon" class="site-footer" role="contentinfo">
    <?php get_sidebar('footer'); ?>
    <div class="footer-socket-wrapper clearfix">
        <div class="inner-wrap">
            <div class="copyright">&copy; <?php echo date('Y') ?>
                <a href="<?php echo esc_url(home_url('/')) ?>"><?php echo get_bloginfo('name', 'display') ?></a> | Developed by: <a href="https://ank91.github.io/" target="_blank">Ank91</a>
            </div>
            <nav class="footer-menu" role="navigation">
                <?php
                if (has_nav_menu('footer')) {
                    wp_nav_menu(array('theme_location' => 'footer', 'container' => '', 'depth' => -1, 'menu_class' => 'menu-footer'));
                }
                ?>
            </nav>
            <!--.footer-menu-->
        </div>
    </div>
</footer>
<a class="scroll-top" title="Move to Top" href="#page"><i class="fa fa-chevron-up"></i><span class="screen-reader-text">Move to Top</span></a>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>