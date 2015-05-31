<?php
/**
 * Displays the search form of the theme.  (alternate)
 */
?>
<form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" id="search-form" class="searchform clearfix" method="get">
<input required="" aria-required="true" type="search" placeholder="Search &hellip;" class="s field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
<input type="submit" value="Search" id="search-submit" class="submit">
</form><!-- .searchform -->