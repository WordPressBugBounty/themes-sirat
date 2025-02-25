<?php
/**
 * The template part for displaying grid post
 *
 * @package Sirat
 * @subpackage sirat
 * @since Sirat 1.0
 */
?>
<?php  
  $sirat_archive_year  = get_the_time('Y'); 
  $sirat_archive_month = get_the_time('m'); 
  $sirat_archive_day   = get_the_time('d'); 
?>
<div class="col-lg-4 col-md-6">
	<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
	    <div class="grid-post-main-box wow zoomInDown delay-1000" data-wow-duration="2s">
	    	<?php if( get_theme_mod( 'sirat_grid_image_hide_show',true) == 1) { ?>
		      	<div class="box-image">
		          	<?php 
			            if(has_post_thumbnail()) { 
			              the_post_thumbnail(); 
			            }
		          	?>
		        </div>
		    <?php } ?>
	        <h2 class="section-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
	        <?php if( get_theme_mod( 'sirat_grid_postdate',true) == 1 || get_theme_mod( 'sirat_grid_author',true) == 1 || get_theme_mod( 'sirat_grid_comments',true) == 1) { ?>
	            <div class="post-info">
	                <?php if(get_theme_mod('sirat_grid_postdate',true)==1){ ?>
	                    <span class="entry-date"><i class="<?php echo esc_attr(get_theme_mod('sirat_grid_postdate_icon','fas fa-calendar-alt')); ?>"></i><a href="<?php echo esc_url( get_day_link( $sirat_archive_year, $sirat_archive_month, $sirat_archive_day)); ?>"><?php echo esc_html( get_the_date() ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></span><span><?php echo esc_html(get_theme_mod('sirat_grid_post_meta_field_separator','|'));?></span>
	                <?php } ?>

	                <?php if(get_theme_mod('sirat_grid_author',true)==1){ ?>
	                    <span class="entry-author"> <i class="<?php echo esc_attr(get_theme_mod('sirat_grid_author_icon','far fa-user')); ?>"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?><span class="screen-reader-text"><?php the_author(); ?></span></a></span><span><?php echo esc_html(get_theme_mod('sirat_grid_post_meta_field_separator','|'));?></span>
	                <?php } ?>

	                <?php if(get_theme_mod('sirat_grid_comments',true)==1){ ?>
	                    <span class="entry-comments"> <i class="<?php echo esc_attr(get_theme_mod('sirat_grid_comments_icon','fas fa-comments')); ?>"></i><?php comments_number( __('0 Comment', 'sirat'), __('0 Comments', 'sirat'), __('% Comments', 'sirat') ); ?> </span>
	                <?php } ?>
	                <?php echo esc_html (sirat_edit_link()); ?>
	            </div>
	        <?php } ?>
	        <div class="new-text">
	        	<div class="entry-content">
	        		<?php $sirat_theme_lay = get_theme_mod( 'sirat_grid_excerpt_settings','Excerpt');
                  			if($sirat_theme_lay == 'Content'){ ?>
                    		<?php the_content(); ?>
                 		<?php }
                  		if($sirat_theme_lay == 'Excerpt'){ ?>
                    		<?php if(get_the_excerpt()) { ?>
			       						 	<?php $sirat_excerpt = get_the_excerpt(); echo esc_html( sirat_string_limit_words( $sirat_excerpt, esc_attr(get_theme_mod('sirat_excerpt_number','30')))); ?> <?php echo esc_html( get_theme_mod('sirat_grid_excerpt_suffix','') ); ?>
			       						<?php }?>
              <?php }?> 			 
	        	</div>
	        </div>
	        <?php if( get_theme_mod('sirat_grid_button_text','Read More') != ''){ ?>
		        <div class="more-btn">
	            	<a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('sirat_grid_button_text',__('Read More','sirat')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('sirat_grid_button_text',__('Read More','sirat')));?></span></a>
	          	</div>
	        <?php } ?>
	    </div>
	    <div class="clearfix"></div>
  	</article>
</div>