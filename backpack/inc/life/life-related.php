<?php 
global $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'posts_per_page'=> 10,
    /*'post_type' => 'product',
    'tax_query'     => array(
    	'meta_query'	=> array(
  		   'relation'		=> 'AND',
    		array(
    			'key'		=> '_stock_status',
    			'value'		=> 'outofstock',
    			'compare'	=> 'NOT IN',
    		)
    	)
    ),*/
);
$related = new WP_Query( $args ); 
if( $related->have_posts() ) : 
?>
<div class="recent-posts">
	<div class="tl-head">
		<h2 class="tl-title"><span>Sản phẩm bán chạy</span></h2>
	</div>
	<div class="related-posts">
		<div class="small-up-2 medium-up-4 large-up-4 row">
			<?php 
			while( $related->have_posts() ) : $related->the_post();
				global $product;
			  	$width = 187;
			  	$height = 222;
			    $url = get_featured_img( $product->ID );
			    $crop = true;
			    $img = theme_thumb($url, $width, $height, $crop);
			    $terms = get_the_terms( $product->ID , 'product_cat' );
	    		$cat_name = $terms[0]->name;
	    		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
			    $price = $product->get_price();
			    if($product->is_on_sale() && $product->get_regular_price()) :
					$price = wc_price($product->get_sale_price());
				else:
					$price = wc_price($product->get_regular_price());
				endif;
			?>
			<div class="column column-block related-post entry">
				<div class="related-thumb">
					<div class="related-thumb-img thumb-cover mask-img">
						<div class="mask"></div>
						<a href="<?php the_permalink();?>"><img class="lazy" data-src="<?=$img?>" alt="<?=get_the_title();?>"></a>
					</div>
				</div>
				<h3 class="entry-title">
					<a href="<?php the_permalink();?>"><?php the_title();?></a>
				</h3>
			</div>
			<?php endwhile;?>
		</div>
	</div>
</div>
<?php endif;?>
<?php wp_reset_postdata()?>