<?php
/*
 Template Name: Home Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content">

						<main id="main" class="cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php 
								$homeCarousel = get_post_meta(get_the_ID(), '_laskins_slider_slider',true);
								if (count($homeCarousel[0]) > 0 && $homeCarousel[0] != '') { ?>
								<div class="carousel CAROUSEL">
									<ul class="PANES">
										<?php foreach($homeCarousel as $key => $item) {
										
										unset($itemImage);
										unset($itemImageArray);
										$hasLinkedItem = $item[page_event_link] ? true : false;
										$itemTitle;
										$itemImageArray;
										$itemImageMobileArray;
										$linkedItemID;
										if ($hasLinkedItem) {
											$linkedItemID = $item[page_event_link][0];
											$itemTitle = get_the_title($linkedItemID);
											$itemImageArray = wp_get_attachment_image_src( get_post_thumbnail_id($linkedItemID), 'carousel');
											$itemImageMobileArray = wp_get_attachment_image_src( get_post_thumbnail_id($linkedItemID), 'carousel-mobile');
										}
										if ($item[background_image]) {
											$itemImageArray = wp_get_attachment_image_src( $item[background_image_id], 'carousel');
											$itemImageMobileArray = wp_get_attachment_image_src( $item[background_image_id], 'carousel-mobile');
										}
										$itemImage = $itemImageArray[0];
										$itemImageMobile = $itemImageMobileArray[0];
										
										$itemVidMP4 = $item[background_video_mp4];
										$itemVidWEBM = $item[background_video_webm];
										$itemVid = $itemVidMP4 || $itemVidWEBM ? true : false;
										
										// setting horizontal position, and switching from left to right if it goes over 50
										$horPos = $item[hor_pos] ? $item[hor_pos] : 0;
										$horDirection = $horPos > 50 ? 'right' : 'left';
										$horPos = $horDirection == 'right' ? 100 - $horPos : $horPos;
										$horPolarity = $horDirection == 'left' ? '-' : '';
										
										// setting vertical position, and switching from top to bottom if it is over 50
										$verPos = $item[ver_pos] ? $item[ver_pos] : 0;
										$verDirection = $verPos > 50 ? 'bottom' : 'top';
										$verPos = $verDirection == 'bottom' ? 100 - $verPos : $verPos;
										$verPolarity = $verDirection == 'top' ? '-' : '';
										
										$headingWidth = $item[width] ? $item[width] : false;
										$headingColor = $item[text_color] ? $item[text_color] : false;
										$headingBGColor = $item[bgcolor] ? $item[bgcolor] : false;
										
										$itemLink = $item[page_event_link] ? get_permalink($item[page_event_link][0]) : $item[link_url];
										
										if (!$itemImage) { continue; }
										?>
										<li id="carouselItem_<?php echo $key; ?>" class="carousel-item<?php if ($key==0) {echo ' active';} ?>"<?php /* echo $itemImage ? ' style="background-image:url('.$itemImage.');"' : ''; */ ?>>
											<?php /*<pre><?php print_r($linkedItemID); ?></pre>
											<pre><?php print_r($item); ?></pre>
											<pre><?php echo $hasLinkedItem; ?></pre> */ ?>
											<?php if (get_post_type($item->ID) != 'module') { ?>
											<a href="<?php echo $itemLink; ?>"<?php if ($item[link_external]) {echo ' target="_blank"'; } ?>>
											<?php } ?>
												<span class="carousel-item-heading-mobile">
													<?php if ($item[superheading]) { ?>
														<span class="h3"><?php echo $item[superheading]; ?></span>
													<?php } ?>
													<?php if ($item[heading]) { ?>
													<span class="h2"><?php echo $item[heading]; ?></span>
													<?php } ?>
													<?php if ($item[body_text]) { ?>
														<span class="excerpt"><?php echo $item[body_text]; ?></span>
													<?php } ?>
												</span>
												<span class="carousel-item-heading-desktop" style="<?php echo $horDirection; ?>:<?php echo $horPos; ?>%;<?php echo $verDirection; ?>:<?php echo $verPos; ?>%;transform:translate(<?php echo $horPolarity; ?><?php echo $horPos; ?>%, <?php echo $verPolarity; ?><?php echo $verPos; ?>%);<?php if ($headingWidth) { echo 'width:'.$headingWidth.'%;'; }?><?php if ($headingColor) { echo 'color:'.$headingColor.';'; } ?><?php if ($headingBGColor) { echo 'background-color:'.$headingBGColor.';'; } ?>">
													<?php if ($item[superheading]) { ?>
														<span class="h3"<?php echo $item[superheading_size] ? ' style="font-size:'.($item[superheading_size]/10).'em"' : ''; ?>><?php echo $item[superheading]; ?></span>
													<?php } ?>
													<?php if ($item[heading]) { ?>
													<span class="h2"<?php echo $item[heading_size] ? ' style="font-size:'.($item[heading_size]/10).'em"' : ''; ?>><?php echo $item[heading]; ?></span>
													<?php } ?>
													<?php if ($item[body_text]) { ?>
														<span class="excerpt"<?php echo $item[body_size] ? ' style="font-size:'.($item[body_size]/10).'em"' : ''; ?>><?php echo $item[body_text]; ?></span>
													<?php } ?>
												</span>
												<?php if ($itemVid) { ?>
												<video class="bg-video" autoplay loop>
													<?php if ($itemVidMP4) { ?>
													<source src="<?php echo $itemVidMP4; ?>" type="video/mp4">
													<?php } ?>
													<?php if ($itemVidWEBM) { ?>
													<source src="<?php echo $itemVidWEBM; ?>" type="video/webm">
													<?php } ?>
												</video>
												<?php } ?>
												<img class="bg-mobile" src="<?php echo $itemImageMobile; ?>" alt="<?php $item->post_title; ?>" />
												<img class="bg" src="<?php echo $itemImage; ?>" alt="<?php $item->post_title; ?>" />
											<?php if (get_post_type($item->ID) != 'module') { ?>
											</a>
											<?php } ?>
										</li>
										<?php } ?>
									</ul>
									<div class="carousel-nav CAROUSEL_NAV">
										<a class="prev PREV" href="#">Previous</a>
										<a class="next NEXT" href="#">Next</a>
									</div>
								</div>
								<?php } ?>
							

							<?php endwhile; endif; ?>
							
							<?php $homeBanners = get_posts(array('post_type' => 'module', 'numberposts' => -1, 'module_cat' => 'home-banner')); 
							if (count($homeBanners) > 0) { ?>
							<div class="home-banner">
								<ul>
									<?php global $post;
									foreach($homeBanners as $key => $banner) { 
										$post = $banner;
										setup_postdata($post);
									//print_r($banner); ?>
									<li>
										<?php the_content(); ?>
									</li>
									<?php } ?>
								</ul>
							</div>
							<?php } ?>
							
							<?php $homePartners = get_posts(array('post_type' => 'module', 'numberposts' => 1, 'module_cat' => 'home-partners')); 
							if (count($homePartners) > 0) { ?>
							<div class="home-partners skins-grunge">
								<?php 
								$partner_gallery = get_post_gallery($homePartners[0]->ID, false);
								$partner_gallery_ids = explode(',',$partner_gallery['ids']);
								//print_r($partner_gallery);
								//print_r($partner_gallery_ids);
								?>
								<div class="scroll-carousel SCROLL_CAROUSEL">
									<ul>
										<?php foreach($partner_gallery['src'] as $key => $src) {
										$alt = get_post_meta($partner_gallery_ids[$key], '_wp_attachment_image_alt', true);
										$link = get_post_meta($partner_gallery_ids[$key], '_gallery_link_url', true);
										$target = get_post_meta($partner_gallery_ids[$key], '_gallery_link_target', true);
										$cssclass = get_post_meta($partner_gallery_ids[$key], '_gallery_link_additional_css_classes', true); ?>
										<li>
											<?php echo $link ? '<a '.($cssclass ? 'class="'.$cssclass.'" ' : '').'href="'.$link.'" target="'.$target.'">' : ''; ?>
											<img src="<?php echo $src; ?>" alt="<?php echo get_post_meta($partner_gallery_ids[$key], '_wp_attachment_image_alt', true); ?>" />
											<?php echo $link ? '</a>' : ''; ?>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
							<?php } ?>
							
							<?php $homeLatest = get_posts(array('post_type' => array('post','page','module','tribe_events','media_items'), 'numberposts' => 8, 'category_name' => 'latest')); 
							if (count($homeLatest) > 0) { ?>
							<div class="home-latest thumb-index skins-grunge BG_PARALLAX">
								<div class="thumb-index-inner wrap">
									<h2>Latest</h2>
									<ul>
									<?php global $post;
									foreach($homeLatest as $key => $item) {
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
													<span class="item-body"><?php echo string_limit_words(get_the_excerpt(), 27); ?></span>
													<span class="btn btn-orange">Read More</span>
												</span>
											</a>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
							<?php } ?>
							
							<?php $homeGalleries = get_posts(array('post_type' => array('post','page','module','tribe_events','media_items'), 'numberposts' => 4, 'post_format' => 'post-format-gallery', 'category_name' => 'home-gallery')); 
							if (count($homeGalleries) > 0) { ?>
							<div class="home-galleries thumb-index white-grunge BG_PARALLAX">
								<div class="thumb-index-inner wrap">
									<h2>Galleries</h2>
									<ul>
									<?php global $post;
									foreach($homeGalleries as $key => $item) {
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
													<span class="item-body"><?php echo string_limit_words(get_the_excerpt(), 27); ?></span>
													<span class="btn btn-orange">View Gallery</span>
												</span>
											</a>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
							<?php } ?>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">


								<section class="entry-content cf" itemprop="articleBody">
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
									?>
								</section>


							</article>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</main>

				</div>

			</div>


<?php get_footer(); ?>
