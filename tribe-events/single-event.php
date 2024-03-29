<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();
$filmMetaArray = get_post_meta($event_id, '_laskins_events_film', true);
$filmMeta = is_array($filmMetaArray) ? $filmMetaArray[0] : $filmMetaArray;
?>

<div id="tribe-events-content" class="tribe-events-single vevent hentry<?php echo $filmMeta ? ' screening' : ''; ?>">
	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( __( '&laquo; All %s', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<!-- Notices -->
	<?php tribe_events_the_notices() ?>

	<?php the_title( '<h1 class="tribe-events-single-event-title summary entry-title">', '</h1>' ); ?>

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

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php printf( __( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<?php $is_virtual = tribe_event_in_category('virtual'); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php 
			if (tribe_event_featured_image( $event_id, 'carousel', false )) {
				echo tribe_event_featured_image( $event_id, 'carousel', false );
			} else if ($filmMeta) {
				echo tribe_event_featured_image( $filmMeta, 'carousel', false );
			} ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content entry-content description">
				<?php if ($filmMeta && is_active_sidebar('screening_event_header') && !tribe_is_past_event( $event_id )) { ?>
				<div class="buy-tickets-cta">
					<?php $screeningBtnTextMeta = get_post_meta($event_id, '_laskins_events_btn_text', true);
					$screeningBtnURLMeta = get_post_meta($event_id, '_laskins_events_btn_link', true);
					$screeningBtnTargetMeta = get_post_meta($event_id, '_laskins_events_btn_target', true);
					if ($screeningBtnTextMeta) { ?>
					<div class="widget">
						<a class="btn cta-btn btn-orange btn-large" href="<?php echo $screeningBtnURLMeta; ?>"<?php echo $screeningBtnTargetMeta ? ' target="_blank"' : ''; ?>>
							<?php echo $screeningBtnTextMeta; ?>
						</a>
					</div>
					<?php } else { ?>
					<?php dynamic_sidebar('screening_event_header'); ?>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if (get_the_content()) {
					the_content();
				} else if ($filmMeta) {
					$content_post = get_post($filmMeta);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					echo $content;
				} ?>
				<?php if ($filmMeta) { ?>
					<a class="btn-orange more-link" href="<?php echo get_permalink($filmMeta); ?>">Read More about this Film</a>
				<?php } ?>
			</div>
			<?php if (!$is_virtual) { ?>
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
			<?php } ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php printf( __( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
