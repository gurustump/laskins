<?php
/*
 Template Name: Film Guide Page
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
										$guideYear = get_post_meta(get_the_ID(), '_laskins_festival_page_year', true);
										$films = get_posts(array('post_type' => 'media_items', 'media_item_cat' => $guideYear, 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC')); 
										if (count($films) > 0) { ?>
										<div class="film-list thumb-index">
											<div class="thumb-index-inner wrap">
											<?php global $post;
											$currentLetter = '';
											foreach($films as $key => $item) {
												$post = $item;
												setup_postdata($post);
												$itemThumbArray = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'large-thumb');
												$firstLetter = substr(get_the_title(), 0, 1);
												// print_r($item); 
												?>
												<?php echo $key == 0 ? '<ul>' : '' ?>
												<?php if (!is_numeric($firstLetter) && $firstLetter != $currentLetter) { ?>
													</ul>
													<ul>
													<?php if (!is_numeric($firstLetter)) { ?>
														<h2><?php echo $firstLetter; ?></h2>
													<?php }
													$currentLetter = $firstLetter;
												} ?>
													<li>
														<a href="<?php the_permalink(); ?>">
															<img class="item-thumb" src="<?php echo $itemThumbArray[0]; ?>" />
															<span class="item-content">
																<span class="item-head"><?php the_title(); ?></span>
																<span class="item-body"><?php echo string_limit_words(get_the_excerpt(), 30); ?></span>
																<span class="btn btn-orange">See Details</span>
															</span>
														</a>
													</li>
												<?php echo $key == count($films) - 1 ? '</ul>' : '' ?>
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
