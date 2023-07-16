$(document).ready(function() {
	// Make sure we always have an additional product select available
	$('#product-select').on('change', 'select', function(event) {
		if (!$(this).siblings('select').find('option:selected:disabled').length) {
			$(this).clone().insertAfter($(this));
		}
	});
});
