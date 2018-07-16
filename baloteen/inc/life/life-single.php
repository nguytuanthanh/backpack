<div class="tl-contain left-col">
	<div class="content">
		<header>
			<?php 
	        $categories=get_the_category( $post->ID );
			$cat_name = $categories[0]->name;
			$cat_link = esc_url( get_category_link( $categories[0]->term_id ) );
			$date =  date("d.m.Y", strtotime(get_the_date('', $post->ID)));
			?>
			<div class="entry-meta c-meta">
				<div class="entry-cat">
					<a href="<?=$cat_link?>" style="background:#b190db"><?=$cat_name?></a>
				</div>
			</div>
			<div class="post-title">
				<h1><?php the_title()?></h1>
			</div>
			<div class="time-page-meta entry-date">
				<span><?=$date?></span>
			</div>
		</header>
		<div class="post-content">
			<?php 
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		else:
			  echo '<p>Bài viết đang được cập nhật</p>';
		endif;
		?>
		</div>
	</div>
	<?php //get_template_part('inc/life/life-related'); ?>
	

	<div class="recent-posts">
				
	</div>
</div>