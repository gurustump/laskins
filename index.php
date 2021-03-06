<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="content-primary cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
						
							<?php /* $press_release_cat_ID = get_category_by_slug('press')->cat_ID;
							$query = new WP_Query( 'cat=-32'.$press_release_cat_ID ); ?>
							<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();*/ ?>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php // if (get_post_type() != 'tribe_events' || !in_category('latest')) { ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

								<header class="article-header">
									<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									<p class="byline entry-meta vcard">
                                                                        <?php printf( __( 'Posted', 'bonestheme' ).' %1$s %2$s',
                       								/* the time the post was published */
                       								'<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
                       								/* the author of the post */
                       								'<!--<span class="by">'.__( 'by', 'bonestheme').'</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>-->' 
                    							); ?>
									</p>

								</header>

								<section class="entry-content cf">
									<?php the_post_thumbnail('medium'); ?>
									<?php the_excerpt(); ?>
								</section>

								<?php /*<footer class="article-footer cf">
									<p class="footer-comment-count">
										<?php comments_number( __( '<span>No</span> Comments', 'bonestheme' ), __( '<span>One</span> Comment', 'bonestheme' ), __( '<span>%</span> Comments', 'bonestheme' ) );?>
									</p>


                 	<?php printf( '<p class="footer-category">' . __('filed under', 'bonestheme' ) . ': %1$s</p>' , get_the_category_list(', ') ); ?>

                  <?php the_tags( '<p class="footer-tags tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>


								</footer> */ ?>

							</article>

							<?php // } ?>
							<?php endwhile; ?>

									<?php bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Nothing here for the moment', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( "We don't have anything to show here right now. Check back later. We're sure to fill it up.", 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<?php /*<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p> */ ?>
										</footer>
									</article>
							<?php endif; ?>


						</main>

					<?php get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
