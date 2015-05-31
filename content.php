<?php
/**
 * The template used for displaying post loop
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title();  ?></a>
        </h2>
    </header>
    <?php if( has_post_thumbnail()&&!post_password_required() ) { ?>
        <figure class="entry-thumbnail">
            <a rel="bookmark" title="<?php the_title_attribute()?>" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'featured-blog-small', array( 'alt' => get_the_title() ) ); ?>
            </a>
        </figure>
  	<?php	}  ?>
	<div class="entry-content clearfix">
        <?php the_excerpt(); ?>
	</div>
    <?php corpo_entry_meta(); ?>
</article>