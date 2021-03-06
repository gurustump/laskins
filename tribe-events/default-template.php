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

$is_film_festival = tribe_event_in_category('film-festival') && is_single();
$is_virtual = tribe_event_in_category('virtual');
$is_venue = tribe_is_venue() && is_single();
$is_virtual_film_festival = $is_film_festival && $is_virtual;
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

			<div id="content"<?php echo $is_film_festival ? ' class="festival-event-page"':''; ?>>
				<div id="inner-content" class="<?php echo $is_film_festival ? '' : 'wrap '; ?>cf">
						<main id="main" class="cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							
							<?php // TEMPLATE FOR MOST EVENTS
							if (!$is_film_festival && !$is_venue) { ?>
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
							
							<?php // template for venues ?>
							<?php } else if ($is_venue) {
							
								$phone   = tribe_get_phone();
								$website = tribe_get_venue_website_link();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-primary cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<?php if (has_post_thumbnail()) { 
								$featuredThumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'carousel'); ?>
								<div class="featured-thumb-container">
									<img src="<?php echo $featuredThumb[0]; ?>" />
								</div>
								<?php } ?>
								<h2><?php echo tribe_get_venue(); ?></h2>
								<p>
								<?php echo tribe_get_full_address(); ?>
								<?php if ( tribe_show_google_map_link() ) : ?>
									<?php echo tribe_get_map_link_html(); ?>
								<?php endif; ?>
								</p>
								<?php if ( ! empty( $phone ) ): ?>
								<p>
									<span> <?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?> </span>
									<span class="tel"> <?php echo $phone ?> </span>
								</p>
								<?php endif ?>

								<?php if ( ! empty( $website ) ): ?>
								<p>
									<span class="title"><?php esc_html_e( 'Website:', 'the-events-calendar' ) ?></span>
									<span class="url"> <?php echo $website ?> </span>
								</p>
								<?php endif ?>
								<div class="item-map" style="max-width:500px">
									<?php echo tribe_get_embedded_map(get_the_ID(), 500); ?>
								</div>
								<div class="venue-content">
									<?php
									$thisVenuePost = get_post(get_the_ID());
									echo wpautop($thisVenuePost->post_content); 
									?>
								</div>
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
										<?php if (has_excerpt()) { ?>
											<p><?php echo get_the_excerpt(); ?></p>
										<?php } ?>
									</div>
									<?php
									$headingHide = $festivalMeta['_laskins_carousel_hide_heading'][0];
									$headingLeft = $festivalMeta['_laskins_carousel_hor_pos'][0] || $festivalMeta['_laskins_carousel_hor_pos'][0] === '0';
									$headingTop = $festivalMeta['_laskins_carousel_ver_pos'][0] || $festivalMeta['_laskins_carousel_ver_pos'][0] ==='0';
									$headingNeedsStyle = $festivalMeta['_laskins_carousel_exceprt_text_color'][0] || $festivalMeta['_laskins_carousel_exceprt_background_color'][0] || $headingLeft || $headingTop; 
									
									
									// setting horizontal position, and switching from left to right if it goes over 50
									$horPos = $headingLeft ? $festivalMeta['_laskins_carousel_hor_pos'][0] : 0;
									$horDirection = $horPos > 50 ? 'right' : 'left';
									$horPos = $horDirection == 'right' ? 100 - $horPos : $horPos;
									$horPolarity = $horDirection == 'left' ? '-' : '';
									
									// setting vertical position, and switching from top to bottom if it is over 50
									$verPos = $headingTop ? $festivalMeta['_laskins_carousel_ver_pos'][0] : 0;
									$verDirection = $verPos > 50 ? 'bottom' : 'top';
									$verPos = $verDirection == 'bottom' ? 100 - $verPos : $verPos;
									$verPolarity = $verDirection == 'top' ? '-' : '';
									
									$headingColor = $festivalMeta['_laskins_carousel_exceprt_text_color'][0] ? $festivalMeta['_laskins_carousel_exceprt_text_color'][0] : false;
									$headingBGColor = $festivalMeta['_laskins_carousel_exceprt_background_color'][0] ? $festivalMeta['_laskins_carousel_exceprt_background_color'][0] : false;
									?>
									<div class="heading-desktop" style="<?php echo !empty($headingHide) ? 'display:none;':''; ?><?php echo $horDirection; ?>:<?php echo $horPos; ?>%;<?php echo $verDirection; ?>:<?php echo $verPos; ?>%;transform:translate(<?php echo $horPolarity; ?><?php echo $horPos; ?>%, <?php echo $verPolarity; ?><?php echo $verPos; ?>%);<?php if ($headingWidth) { echo 'width:'.$headingWidth.'%;'; }?><?php if ($headingColor) { echo 'color:'.$headingColor.';'; } ?><?php if ($headingBGColor) { echo 'background-color:'.$headingBGColor.';'; } ?>">
										<?php if ($festivalMeta['_laskins_carousel_super_title'][0]) { ?>
											<h3<?php echo $festivalMeta['_laskins_carousel_super_title_size'][0] ? ' style="font-size:'.($festivalMeta['_laskins_carousel_super_title_size'][0]/10).'em"' : ''; ?>><?php echo $festivalMeta['_laskins_carousel_super_title'][0]; ?></h3>
										<?php } ?>
										<h2<?php echo $festivalMeta['_laskins_carousel_title_size'][0] ? ' style="font-size:'.($festivalMeta['_laskins_carousel_title_size'][0]/10).'em"' : ''; ?>><?php the_title(); ?></h2>
										<?php if (has_excerpt()) { ?>
											<p<?php echo $festivalMeta['_laskins_carousel_excerpt_size'][0] ? ' style="font-size:'.($festivalMeta['_laskins_carousel_excerpt_size'][0]/10).'em"' : ''; ?>><?php echo get_the_excerpt(); ?></p>
										<?php } ?>
									</div>
									<img class="bg" src="<?php echo $festivalImage; ?>" alt="<?php the_title(); ?>" />
									<img class="bg-mobile" src="<?php echo $festivalImageMobile; ?>" alt="<?php the_title(); ?>" />
								</header>
								<?php
								$festivalFilmsArray = array();
								$festivalFilmsArray['time'] = tribe_get_events(array(
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
								$festivalFilmsArray['title'] = tribe_get_events(array(
									'eventDisplay' => 'custom',
									'start_date' =>  tribe_get_start_date(get_the_ID(), false, 'Y-m-d').' 00:01',
									'end_date' =>  tribe_get_end_date(get_the_ID(), false, 'Y-m-d').' 23:59',
									'tribe_events_cat' => 'screening',
									'posts_per_page' => -1,
									'orderby' => 'title',
									'order' => 'ASC'
								));
								$festivalEvents = tribe_get_events(array(
									'eventDisplay' => 'custom',
									'start_date' =>  tribe_get_start_date(get_the_ID(), false, 'Y-m-d').' 00:01',
									'end_date' =>  tribe_get_end_date(get_the_ID(), false, 'Y-m-d').' 23:59',
									'tribe_events_cat' => 'sub-event',
									'posts_per_page' => -1,
								));
								// resort this to remove articles
								usort($festivalFilmsArray['title'], 'sort_by_title');
								?>
								<div class="wrap">
									<div class="content-primary">
										<?php while ( have_posts() ) :  the_post(); ?>
										<div class="overview">

											<div class="tribe-events-schedule updated published tribe-clearfix subhead">
												<?php if (is_active_sidebar('socialshare')) { ?>
													<?php dynamic_sidebar('socialshare'); ?>
												<?php } ?>
												<?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
												<?php if ( tribe_get_cost() ) : ?>
													<span class="tribe-events-divider">|</span>
													<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
												<?php endif; ?>
											</div>
											
											<?php do_action( 'tribe_events_single_event_before_the_content' ); ?>
											<?php the_content(); ?>
											<?php do_action( 'tribe_events_single_event_after_the_content' ); ?>

											<!-- Event meta -->
											<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
											<?php tribe_get_template_part( 'modules/meta' ); ?>
											<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
										</div>
										<?php endwhile; ?>
										<?php if (count($festivalFilmsArray['title']) > 0 || (count($festivalEvents) > 0)) { ?>
										<div class="screening-lists SWITCH_LISTS">
											<ul class="tabs TABS">
												<?php foreach ($festivalFilmsArray as $key => $tab) {
												if ($is_virtual && $key == 'time') {continue;} ?>
												<li class="FILMS_LIST_<?php echo strtoupper($key); echo ($key == 'time' || ($is_virtual && $key == 'title')) ? ' active' : ''; ?>"><?php echo $key == 'time' ? 'Screening Schedule' : ($is_virtual ? 'Screenings' : 'Alphabetical List'); ?></li>
												<?php } ?>
												<?php if (count($festivalEvents) > 0) { ?>
												<li class="EVENTS_LIST">Other Events</li>
												<?php } ?>
											</ul>
											<?php foreach ($festivalFilmsArray as $k => $list) {
											if ($is_virtual && $k == 'time') {continue;} ?>
											<ul class="films-list films-list-<?php echo $k; echo ($k == 'time' || ($is_virtual && $k == 'title')) ? ' active' : ''; ?> SWITCH_LIST">
												<?php foreach($list as $key => $item) {
												$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'small');
												$itemThumbSrc = $itemThumbArray[0];
												$filmMeta = get_post_meta($item->ID, '_laskins_events_film', true);
												$filmThumbArray =  wp_get_attachment_image_src( get_post_thumbnail_id($filmMeta), 'small');
												if (!$itemThumbSrc) {
													$itemThumbSrc = $filmThumbArray[0];
												}
												// print_r($item); 
												?>
												<li>
													<a href="<?php the_permalink($item->ID); ?>">
														<?php if ($itemThumbSrc) { ?>
														<img class="item-thumb" src="<?php echo $itemThumbSrc; ?>" />
														<?php } ?>
														<span class="item-content">
															<span class="item-head"><?php echo get_the_title($item->ID); ?></span>
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
											<?php if (count($festivalEvents) > 0) { ?>
											<ul class="events-list films-list-events SWITCH_LIST">
												<?php foreach($festivalEvents as $key => $item) { 
												$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'small');
												$itemThumbSrc = $itemThumbArray[0]; ?>
												<li>
													<a href="<?php the_permalink($item->ID); ?>">
														<?php if ($itemThumbSrc) { ?>
														<img class="item-thumb" src="<?php echo $itemThumbSrc; ?>" />
														<?php } ?>
														<span class="item-content">
															<span class="item-head"><?php echo get_the_title($item->ID); ?></span>
															<span class="item-sched mobile-hide"><?php echo tribe_events_event_schedule_details($item->ID); ?></span>
															<span class="item-sched desktop-hide"><?php echo tribe_get_start_date($item->ID, true, 'M j @ g:i a'); ?></span>
															<span class="item-body"><?php echo string_limit_words(get_the_excerpt(), 30); ?></span>
															<span class="btn btn-orange">Event Details</span>
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
