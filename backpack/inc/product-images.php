<?php 
$detect = new Mobile_Detect;
if ( $detect->isMobile() && !$detect->isTablet() ):
?>
<div class="zoom-mobile">
	<?php 
		global $product;
		$attachment_ids = $product->get_gallery_attachment_ids();	
		$terms = get_the_terms( $product->ID , 'product_cat' );
		$term_id = $terms[0]->term_id; 
		$width = 386;
		$height = 386;
	?>
    <div id="product-slider">
		<ul class="product-slider">
			<?php
			$i = 0;
			foreach( $attachment_ids as $attachment_id ): 

				$image_link = wp_get_attachment_url( $attachment_id );	
				$original = aq_resize($image_link, $width, $height, true);
			?>
				<li><img src="<?=$original?>" alt="<?=get_the_title()?>" />
				</li>
			<?php
			endforeach;
			?>
		</ul> 
	</div>
</div> 
<?php else: ?>
<div class="zoom-desk">
	<?php 
		global $product;
		$terms = get_the_terms( $product->ID , 'product_cat' );
		$term_id = $terms[0]->term_id; 
		$width = 386;
		$height = 386;
		$t_w = 74;
		$t_h = 74;
		$attachment_ids = $product->get_gallery_attachment_ids();
		$image_link = wp_get_attachment_url( $attachment_ids[0] );	
		$original = aq_resize($image_link, $width, $height, true);
	?>
    <img id="product_image" src="<?=$original?>" data-zoom-image="<?=$image_link?>" alt="<?=get_the_title()?>" width="<?=$width?>" height="<?=$height?>"/>
	<div id="gallery">
		<div id="gallery_track">
			<ul>
				<?php
				foreach( $attachment_ids as $attachment_id ){ 
					$g_image_link = wp_get_attachment_url( $attachment_id );	

					$g_original = aq_resize($g_image_link, $width, $height, true);
					$g_thumb = aq_resize($g_image_link, $t_w, $t_h, true);
				?>
				  <li> 
					<a href="#" data-image="<?=$g_original?>" data-zoom-image="<?=$g_image_link?>">
			    		<img src="<?=$g_thumb;?>" alt="Hình ảnh" class="lazy">
			  		</a>
			    </li>
				<?php
				}
				?>
			</ul> 
		</div>
	</div>  
</div>
<?php endif;?>
<?php wp_reset_postdata()?>