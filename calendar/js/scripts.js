jQuery(document).ready(function(){

	jQuery('#job-submit').click(function(){
		var stat = 1;
		jQuery('.job-data-required').each(function() {
			var val = jQuery(this).val();
			if(val == '') {
				jQuery(this).addClass('not-valid');
				stat = 0;
			}
			else {
				jQuery(this).removeClass('not-valid');
			}
		});
		
		if(stat == 1) {
			return true;
		}
		else {
			return false
		}
	
	});

	jQuery('.job-data-required').keyup(function(){
		var val = jQuery(this).val();
			if(val == '') {
			jQuery(this).addClass('not-valid');
		}
		else {
			jQuery(this).removeClass('not-valid');
		}
	});

	jQuery('#job_map').click(function(){
		var map_address = jQuery('#job-address').val();
		var map_suburb = jQuery('#job-suburb').val();
		var map_url = "https://maps.google.com/maps?q="+map_address+" "+map_suburb;
		jQuery(this).attr('href',map_url);
		return true;
	});

	jQuery('#print_job').click(function(){
		var url = jQuery(this).attr('href');
		popitup(url);
		return false;
	});

});

function popitup(url) {
	newwindow = window.open(url,'Job Detail','height=600,width=800');
	if (window.focus) {newwindow.focus()}
	return false;
}
