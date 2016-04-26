<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<?php get_template_part('module_pageTit'); ?>
<?php get_template_part('module_panList'); ?>

<div class="section siteContent">
<div class="container">
<div class="row">

<main class="col-md-8 mainSection" id="main" role="main">

<?php
if( apply_filters( 'is_lightning_extend_single' , false ) ):
    do_action( 'lightning_extend_single' );
else:
if (have_posts()) : while ( have_posts() ) : the_post();?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
	<?php get_template_part('module_loop_post_meta');?>
	<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="entry-body">
		<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
		?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>
	</div><!-- [ /.entry-body ] -->

	<div class="entry-footer">
	<?php
	$args = array(
		'before'           => '<nav class="page-link"><dl><dt>Pages :</dt><dd>',
		'after'            => '</dd></dl></nav>',
		'link_before'      => '<span class="page-numbers">',
		'link_after'       => '</span>',
		'echo'             => 1 );
	wp_link_pages( $args ); ?>

	<?php
	/*-------------------------------------------*/
	/*  Category and tax data
	/*-------------------------------------------*/
    $args = array(
        'template' => __( '<dl><dt>%s</dt><dd>%l</dd></dl>','lightning' ),
        'term_template' => '<a href="%1$s">%2$s</a>',
    );
    $taxonomies = get_the_taxonomies($post->ID,$args);
    $taxnomiesHtml = '';
    if ($taxonomies) {
		foreach ($taxonomies as $key => $value) {
			if ( $key != 'post_tag' ) {
				$taxnomiesHtml .= '<div class="entry-meta-dataList">'.$value.'</div>';
			}
    	} // foreach
	} // if ($taxonomies)
	$taxnomiesHtml = apply_filters( 'lightning_taxnomiesHtml', $taxnomiesHtml );
	echo $taxnomiesHtml;
	?>

	<?php $tags_list = get_the_tag_list();
	if ( $tags_list ): ?>
	<div class="entry-meta-dataList entry-tag">
	<dl>
	<dt><?php _e('Tags','lightning') ;?></dt>
	<dd class="tagCloud"><?php echo $tags_list; ?></dd>
	</dl>
	</div><!-- [ /.entry-tag ] -->
	<?php endif; ?>
	</div><!-- [ /.entry-footer ] -->

	<?php comments_template( '', true ); ?>
</article>
<?php endwhile;endif;
endif;
?>

<nav>
  <ul class="pager">
    <li class="previous"><?php previous_post_link( '%link', '%title' ); ?></li>
    <li class="next"><?php next_post_link( '%link', '%title' ); ?></li>
  </ul>
</nav>

</main><!-- [ /.mainSection ] -->

<div class="col-md-3 col-md-offset-1 subSection">
<?php get_sidebar(get_post_type()); ?>
</div><!-- [ /.subSection ] -->

</div><!-- [ /.row ] -->
</div><!-- [ /.container ] -->
</div><!-- [ /.siteContent ] -->
<?php get_footer(); ?>
