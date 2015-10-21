<?php
/*
 Template Name: Festival Schedule Page
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
									<div class="overview">
									<?php
										// the content (pretty self explanatory huh)
										the_content();

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
										/*
										echo '<pre>';
										print_r($festivalYear);
										echo '</pre>';
										*/
										$currentFestival = tribe_get_events(array(
											'tribe_events_cat' => 'film-festival',
											'start_date' =>  $festivalYear.'-01-01 00:01',
											'end_date' =>  $festivalYear.'-12-31 23:59',
											'posts_per_page' => 1
											
										));
										
										$festivalEvents = tribe_get_events(array(
											'eventDisplay' => 'custom',
											'start_date' =>  tribe_get_start_date($currentFestival[0]->ID, false, 'Y-m-d').' 00:01',
											'end_date' =>  tribe_get_end_date($currentFestival[0]->ID, false, 'Y-m-d').' 23:59',    
											'tax_query' => array(array(
												'taxonomy' => 'tribe_events_cat',
												'field' => 'slug',
												'terms' => 'film-festival',
												'operator' => 'NOT IN'
											)),
											'posts_per_page' => -1
										));
										// resort this to remove articles
										if (count($festivalEvents) > 0) { ?>
										<div class="films-list row-index">
											<div class="row-index-inner wrap">
												<?php global $post;
												$currentDate = '';
												$currentSubsection = '';
												foreach($festivalEvents as $key => $item) {
													$post = $item;
													setup_postdata($post);
													$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'medium');
													$itemThumbSrc = $itemThumbArray[0];
													$filmMeta = get_post_meta($item->ID, '_laskins_events_film', true);
													$filmThumbArray =  wp_get_attachment_image_src( get_post_thumbnail_id($filmMeta), 'medium');
													if (!$itemThumbSrc) {
														$itemThumbSrc = $filmThumbArray[0];
													}
													$itemExcerpt = '';
													if (get_the_excerpt()) {
														$itemExcerpt = get_the_excerpt();
													} else if (get_post_field('post_excerpt', $filmMeta)) {
														$itemExcerpt = string_limit_words(get_post_field('post_excerpt', $filmMeta), 60);
													} else {
														$filmPost = get_post($filmMeta);
														$itemExcerpt = string_limit_words($filmPost->post_content, 60);
													}
													$is_screening = false;
													$thisSubsection = '';
													$eventCats = get_the_terms($post->ID, 'tribe_events_cat');
													$screeningCats = get_the_terms($post->ID, 'screenings_cat');
													/*echo '<pre>';
													print_r($eventCats);
													echo '</pre>';*/
													if ($eventCats) {
														foreach($eventCats as $cat) {
															if ($cat->slug == 'screening') {
																$is_screening = true;
																$thisSubsection = $screeningCats[0]->name;
																break;
															}
														}
													}
													$thisDate = tribe_get_start_date(get_the_ID(), false, 'l, F j');
													?>
													<?php if ($thisDate != $currentDate) {
														echo $currentDate == '' ? '' : '</ul>'; ?>
														<h2 class="index-section-head"><?php echo $thisDate; ?></h2>
														<?php echo ($currentDate == '' && $currentSubsection == '') ? '' : '<ul>';
														$currentDate = $thisDate;
													} ?>
													<?php if ($thisSubsection && $thisSubsection != $currentSubsection) { 
														echo $currentSubsection == '' && $currentDate == '' ? '' : '</ul>'; ?>
														<h3 class="index-section-subhead"><?php echo $thisSubsection; ?></h3>
														<?php echo $currentSubsection == '' && $currentDate == '' ? '' : '<ul>';
														$currentSubsection = $thisSubsection;
													} ?>
													<?php echo $key == 0 ? '<ul>' : '' ?>
														<li<?php echo $thisSubsection ? ' class="subsection-list-item"' : ''; ?>>
															<a class="img-link" href="<?php the_permalink(); ?>">
																<img class="item-thumb" src="<?php echo $itemThumbSrc; ?>" />
																<?php if ($is_screening) { ?>
																<span class="item-category">Screening</span>
																<?php } ?>
															</a>
															<span class="item-content">
																<a href="<?php the_permalink(); ?>" class="item-head"><?php the_title(); ?></a>
																<span class="tribe-events-schedule subhead">
																	<?php echo tribe_events_event_schedule_details( $item->ID, '<span>', '</span>' ); ?>
																	<?php /* if ( tribe_get_cost() ) : ?>
																		<span class="tribe-events-divider">|</span>
																		<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
																	<?php endif; */ ?>
																</span>
																<span class="item-venue">
																	<a class="item-venue-title" href="<?php echo tribe_get_venue_link($item->ID, false); ?>"><?php echo tribe_get_venue($item->ID); ?></a>
																	<?php echo tribe_get_full_address($item->ID); ?>
																	<?php if ( tribe_show_google_map_link($item->ID) && tribe_get_venue_id($item->ID)) : ?>
																		<?php echo tribe_get_map_link_html($item->ID); ?>
																	<?php endif; ?>
																</span>
																<span class="item-body"><?php echo $itemExcerpt; ?></span>
																<a href="<?php the_permalink(); ?>" class="btn btn-orange">See Details</a>
															</span>
														</li>
													<?php echo $key == count($festivalEvents) - 1 ? '</ul>' : '' ?>
												<?php } ?>
											</div>
										</div>
										
										<?php } ?>
									
									</div>
									
										
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
