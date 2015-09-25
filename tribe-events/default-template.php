<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();

$wrap_off = tribe_event_in_category('film-festival') && is_single();
?>
<?php /* $isSingleEvent = in_array('single-tribe_events', get_body_class()); ?>
<pre>
<?php echo get_the_ID(); ?>
<?php  print_r(get_terms('tribe_events_cat')); ?>
<?php  print_r(get_taxonomies()); ?>
</pre>
<pre style="background:orange;">
<?php  print_r(get_the_terms(get_the_ID(), 'tribe_events_cat')); 
echo tribe_event_in_category('film-festival');
echo 'anything';
print_r(tribe_events_get_event());
?>
</pre>
<?php if(tribe_is_event() && is_single()) { ?>
TRUE
<?php } else { ?>
FALSE
<?php } */ ?>

			<div id="content"<?php echo $wrap_off ? ' class="festival-event-page"':''; ?>>
				<div id="inner-content" class="<?php echo $wrap_off ? '' : 'wrap '; ?>cf">
						<main id="main" class="cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
						
							
							<?php // TEMPLATE FOR MOST EVENTS
							if (!$wrap_off) { ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-primary cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<?php /* if (1 == 2) { ?>
								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

									<?php 
									<p class="byline vcard">
										<?php printf( __( 'Posted', 'bonestheme').' <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> '.__( 'by',  'bonestheme').' <span class="author">%3$s</span>', get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
									</p>
									 ?>

								</header> <?php // end article header ?>
								<?php } */ ?>
								
								<section class="entry-content cf" itemprop="articleBody">
									<?php tribe_events_before_html(); ?>
									<?php tribe_get_view(); ?>
									<?php tribe_events_after_html(); ?>
								</section> <?php // end article section ?>

								<footer class="article-footer cf">

								</footer>

							</article>


							<?php get_sidebar(); ?>
							<?php } else {
								
							// TEMPLATE FOR FILM FESTIVAL EVENTS
								$festivalMeta = get_post_meta(get_the_ID());
								$festivalPostImageArray = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'carousel');
								$festivalOverrideImageArray = wp_get_attachment_image_src( get_attachment_id_from_src($festivalMeta['_laskins_carousel_override_image'][0]), 'carousel');
								$festivalPostImageMobileArray = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'carousel-mobile');
								$festivalOverrideImageMobileArray = wp_get_attachment_image_src( get_attachment_id_from_src($festivalMeta['_laskins_carousel_override_image'][0]), 'carousel-mobile');
								$festivalImage = $festivalMeta['_laskins_carousel_override_image'][0] ? $festivalOverrideImageArray[0] :$festivalPostImageArray[0];
								$festivalImageMobile = $festivalMeta['_laskins_carousel_override_image'][0] ? $festivalOverrideImageMobileArray[0] :$festivalPostImageMobileArray[0];
							?>
								<?php /* <pre>
								<?php echo tribe_get_start_date(get_the_ID(), false, 'Y-m-d'); ?>
								</pre>
								<pre style="background:orange">
								<?php echo tribe_get_end_date(get_the_ID(), false, 'Y-m-d');  ?>
								</pre> */ ?>
								<header class="entry-header">
									<div class="heading-mobile">
										<?php if ($festivalMeta['_laskins_carousel_super_title'][0]) { ?>
											<h3><?php echo $festivalMeta['_laskins_carousel_super_title'][0]; ?></h3>
										<?php } ?>
										<h2><?php the_title(); ?></h2>
										<?php if (get_the_excerpt()) { ?>
											<p><?php echo get_the_excerpt(); ?></p>
										<?php } ?>
									</div>
									<div class="heading-desktop"<?php echo ($festivalMeta['_laskins_carousel_exceprt_text_color'][0] || $festivalMeta['_laskins_carousel_exceprt_background_color'][0] || $festivalMeta['_laskins_carousel_exceprt_position_left'][0] || $festivalMeta['_laskins_carousel_exceprt_position_top'][0]) ? 'style="'.($festivalMeta['_laskins_carousel_exceprt_text_color'][0] ? 'color:'.$festivalMeta['_laskins_carousel_exceprt_text_color'][0].'; ' : '').($festivalMeta['_laskins_carousel_exceprt_background_color'][0] ? 'background-color:'.$festivalMeta['_laskins_carousel_exceprt_background_color'][0].'; ' : '').($festivalMeta['_laskins_carousel_exceprt_position_left'][0] ? 'left:'.$festivalMeta['_laskins_carousel_exceprt_position_left'][0].'%; ' : '').($festivalMeta['_laskins_carousel_exceprt_position_top'][0] ? 'top:'.$festivalMeta['_laskins_carousel_exceprt_position_top'][0].'%; ' : '').'"' : ''; ?>>
										<?php if ($festivalMeta['_laskins_carousel_super_title'][0]) { ?>
											<h3<?php echo $festivalMeta['_laskins_carousel_super_title_size'][0] ? ' style="font-size:'.($festivalMeta['_laskins_carousel_super_title_size'][0]/10).'em"' : ''; ?>><?php echo $festivalMeta['_laskins_carousel_super_title'][0]; ?></h3>
										<?php } ?>
										<h2<?php echo $festivalMeta['_laskins_carousel_title_size'][0] ? ' style="font-size:'.($festivalMeta['_laskins_carousel_title_size'][0]/10).'em"' : ''; ?>><?php the_title(); ?></h2>
										<?php if (get_the_excerpt()) { ?>
											<p<?php echo $festivalMeta['_laskins_carousel_excerpt_size'][0] ? ' style="font-size:'.($festivalMeta['_laskins_carousel_excerpt_size'][0]/10).'em"' : ''; ?>><?php echo get_the_excerpt(); ?></p>
										<?php } ?>
									</div>
									<img class="bg" src="<?php echo $festivalImage; ?>" alt="<?php the_title(); ?>" />
									<img class="bg-mobile" src="<?php echo $festivalImageMobile; ?>" alt="<?php the_title(); ?>" />
								</header>
								<?php
								$festivalFilmsByTime = tribe_get_events(array(
									'eventDisplay' => 'custom',
									'start_date' =>  tribe_get_start_date(get_the_ID(), false, 'Y-m-d').' 00:01',
									'end_date' =>  tribe_get_end_date(get_the_ID(), false, 'Y-m-d').' 23:59',
									'tribe_events_cat' => 'screening',
									'posts_per_page' => -1 /*,
									'orderby' => 'title',
									'order' => 'ASC'*/
									// this is ordered by meta_value "_EventStartDate" apparently
									// see http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters for the orderby meta_value thing
									// and https://theeventscalendar.com/support/forums/topic/tribe_get_events-sort-order/ 
								));
								$festivalFilmsByTitle = tribe_get_events(array(
									'eventDisplay' => 'custom',
									'start_date' =>  tribe_get_start_date(get_the_ID(), false, 'Y-m-d').' 00:01',
									'end_date' =>  tribe_get_end_date(get_the_ID(), false, 'Y-m-d').' 23:59',
									'tribe_events_cat' => 'screening',
									'posts_per_page' => -1,
									'orderby' => 'title',
									'order' => 'ASC'
								));
								?>
								<div class="wrap">
									<div class="content-primary">
										<?php while ( have_posts() ) :  the_post(); ?>
										<div class="overview">
											<?php do_action( 'tribe_events_single_event_before_the_content' ); ?>
											<?php the_content(); ?>
											<?php do_action( 'tribe_events_single_event_after_the_content' ); ?>
										</div>
										<?php endwhile; ?>
										<?php if (count($festivalFilmsByTitle) > 0) { ?>
										<div class="screening-lists SCREENING_LISTS">
											<ul class="tabs TABS">
											<?php foreach (array($festivalFilmsByTime,$festivalFilmsByTitle) as $key => $tab) { 
												$tabClass = $tab == $festivalFilmsByTime ? 'TIME' : 'TITLE'; ?>
												<li class="FILMS_LIST_<?php echo $tabClass; echo $key == 0 ? ' active' : ''; ?>"><?php echo $tabClass == 'TIME' ? 'Screening Schedule' : 'Alphabetical List'; ?></li>
											<?php } ?>
											</ul>
											<?php foreach (array($festivalFilmsByTime,$festivalFilmsByTitle) as $k => $list) { 
												$listClass = $list == $festivalFilmsByTime ? 'time' : 'title'; ?>
												<ul class="films-list films-list-<?php echo $listClass; echo $k == 0 ? ' active' : ''; ?> FILMS_LIST">
													<?php global $post;
													foreach($list as $key => $item) {
													$post = $item;
													setup_postdata($post);
													$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'small');
													// print_r($item); 
													?>
													<li>
														<a href="<?php the_permalink(); ?>">
															<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
															<span class="item-content">
																
																<span class="item-head"><?php the_title(); ?></span>
																<span class="item-sched mobile-hide"><?php echo tribe_events_event_schedule_details($item->ID); ?></span>
																<span class="item-sched desktop-hide"><?php echo tribe_get_start_date($item->ID, true, 'M j @ g:i a'); ?></span>
																<span class="item-body"><?php echo string_limit_words(get_the_excerpt(), 30); ?></span>
																<span class="btn btn-orange">Film Details</span>
															</span>
														</a>
													</li>
													<?php } ?>
												</ul>
											<?php } ?>
										</div>
										<?php } ?>
									</div>
									<?php get_sidebar(); ?>
								</div>
								
								<?php /*
								if (count($festivalFilmsByTitle) > 0) { ?>
								<div class="festival-films thumb-index skins-grunge BG_PARALLAX">
									<div class="thumb-index-inner wrap">
										<h2>This year's films</h2>
										<ul>
										<?php global $post;
										foreach($festivalFilmsByTitle as $key => $item) {
											$post = $item;
											setup_postdata($post);
											$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'large-thumb');
											// print_r($item); 
											$colHide = '';
											if ($key > 5) {
												$colHide = 'hide-3col';
											} else if ($key > 3) {
												$colHide = 'hide-2col';
											}
											?>
											<li<?php echo $key > 3 ? ' class="'.$colHide.'"' : ''; ?>>
												<a href="<?php the_permalink(); ?>">
													<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
													<span class="item-content">
														<span class="item-head"><?php the_title(); ?></span>
														<span class="item-body"><?php echo string_limit_words(get_the_excerpt(), 30); ?></span>
														<span class="btn btn-orange">Film Details</span>
													</span>
												</a>
											</li>
											<?php } ?>
										</ul>
									</div>
								</div>
								<?php } */ ?>
							
							<?php } ?>
							
						</main>


				</div>

			</div>
<?php
get_footer();