<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 
?>
<div class="popup-wrapper">
	<div class="iframe-overlay"></div>
	<div class="iframe-close-button">
		<div class="click-close">CLOSE</div>
	</div>
	<div class="iframe-pop-up">
		<iframe id="course-iframe" class="course-iframe courses-popup" src="<?php echo $course_link; ?>"></iframe>
	</div>
</div>
<section class="panels-section">
	<div class="home-banner-slider courses">
		<img src="<?php echo get_template_directory_uri(); ?>/images/cat-listing.jpg" alt="Banner Image LIT International Limerick"/>
	</div>
	<div class="breadcrumbs bc-cat cat-breadcrumbs">	
		<div class="centered">
			<a href="<?php echo get_option('siteurl'); ?>">Home </a>//<a href="<?php echo get_permalink(524); ?>"> Courses </a>//<span> <?php echo single_term_title( ); ?></span>
			<h1><?php echo single_term_title( ); ?></h1>
		</div>
		<div class="line-circle">
			<div class="the-line"></div>
			<div class="the-circle"></div>
		</div>
	</div>
	<div class="courses-panel">
		
			<?php
				$term_id = get_queried_object()->term_id;
				$the_query = new WP_Query( array(
					'post_type' => 'courses',
					'tax_query' => array(
						array(
							'taxonomy' => 'departments',
							'terms'    => $term_id,
						),
					),
				
				) );
				while ( $the_query->have_posts() ) : $the_query->the_post();
				$course_link = get_field('course_link');
			?>
			<div class="course-list-single">
				<div class="course-link hide"><?php echo $course_link; ?></div>
				<div class="course-list-title"><?php the_title(); ?></div>
				<img class="course-list-arrow" src="<?php echo get_template_directory_uri(); ?>/images/course-arrow.png" alt="course list arrow"/>
			</div>	
			<?php
				endwhile;
				wp_reset_query();
			
			?>
	
	
	</div>
	<div class="cat-panels">
		<div class="course-categories">
			<div id="burger-menu" class="burger-menu open">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class="course-category-text">Course Categories</div>
		</div>
		<?php
			$departments = get_terms(
				'departments',
				array( 'taxonomy' => 'post_tag' )
			);
			$i=1;
			foreach ( $departments as $department ) { 
			$dep = $department->term_id; 
	
			if ($dep == $term_id){
				$current = ' current-cat';
			}else{
				$current = " ";
			}
				
			
			?>
			<a href="<?php echo get_term_link($dep); ?>" class="cat-panel-single<?php echo $current; ?>">
				<div class="box-button box_<?php echo $i; ?>">
					<span class="box-button-plus">+</span>
				</div>
				<div class="course-text <?php if(strlen($department->name) >= 30) { echo 'longer-dept-name'; } ?>"><?php echo $department->name; ?></div>
			</a>
			
			<?php
			$i++;
			} ?>
	</div>
</section>
<script>
jQuery('.course-list-single').each(function(){
	jQuery(this).on('click' , function(){
		var window_width = window.innerWidth;
		var link = jQuery(this).children('.course-link').text();
		if(window_width < 600 ){
			window.open(link, '_blank');
		}else{
			jQuery(this).addClass('');
			jQuery('.popup-wrapper').fadeIn();
			jQuery('.popup-wrapper').toggleClass('popup');
			jQuery('.iframe-overlay').fadeIn();
			document.getElementById('course-iframe').src = link;
		}
	});
});
jQuery('.iframe-close-button').each(function(){
	jQuery(this).on('click' , function(){
		jQuery(this).toggleClass('popup');
		jQuery('.iframe-overlay').fadeOut();
		jQuery('.popup-wrapper').fadeOut();
		jQuery('.popup-wrapper').toggleClass('popup');
		document.getElementById('course-iframe').src = '';
	});
});

</script>
<?php
get_footer();
