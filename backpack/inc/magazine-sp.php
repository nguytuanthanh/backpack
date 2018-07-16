<div class="magazine-contain">
	<div class="row">
		<div class="column">
			<section class="page-title">
				<h2>Tin tức</h2>
			</section>
			<aside class="redirect-life">
				<a href="<?=get_home_url();?>/tin-tuc/">Xem trang tin tức Lila</a>
			</aside>
		</div>
	</div>
	<div class="row small-up-1 medium-up-3 large-up-3">
		<?php 
		global $wp_query;
		$args = array(
		    'posts_per_page'=> 3,
		    'post_type'=> 'post'
		);
		query_posts( $args );
		if( have_posts() ) : while( have_posts() ) : the_post();
		$categories=get_the_category( $post->ID );
		$cat_name = $categories[0]->name;
		$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
		$width = 360;
	  	$height = 240;
	    $url = get_featured_img($post->ID);
	    $crop = true;
	    $img = theme_thumb($url, $width, $height, $crop);
		?>
		<div class="column column-block item">
		    <div class="item-thumb">
				<a href="<?php the_permalink()?>">
					<img class="lazy" src="data:image/gif;base64,R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-original="<?=$img?>" alt="<?=get_the_title()?>">
				</a>
			</div>
			<article class="magazine-item-text">
				<h3 class="item-title">
					<a href="<?php the_permalink()?>"><?php the_title()?></a>
				</h3>
			</article>
		</div>
		<?php 
		endwhile;
		endif;?>
		<?php wp_reset_postdata()?>
	</div>
</div>