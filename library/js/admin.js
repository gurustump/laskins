/*
 * Admin Scripts File
 * Author: Matthew Stumphy
 *
 * Just any extra javascript to run in the admin area.
*/
var isEvent;

jQuery(document).ready(function($) {
	isEvent = $('#taxonomy-tribe_events_cat').length > 0;
	toggleMetaboxes($);
	$('#page_template').change(function() {
		toggleMetaboxes($);
	});
});

function toggleMetaboxes($) {
	var pageTemplate = $('#page_template').val();
	if (pageTemplate == 'page-home.php') {
		$('#_laskins_slider_metabox').show();
	} else {
		$('#_laskins_slider_metabox').hide();
	}
	if (pageTemplate == 'page-film-guide.php' || pageTemplate == 'page-venues.php' || pageTemplate == 'page-festival-schedule.php' ) {
		$('#_laskins_festival_page_custom_index_metabox').show();
	} else {
		$('#_laskins_festival_page_custom_index_metabox').hide();
	}
	if (pageTemplate == 'page-festival-archive.php' ) {
		$('#_laskins_festival_archive_metabox').show();
	} else {
		$('#_laskins_festival_archive_metabox').hide();
	}
	if (isEvent) {
	}
}
