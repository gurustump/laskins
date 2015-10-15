/*
 * Admin Scripts File
 * Author: Matthew Stumphy
 *
 * Just any extra javascript to run in the admin area.
*/


jQuery(document).ready(function($) {
	toggleMetaboxes($);
	$('#page_template').change(function() {
		toggleMetaboxes($);
	});
});

function toggleMetaboxes($) {
	var pageTemplate = $('#page_template').val()
	if (pageTemplate == 'page-film-guide.php' || pageTemplate == 'page-venues.php' || pageTemplate == 'page-festival-schedule.php' ) {
		$('#_laskins_festival_page_custom_index_metabox').show();
	} else {
		$('#_laskins_festival_page_custom_index_metabox').hide();
	}
}
