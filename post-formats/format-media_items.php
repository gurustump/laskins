
				<?php
				/*
				 * This is the media_item format, named "films" on the front end.
				*/
				$itemMeta = get_post_meta(get_the_ID());
				?>
				<div class="wrap">
					<article id="post-<?php the_ID(); ?>" <?php post_class('cf content-primary'); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

					<header class="article-header entry-header">
						<?php $itemImageArray = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'med-wide'); ?>
						<div class="image-container">
							<img src="<?php echo $itemImageArray[0]; ?>" alt="<?php the_title(); ?>" />
						</div>

						<h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>
						
						<?php if ($itemMeta['_laskins_media_item_duration'][0] || $itemMeta['_laskins_media_item_age_restriction'][0] || $itemMeta['_laskins_media_item_country'][0]) { ?>
						<div class="media-item-info">
							<table>
								<?php if ($itemMeta['_laskins_media_item_duration'][0]) { ?>
								<tr>
									<td>Duration</td>
									<td><?php echo $itemMeta['_laskins_media_item_duration'][0]; ?> min.</td>
								<tr>
								<?php } ?>
								<?php if ($itemMeta['_laskins_media_item_age_restriction'][0]) { ?>
								<tr>
									<td>Age Restriction</td>
									<td><?php echo $itemMeta['_laskins_media_item_age_restriction'][0]; ?></td>
								<tr>
								<?php } ?>
								<?php if ($itemMeta['_laskins_media_item_country'][0]) { ?>
								<tr>
									<td>Country</td>
									<td><?php echo $itemMeta['_laskins_media_item_country'][0]; ?></td>
								<tr>
								<?php } ?>
								<?php if ($itemMeta['_laskins_media_item_imdb_url'][0]) { ?>
								<tr>
									<td>IMDb Page</td>
									<td><a href="<?php echo $itemMeta['_laskins_media_item_imdb_url'][0]; ?>" target="_blank"><?php echo $itemMeta['_laskins_media_item_imdb_url'][0]; ?></a></td>
								<tr>
								<?php } ?>
								<?php if ($itemMeta['_laskins_media_item_view_url'][0]) { ?>
								<tr>
									<td>Watch this film</td>
									<td><a href="<?php echo $itemMeta['_laskins_media_item_view_url'][0]; ?>" target="_blank"><?php echo $itemMeta['_laskins_media_item_view_url'][0]; ?></a></td>
								<tr>
								<?php } ?>
							</table>
						</div>
						<?php } ?>
						<?php if (get_the_content()) { ?>
						<div class="description">
						<?php the_content();  ?>
						</div>
						<?php } ?>
					</header> <?php // end article header ?>

					<section class="entry-content cf" itemprop="articleBody">
						<?php if ($itemMeta['_laskins_media_item_director'][0] || $itemMeta['_laskins_media_item_producer'][0] || $itemMeta['_laskins_media_item_writer'][0] || $itemMeta['_laskins_media_item_other_crew'][0] || $itemMeta['_laskins_media_item_cast'][0]) { ?>
						<div class="cast-crew">
							<table>
								<?php if ($itemMeta['_laskins_media_item_cast'][0]) { 
								$castMeta = get_post_meta(get_the_ID(), '_laskins_media_item_cast', true); ?>
								<tr class="subheading">
									<td colspan="2">Cast</td>
								</tr>
									<?php foreach($castMeta as $key => $castmember) { ?>
									<tr class="cast">
										<td><?php echo $castmember[character]; ?></td>
										<td><?php echo $castmember[name]; ?></td>
									</tr>
									<?php } ?>
								<?php } ?>
								<?php if ($itemMeta['_laskins_media_item_director'][0] || $itemMeta['_laskins_media_item_producer'][0] || $itemMeta['_laskins_media_item_writer'][0] || $itemMeta['_laskins_media_item_other_crew'][0]) { ?>
								<?php if ($itemMeta['_laskins_media_item_director'][0]) { ?>
									<tr class="subheading">
										<td colspan="2">Crew</td>
									</tr>
									<tr class="crew">
										<td>Director</td>
										<td><?php echo $itemMeta['_laskins_media_item_director'][0]; ?></td>
									</tr>
									<?php } ?>
									<?php if ($itemMeta['_laskins_media_item_producer'][0]) { ?>
									<tr class="crew">
										<td>Producer</td>
										<td><?php echo $itemMeta['_laskins_media_item_producer'][0]; ?></td>
									</tr>
									<?php } ?>
									<?php if ($itemMeta['_laskins_media_item_writer'][0]) { ?>
									<tr class="crew">
										<td>Writer</td>
										<td><?php echo $itemMeta['_laskins_media_item_writer'][0]; ?></td>
									</tr>
									<?php } ?>
									<?php if ($itemMeta['_laskins_media_item_other_crew'][0]) {
									$crewMeta = get_post_meta(get_the_ID(), '_laskins_media_item_other_crew', true); ?>
										<?php foreach($crewMeta as $crewarray) { ?>
											<?php foreach($crewarray[name] as $key => $crewmember) { ?>
											<tr class="crew">
												<?php if ($key == 0) { ?>
												<td><?php echo $crewarray[title]; ?></td>
												<?php } else { ?>
												<td></td>
												<?php } ?>
												<td><?php echo $crewmember; ?></td>
											</tr>
									<?php } } } ?>
								<?php } ?>
							</table>
						</div>
						<?php } ?>
					</section> <?php // end article section ?>

					<footer class="article-footer">

					  <?php printf( __( 'filed under', 'bonestheme' ).': %1$s', get_the_category_list(', ') ); ?>

					  <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

					</footer> <?php // end article footer ?>

					<?php //comments_template(); ?>

					</article> <?php // end article ?>
				  
				  
					<?php get_sidebar(); ?>
				</div>
