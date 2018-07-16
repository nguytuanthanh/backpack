<?php get_header()?>
<?php get_template_part('inc/breadcrumb'); ?>
<div id="main-content">
	<div class="row">
		<div class="column main-col">
			<div class="page-content">
				<section class="page-title">
					<h1><?php the_title();?></h1>
				</section>
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
	</div>
</div>
<?php get_footer()?>