<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header()?>
<?php 
get_template_part('./inc/slider');
?>
<div id="main-content">
	<div class="row">
		<div class="product-section column">
			<section class="home-title">
				<h1>Balo</h1>
			</section>
			<div id="ajax-posts" class="row small-up-2 medium-up-4 large-up-4">
				<?php 
				global $wp_query;
				global $product;
				$args = array(
				    'posts_per_page'=> 8,
				    'post_type' => 'product',
	                'tax_query'     => array(
	                	'meta_query'	=> array(
	              		   'relation'		=> 'AND',
	                		array(
	                			'key'		=> '_stock_status',
	                			'value'		=> 'outofstock',
	                			'compare'	=> 'NOT IN',
	                		),
	                		array(
					            'taxonomy'      => 'product_cat',
					            'field' => 'term_id',
					            'terms'         => 15,
					            'operator'      => 'IN' 
					        )
	                	)
	                ),
				);
				query_posts( $args );
				if( have_posts() ) : while( have_posts() ) : the_post();
				    $terms = get_the_terms( $post->ID, 'product_cat' );
		    		$cat_name = $terms[0]->name;
		    		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
				  	$width = 270;
				  	$height = 270;
				    $url = get_featured_img($post->ID);
				    $crop = true;
				    $img = aq_resize($url, $width, $height, $crop);
				?>
				<div class="column column-block">
					<div class="item-box">
						<div class="item-thumb">
							<a href="<?php the_permalink()?>">
								<img src="<?=$img?>" alt="<?=get_the_title()?>">
							</a>
						</div>
						<article class="item-text">
							<h3 class="item-title">
								<a href="<?php the_permalink()?>"><?php the_title()?></a>
							</h3>
							<span class="item-price">
								<span class="price"><?php echo $product->get_price_html(); ?></span>
							</span>
						</article>
					</div>
				</div>
				<?php endwhile;
				endif;?>
			</div>
			<?php wp_reset_postdata()?>
		</div>
		<div class="product-section column">
			<section class="home-title">
				<h2>Túi chéo</h2>
			</section>
			<div id="ajax-posts" class="row small-up-2 medium-up-4 large-up-4">
				<?php 
				global $wp_query;
				global $product;
				$args = array(
				    'posts_per_page'=> 8,
				    'post_type' => 'product',
	                'tax_query'     => array(
	                	'meta_query'	=> array(
	              		   'relation'		=> 'AND',
	                		array(
	                			'key'		=> '_stock_status',
	                			'value'		=> 'outofstock',
	                			'compare'	=> 'NOT IN',
	                		),
	                		array(
					            'taxonomy'      => 'product_cat',
					            'field' => 'term_id',
					            'terms'         => 16,
					            'operator'      => 'IN' 
					        )
	                	)
	                ),
				);
				query_posts( $args );
				if( have_posts() ) : while( have_posts() ) : the_post();
				    $terms = get_the_terms( $post->ID, 'product_cat' );
		    		$cat_name = $terms[0]->name;
		    		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
		    		$width = 270;
				  	$height = 270;
				    $url = get_featured_img($post->ID);
				    $crop = true;
				    $img = aq_resize($url, $width, $height, $crop);
				?>
				<div class="column column-block">
					<div class="item-box">
						<div class="item-thumb">
							<a href="<?php the_permalink()?>">
								<img src="<?=$img?>" alt="<?=get_the_title()?>">
							</a>
						</div>
						<article class="item-text">
							<h3 class="item-title">
								<a href="<?php the_permalink()?>"><?php the_title()?></a>
							</h3>
							<span class="item-price">
								<span class="price"><?php echo $product->get_price_html(); ?></span>
							</span>
						</article>
					</div>
				</div>
				<?php endwhile;
				endif;?>
			</div>
			<?php wp_reset_postdata()?>
		</div>
		<div class="product-section column">
			<section class="home-title">
				<h2>Gối</h2>
			</section>
			<div id="ajax-posts" class="row small-up-2 medium-up-4 large-up-4">
				<?php 
				global $wp_query;
				global $product;
				$args = array(
				    'posts_per_page'=> 8,
				    'post_type' => 'product',
	                'tax_query'     => array(
	                	'meta_query'	=> array(
	              		   'relation'		=> 'AND',
	                		array(
	                			'key'		=> '_stock_status',
	                			'value'		=> 'outofstock',
	                			'compare'	=> 'NOT IN',
	                		),
	                		array(
					            'taxonomy'      => 'product_cat',
					            'field' => 'term_id',
					            'terms'         => 17,
					            'operator'      => 'IN' 
					        )
	                	)
	                ),
				);
				query_posts( $args );
				if( have_posts() ) : while( have_posts() ) : the_post();
				    $terms = get_the_terms( $post->ID, 'product_cat' );
		    		$cat_name = $terms[0]->name;
		    		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
		    		$width = 270;
				  	$height = 270;
				    $url = get_featured_img($post->ID);
				    $crop = true;
				    $img = aq_resize($url, $width, $height, $crop);
				?>
				<div class="column column-block">
					<div class="item-box">
						<div class="item-thumb">
							<a href="<?php the_permalink()?>">
								<img src="<?=$img?>" alt="<?=get_the_title()?>">
							</a>
						</div>
						<article class="item-text">
							<h3 class="item-title">
								<a href="<?php the_permalink()?>"><?php the_title()?></a>
							</h3>
							<span class="item-price">
								<span class="price"><?php echo $product->get_price_html(); ?></span>
							</span>
						</article>
					</div>
				</div>
				<?php endwhile;
				endif;?>
			</div>
			<?php wp_reset_postdata()?>
		</div>
	</div>
</div>
<aside class="gap"></aside>
<div class="magazine-contain">
	<div class="row">
		<div class="column">
			<section class="magazine-title">
				<h4>Tin tức</h4>
			</section>
			<aside class="redirect-life">
				<a href="http://thoitranglita.com/tin-tuc/">Xem trang tin tức</a>
			</aside>
		</div>
	</div>
	<div class="row small-up-1 medium-up-3 large-up-3">
		<?php 
		global $wp_query;
		$args = array(
		    'posts_per_page'=> 3,
		);
		$news = new WP_Query( $args );
		if( $news->have_posts() ) : while( $news->have_posts() ) : $news->the_post();
		  	$width = 270;
		  	$height = 405;
		    $terms = get_the_terms( $post->ID, 'product_cat' );
    		$cat_name = $terms[0]->name;
    		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
		?>
		<div class="column column-block item">

		    <div class="item-thumb">
				<a href="<?php the_permalink()?>">
					<?php the_post_thumbnail('medium'); ?>
				</a>
			</div>

			<article class="magazine-item-text">
				<h3 class="item-title">
					<a href="<?php the_permalink()?>"><?php the_title()?></a>
				</h3>
			</article>
		</div>
	<?php endwhile;?>
		<?php endif;?>
		<?php wp_reset_postdata()?>
	</div>
</div>	
<?php get_footer()?>    
