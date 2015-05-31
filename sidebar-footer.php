<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 */
/**
 * If none of the sidebars have widgets, then let's bail early.
 */
if (!is_active_sidebar('corpo_footer_sidebar_one') &&
    !is_active_sidebar('corpo_footer_sidebar_two') &&
    !is_active_sidebar('corpo_footer_sidebar_three') &&
    !is_active_sidebar('corpo_footer_sidebar_four')) {
    return;
    }
?>
<div id="tertiary" class="footer-widgets-wrapper clearfix" role="complementary">
<div class="footer-widgets-area clearfix inner-wrap">
<div class="tg-one-fourth">
<?php dynamic_sidebar('corpo_footer_sidebar_one'); ?>
</div>
<div class="tg-one-fourth">
<?php dynamic_sidebar('corpo_footer_sidebar_two'); ?>
</div>
<div class="tg-one-fourth">
<?php dynamic_sidebar('corpo_footer_sidebar_three'); ?>
</div>
<div class="tg-one-fourth tg-one-fourth-last">
<?php dynamic_sidebar('corpo_footer_sidebar_four'); ?>
</div>
</div> <!--.footer-widgets-area-->
</div>