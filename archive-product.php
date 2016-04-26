<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
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
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
 <?php
/*-------------------------------------------*/
/*  Archive title
/*-------------------------------------------*/
$page_for_posts = lightning_get_page_for_posts();
// Use post top page（ Archive title wrap to div ）
if ( $page_for_posts['post_top_use'] || get_post_type() != 'post' ) {
  if ( is_year() || is_month() || is_day() || is_tag() || is_author() || is_tax() || is_category() ) {
      $archiveTitle = get_the_archive_title();
      echo '<header class="archive-header"><h1>'. $archiveTitle .'</h1></header>';
  }
}
?>

<?php
/*-------------------------------------------*/
/*  Archive description
/*-------------------------------------------*/
  if ( is_category() || is_tax() || is_tag() ) {
    $category_description = term_description();
    $page = get_query_var( 'paged', 0 );
    if ( ! empty( $category_description ) && $page == 0 ) {
      echo '<div class="archive-meta">' . $category_description . '</div>';
    }
  }
  ?>
  <?php
  	/**
  	 * woocommerce_archive_description hook.
  	 *
  	 * @hooked woocommerce_taxonomy_archive_description - 10
  	 * @hooked woocommerce_product_archive_description - 10
  	 */
  	do_action( 'woocommerce_archive_description' );
  ?>

<?php $postType = lightning_get_post_type(); ?>

<?php do_action('lightning_loop_before'); ?>

<?php if (have_posts()) : ?>

  <?php if( apply_filters( 'is_lightning_extend_loop' , false ) ): ?>
    <?php do_action( 'lightning_extend_loop' ); ?>

  <?php elseif (file_exists(get_stylesheet_directory( ).'/module_loop_'.$postType['slug'].'.php') && $postType != 'post' ): ?>
    <div class="postList">
    <?php while ( have_posts() ) : the_post(); ?>
    <?php get_template_part('module_loop_'.$postType['slug']); ?>
    <?php endwhile; ?>
    </div>

  <?php else: ?>
    <div class="postList">
		<?php
			/**
			 * woocommerce_before_shop_loop hook.
			 *
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
		?>

		<?php woocommerce_product_loop_start(); ?>

			<?php woocommerce_product_subcategories(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php
			/**
			 * woocommerce_after_shop_loop hook.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		?>
    </div>

  <?php endif; // loop() ?>

  <?php
  the_posts_pagination(array (
                          'mid_size'  => 1,
                          'prev_text' => '&laquo;',
                          'next_text' => '&raquo;',
                          'type'      => 'list',
                          'before_page_number' => '<span class="meta-nav screen-reader-text">' . __ ( 'Page', 'lightning' ) . ' </span>'
                      ) );
  ?>
<?php else: ?>
  <?php wc_get_template( 'loop/no-products-found.php' ); ?>
<?php endif; // have_post() ?>
<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
?>
<?php do_action('lightning_loop_after'); ?>

</main><!-- [ /.mainSection ] -->

<div class="col-md-3 col-md-offset-1 subSection">
<?php get_sidebar(get_post_type()); ?>
</div><!-- [ /.subSection ] -->

</div><!-- [ /.row ] -->
</div><!-- [ /.container ] -->
</div><!-- [ /.siteContent ] -->
 <?php get_footer(); ?>
