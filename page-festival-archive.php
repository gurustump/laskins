<?php
/*
 Template Name: Festival Archive
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="content-primary cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title"><?php the_title(); ?></h1>


								</header>

								<section class="entry-content cf" itemprop="articleBody">
									<?php
										the_content();

										$festivalType = get_post_meta(get_the_ID(), '_laskins_festival_archive_type', true);
										$festivals = tribe_get_events(array(
											'eventDisplay' => 'past',
											'tribe_events_cat' => $festivalType,
											'posts_per_page' => -1
										));
										/*
										echo '<pre>';
										print_r($festivalType);
										echo '</pre>';
										echo '<pre>';
										print_r($festivals);
										echo '</pre>';
										*/
										if (count($festivals) > 0) { ?>
										<div class="row-index">
											<div class="row-index-inner wrap">
												<ul>
												<?php global $post; 
												foreach($festivals as $key => $item) {
													$post = $item;
													setup_postdata($post);
													$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'medium');
													$itemThumbSrc = $itemThumbArray[0]; ?>
													<li>
														<a class="img-link" href="<?php the_permalink(); ?>">
															<img class="item-thumb" src="<?php echo $itemThumbSrc; ?>" />
														</a>
														<span class="item-content">
															<a href="<?php the_permalink(); ?>" class="item-head"><?php the_title(); ?></a>
															<span class="tribe-events-schedule subhead">
																<?php echo tribe_events_event_schedule_details( $item->ID, '<span>', '</span>' ); ?>
															</span>
															<span class="item-venue">
																<a class="item-venue-title" href="<?php echo tribe_get_venue_link($item->ID, false); ?>"><?php echo tribe_get_venue($item->ID); ?></a>
																<?php echo tribe_get_full_address($item->ID); ?>
																<?php if ( tribe_show_google_map_link($item->ID) && tribe_get_venue_id($item->ID)) : ?>
																	<?php echo tribe_get_map_link_html($item->ID); ?>
																<?php endif; ?>
															</span>
															<span class="item-body"><?php the_excerpt(); ?></span>
															<a href="<?php the_permalink(); ?>" class="btn btn-orange">See Details</a>
														</span>
													</li>
												<?php } ?>
												</ul>
											</div>
										</div>
										<?php } ?>
										
									
								</section>


								<footer class="article-footer">

								</footer>


							</article>

							<?php endwhile; endif; ?>

						</main>

						<?php get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
