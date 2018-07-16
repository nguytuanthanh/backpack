<div class="tl-contain left-col">
	<div class="row small-up-1 medium-up-1 large-up-1">
		<?php 
		global $wp_query;
		//$category = get_category( get_query_var( 'cat' ) );
		//$catid = $category->cat_ID;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
	        'posts_per_page'=>10,
	        'paged'=>$paged,
	        //'cat'  => $catid
	      );
		query_posts( $args );
		if( have_posts() ) : while( have_posts() ) : the_post();
		  	$width = 234;
		  	$height = 234;
		    $url = get_featured_img( $post->ID );
		    $crop = true;
		    $img = theme_thumb($url, $width, $height, $crop);
		    $categories=get_the_category( $post->ID );
			$cat_name = $categories[0]->name;
			$cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
			$content = strip_tags(get_the_content());
		    $limit = 120;
		    $content = short_content($content, $limit);
		?>
		<div class="column column-block entry">
			<div class="entry-wrap">
			    <div class="entry-thumb">
					<div class="entry-thumb-img thumb-cover mask-img">
						<a href="<?php the_permalink()?>">
							<img class="lazy" src="<?=$img?>" alt="<?=get_the_title()?>">
							<div class="mask"></div>
						</a>
					</div>
				</div>
				<div class="entry-text">
					<div class="entry-meta post-meta">
						<div class="entry-cat">
							<a href="<?=$cat_link?>" style="background: #f18597;"><?=$cat_name?></a>
						</div>
					</div>
					<article>
						<h3>
							<a href="<?php the_permalink()?>"><?php the_title()?></a>
						</h3>
					</article>
					<div class="entry-date">
						<span>10/05/2017</span>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile;
			else:?>
			<div class="column">
			<p>Bài viết đang được cập nhật.</p>
			</div>
		<?php endif;?>
		<?php wp_reset_query()?>
	</div>
</div>