<div class="blog-container slide-container">
	<div class="row">
		<?php 
		global $wp_query;
		global $product;
		$crosssells = get_post_meta( $product->get_id(), '_crosssell_ids',true);
		array_push($crosssells, $product->get_id());
		$terms = get_the_terms( $product->ID , 'product_cat' );
		$term_id = $terms[0]->term_id; 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
		    'posts_per_page'=> 12,
		    'post_type' => 'product',
		    'post__not_in' => $crosssells,
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
			            'field' 		=> 'term_id',
			            'terms'         => $term_id,
			            'operator'      => 'IN' 
			        )
		    	)
		    ),
		);
		$related = new WP_Query( $args ); 
		if( $related->have_posts() ) : 
		?>
		<div class="large-6 medium-12 small-12 column">
			<h4 class="slide-title">Thường mua cùng</h4>
			<div class="related-slider row">
				<?php 

				while( $related->have_posts() ) : $related->the_post();
					global $product;
				    $terms = get_the_terms($product->ID , 'product_cat' );
		    		$cat_name = $terms[0]->name;
		    		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
		    		$width = 170;
				  	$height = 170;
				    $url = get_featured_img($post->ID);
				    $crop = true;
				    $img = aq_resize($url, $width, $height, $crop);
				?>
				<div class="slide column">
					<div class="related-post">
					    <div class="post-thumb">
							<a href="<?php the_permalink();?>">
								<img src="<?=$img?>" alt="<?=get_the_title()?>">
							</a>
						</div>
						<div class="related-text">
							<article>
								<h3 class="related-title">
									<a href="<?php the_permalink();?>"><?php the_title();?></a>
								</h3>
								<span class="related-price">
									<span class="price"><?php echo $product->get_price_html(); ?></span>
								</span>
							</article>
							
							<aside class="related-attributes">
								<?php 
									$attributes = $product->get_attributes();
									foreach ( $attributes as $attribute ) : 
										$values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'ids' ) );
										foreach ($values as $val) {
											$att = get_term_meta($val, $attribute['name'].'_yith_wccl_value', true);
											echo '<span class="related-color" style="background:'.$att.'"></span>';
										}
									endforeach;
								?>
							</aside>
						
						</div>
					</div>
				</div>
				<?php endwhile;?>
			</div>
		</div>
		<?php endif;?>
		<?php wp_reset_postdata()?>

		<?php 
		global $wp_query;
		global $product;
		$crosssells = get_post_meta( $product->get_id(), '_crosssell_ids',true);
		array_push($crosssells, $product->get_id());
		$terms = get_the_terms( $product->ID , 'product_cat' );
		$term_id = $terms[0]->term_id; 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
		    'posts_per_page'=> 12,
		    'post_type' => 'product',
		    'post__not_in' => $crosssells,
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
			            'field' 		=> 'term_id',
			            'terms'         => $term_id,
			            'operator'      => 'IN' 
			        )
		    	)
		    ),
		);
		$related = new WP_Query( $args ); 
		if( $related->have_posts() ) : 
		?>
		<div class="large-6 medium-12 small-12 column">
			<h4 class="slide-title">Sản phẩm tương tự</h4>
			<div class="related-slider row">
				<?php 

				while( $related->have_posts() ) : $related->the_post();
					global $product;
				    $terms = get_the_terms($product->ID , 'product_cat' );
		    		$cat_name = $terms[0]->name;
		    		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
		    		$width = 170;
				  	$height = 170;
				    $url = get_featured_img($post->ID);
				    $crop = true;
				    $img = aq_resize($url, $width, $height, $crop);
				?>
				<div class="slide column">
					<div class="related-post">
					    <div class="post-thumb">
							<a href="<?php the_permalink();?>">
								<img src="<?=$img?>" alt="<?=get_the_title()?>">
							</a>
						</div>
						<div class="related-text">
							<article>
								<h3 class="related-title">
									<a href="<?php the_permalink();?>"><?php the_title();?></a>
								</h3>
								<span class="related-price">
									<span class="price"><?php echo $product->get_price_html(); ?></span>
								</span>
							</article>
							
							<aside class="related-attributes">
								<?php 
									$attributes = $product->get_attributes();
									foreach ( $attributes as $attribute ) : 
										$values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'ids' ) );
										foreach ($values as $val) {
											$att = get_term_meta($val, $attribute['name'].'_yith_wccl_value', true);
											echo '<span class="related-color" style="background:'.$att.'"></span>';
										}
									endforeach;
								?>
							</aside>
						
						</div>
					</div>
				</div>
				<?php endwhile;?>
			</div>
		</div>
		<?php endif;?>
		<?php wp_reset_postdata()?>
	</div>
</div>
