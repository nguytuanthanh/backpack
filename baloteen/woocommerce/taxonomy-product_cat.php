<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header()?>
<?php get_template_part('inc/breadcrumb'); ?>
<div id="main-content">
    <div class="row">
    	<div class="column">
			<header class="page-title">
	    		<h1><?php woocommerce_page_title()?></h1>
	    	</header>
			<?php 
				global $product;
				$cat_obj = $wp_query->get_queried_object();
				$category_id  = $cat_obj->term_id;
				
			;?>
			<?php foreach ( $variation['attributes'] as $slug ): 
				if ( $term = get_term_by( 'slug', $slug, 'pa_color' ) ): 
					echo $term->name; 
				endif;
				endforeach;?>

			<input type="hidden" value="<?=$category_id?>" id="cat_parent_id">
			<div class="filter">
				<div class="wrap-filter">
					<div class="filter-attr">
						<div class="ttl-left">
							Màu sắc
						</div>
						<div class="ttl-right">
							<ul>
			                <?php 
			                $options = array('hide_empty' => false);
							$color = 'pa_mau-sac';
							$terms = get_terms('pa_mau-sac', $options);
							foreach ($terms as $value) :
								$value = get_term_meta($value->term_id, $color.'_yith_wccl_value', true);
							?>
								<li><label for="" style="background: <?=$value?>"><input type="checkbox" name=""></label><span></span></li>
			                <?php endforeach; ?>
			                </ul>
						</div>
					</div>

					<div class="filter-attr">
						<div class="ttl-left">
							Phong cách
						</div>
						<div class="ttl-right">
							<ul>
			                	<?php 
									$args = array(
									     'child_of' => $category_id
									); 

									$terms = get_terms('product_cat', $args);
									foreach ($terms as $cat):
										$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
										$image = wp_get_attachment_url( $thumbnail_id );
									?>
									<li><label><input type="checkbox" class="chkbox chkbrand" value="<?=$cat->term_id?>"> <img src="<?=$image?>" alt="<?=$cat->name?>" width="50"></label></li>
								<?php		
									endforeach;
			                	?>

			                </ul>
						</div>
					</div>

				</div>
			</div>
			<div id="cat_content">
				<div class="small-up-2 medium-up-3 large-up-4">
					<?php 
					global $wp_query;
					global $product;
					$cat_obj = $wp_query->get_queried_object();
					$category_id  = $cat_obj->term_id;
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$args = array(
					    'posts_per_page'=> 20,
					    'post_type' => 'product',
					    'paged' => $paged,
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
						            'terms'         => $category_id,
						            'operator'      => 'IN' 
						        )
		                	)
		                ),
					);
					$query = new WP_Query( $args );
					if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();
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
					<?php endwhile;?>
					<div id="pagination">
						<?php pagination($query->max_num_pages); ?>
					</div>
					<?php else: ?>
					<div class="coloumn">
						<p>Sản phẩm đag được cập nhật. Xin vui lòng quay lại sau.</p>
					</div>
					<?php endif;?>
					<?php wp_reset_query()?>
				</div>		
			</div>
		</div>
	</div>
</div>
<?php get_footer()?>
