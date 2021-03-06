<?php
/*
 Template Name: Program Page
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
										$now = new DateTime();
										$nowFormatted = $now->format( 'Y-m-d H:i');
										$upcomingEvents = tribe_get_events(array('numberposts' => -1, 'tribe_events_cat' => $post->post_name, 'start_date' => $nowFormatted)); 
										$pastEvents = tribe_get_events(array('numberposts' => -1, 'tribe_events_cat' => $post->post_name, 'end_date' => $nowFormatted)); 
										/* if (count($upcomingEvents) > 0) { ?>
											<pre>
											<?php print_r($upcomingEvents); ?>
											</pre>
										
										<?php }
										if (count($pastEvents) > 0) { ?>
											<pre style="background:orange">
											<?php print_r($pastEvents); ?>
											</pre>
										
										<?php } */
									?>
									</div>
									
									<?php if (count($upcomingEvents) > 0 || count($pastEvents) > 0) { ?>
									<div class="events-lists SWITCH_LISTS">
										<ul class="tabs TABS">
										<?php foreach (array($upcomingEvents,$pastEvents) as $key => $tab) { 
											$tabClass = $tab == $upcomingEvents ? 'UPCOMING' : 'PAST'; ?>
											<li class="SWITCH_LIST_<?php echo $tabClass; echo $key == 0 ? ' active' : ''; ?>"><?php echo $tabClass == 'UPCOMING' ? 'Upcoming' : 'Past'; ?></li>
										<?php } ?>
										</ul>
										<?php foreach (array($upcomingEvents,$pastEvents) as $k => $list) { 
											$listClass = $list == $upcomingEvents ? 'upcoming' : 'past'; ?>
											<ul class="events-list events-list-<?php echo $listClass; echo $k == 0 ? ' active' : ''; ?> SWITCH_LIST">
												<?php global $post;
												foreach($list as $key => $item) {
												$post = $item;
												setup_postdata($post);
												$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'small');
												// print_r($item); 
												?>
												<li>
													<a href="<?php the_permalink(); ?>">
														<?php if ($itemThumbArray) { ?>
														<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
														<?php } ?>
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
