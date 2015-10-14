<?php
/*
 Template Name: Venues Page
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">
				<div id="inner-content" class="wrap cf">
						<main id="main" class="cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-primary cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

									<?php /*
									<p class="byline vcard">
										<?php printf( __( 'Posted', 'bonestheme').' <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> '.__( 'by',  'bonestheme').' <span class="author">%3$s</span>', get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
									</p>
									*/ ?>

								</header> <?php // end article header ?>
								
								<section class="entry-content cf" itemprop="articleBody">
									<?php
										// the content (pretty self explanatory huh)
										the_content();
										
										/*register_post_type('tribe_venue', array(
											'public'=>true,
											'exclude_from_search'=>false,
											'publicly_queryable'=>true
										));*/

										/*
										 * Link Pages is used in case you have posts that are set to break into
										 * multiple pages. You can remove this if you don't plan on doing that.
										 *
										 * Also, breaking content up into multiple pages is a horrible experience,
										 * so don't do it. While there are SOME edge cases where this is useful, it's
										 * mostly used for people to get more ad views. It's up to you but if you want
										 * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
										 *
										 * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
										 *
										*/
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bonestheme' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
										$festivalYear = get_post_meta(get_the_ID(), '_laskins_festival_page_year', true);
										$thisFestival = tribe_get_events(array(
											'eventDisplay' => 'custom',
											'start_date' =>  $festivalYear.'-01-01 00:01',
											'end_date' =>  $festivalYear.'-12-31 23:59',
											'tribe_events_cat' => 'film-festival',
											'posts_per_page' => 1
										));
										$festivalFilms = tribe_get_events(array(
											'eventDisplay' => 'custom',
											'start_date' =>  tribe_get_start_date($thisFestival[0]->ID, false, 'Y-m-d').' 00:01',
											'end_date' =>  tribe_get_end_date($thisFestival[0]->ID, false, 'Y-m-d').' 23:59',
											'tribe_events_cat' => 'screening',
											'posts_per_page' => -1
										));
										//print_r($festivalFilms);
										//echo '<br>';
										//print_r($thisFestival[0]->ID);
										$festivalEventsArray = array($thisFestival[0]->ID);
										foreach($festivalFilms as $film) {
											array_push($festivalEventsArray, $film->ID);
										}
										//print_r($festivalEventsArray);
										$venueIDs = array();
										foreach ($festivalEventsArray as $id) {
											if (!in_array(tribe_get_venue_id($id), $venueIDs)) {
												array_push($venueIDs, tribe_get_venue_id($id));
											}
										}
										
										//print_r($venueIDs);
										$venues = get_posts(array('post_type' => 'tribe_venue', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC')); 
										if (count($venueIDs) > 0) { ?>
										<div class="venue-list">
											<div class="venue-list-inner wrap">
												<ul>
												<?php global $post;
												$currentLetter = '';
												foreach($venueIDs as $key => $id) {
													$phone   = tribe_get_phone($id);
													$website = tribe_get_venue_website_link($id);
													// print_r($item); 
													if (tribe_is_venue($id)) {
													?>
													<li>
														<div class="item-content">
															<h2><a href="<?php echo tribe_get_venue_link($id, false); ?>"><?php echo tribe_get_venue($id); ?></a></h2>
															<p>
															<?php echo tribe_get_full_address($id); ?>
															<?php if ( tribe_show_google_map_link($id) ) : ?>
																<?php echo tribe_get_map_link_html($id); ?>
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
															
															<?php /*<div class="item-map" style="max-width:500px">
																<?php echo tribe_get_embedded_map($id, 500); ?>
															</div> */ ?>
														</div>
													</li>
													<?php } } ?>
												</ul>
											</div>
										</div>
										
										<?php } ?>
										
								</section> <?php // end article section ?>

								<footer class="article-footer cf">

								</footer>

								<?php /* comments_template(); */ ?>

							</article>

							<?php endwhile; endif; ?>

							<?php get_sidebar(); ?>
						</main>


				</div>

			</div>

<?php get_footer(); ?>
