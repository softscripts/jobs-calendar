<?php function manage_jobs() {
global $wpdb;

$link = get_bloginfo('url')."/wp-admin/admin.php?page=manage_jobs";
$table_name = WP_jobs_TABLE; 
$task = $_REQUEST['action'];
$id = $_REQUEST['id'];

/* Delete single record */
if($task == 'trash') {
	$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $id));
	echo '<script>location.href="'.$link.'"</script>';
}

/* Load values in edit mode */
if($task == 'edit') {
	$job = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
	$job_date = $job->date;
	$job_crew_id = $job->crew_id;
	$job_service_id = $job->service;
	$job_number = $job->job_number;
	$job_customer = $job->customer;
	$job_address = $job->address;
	$job_suburb = $job->suburb;
	$job_melways_ref = $job->melways_ref;	
	$job_equipment = $job->equipment;
	$job_start_time = $job->start_time;
	$job_end_time = $job->end_time;
	$job_details = $job->details;
}

if(isset($_POST['submit'])) {
	$name = $_POST['crew-name'];
	$order = $_POST['crew-order'];
	$description = $_POST['crew-description'];
	
	if($task == 'edit' && !empty($id)) {
		$wpdb->query("UPDATE `$table_name` SET `name`='$name', `order`=$order, `description`='$description' WHERE id=$id");
		echo '<script>location.href="'.$link.'"</script>';		
	}
	else {

	$wpdb->query( $wpdb->prepare("INSERT INTO `$table_name`(`name`, `order`, `description`)	VALUES ( %s, %d, %s )", $name, $order, $description ) );
		$wpdb->show_errors();
		echo '<script>location.href="'.$link.'"</script>';
	}

}

?>
<script>
function ConfrmDelete()
{
if(confirm("Are you sure,you want to delete.")){
return true;
}
else{
return false;
}
}
</script>

<style>
.manage_listing {
	float: left;
	width: 55%;
	margin-right: 5%;
	-webkit-transition: all 0.5s ease-in-out 0s;
	-moz-transition: all 0.5s ease-in-out 0s;
	-ms-transition: all 0.5s ease-in-out 0s;
	-o-transition: all 0.5s ease-in-out 0s;
	transition: all 0.5s ease-in-out 0s;
}

.manage_listing.full {
	width: 95%;
}

.add-edit-form {
	float: left;
	width: 40%;
}

.add-edit-form input.not-valid, .add-edit-form textarea.not-valid, .add-edit-form select.not-valid {
	-webkit-box-shadow:0px 0px 6px #d73333;
	-moz-box-shadow:0px 0px 6px #d73333;
	-ms-box-shadow:0px 0px 6px #d73333;
	-o-box-shadow:0px 0px 6px #d73333;
	box-shadow:0px 0px 6px #d73333;
}


</style>


<script>
jQuery(document).ready(function(){


jQuery('#job-crew-submit').click(function(){
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


});

</script>



<div class="wrap nosubsub">

﻿<div class="add_new"><div id="icon-plugins" class="icon32"><br></div><h2>JOBS CALENDAR</h2></div>
<h3>Calendar Shortcode: [job-calendar] [/job-calendar]</h3>

﻿<div class="add_new"><div id="icon-edit" class="icon32 icon32-posts-post"></div><h2>Manage Jobs</h2></div>

<div class="manage_listing<?php if(!$task) { echo ' full'; } ?>">
<table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
	<tr>
	<th class="manage-column column-ID desc" id="ID" scope="col" width="50"><span style="margin:5px; display:block">ID</span></th>
	<th class="manage-column column-title desc" id="title" scope="col"><span>Job Number</span></th>
	<th class="manage-column column-title sortable desc" id="title" scope="col"><span>Customer</span></th>
	<th class="manage-column column-title sortable desc" id="title" scope="col"><span>Service</span></th>
	<th class="manage-column column-title sortable desc" id="title" scope="col"><span>Crew</span></th>
	<th class="manage-column column-title desc" id="title" scope="col"><span>Date</span></th>
	</tr>
	</thead>
	<tfoot>
	<tr>
	<th class="manage-column column-ID desc" id="ID" scope="col" width="50"><span style="margin:5px; display:block">ID</span></th>
	<th class="manage-column column-title desc" scope="col"><span>Job Number</span></th>
	<th class="manage-column column-title desc" id="title" scope="col"><span>Customer</span></th>
	<th class="manage-column column-title desc" id="title" scope="col"><span>Service</span></th>
	<th class="manage-column column-title desc" id="title" scope="col"><span>Crew</span></th>
	<th class="manage-column column-title desc" id="title" scope="col"><span>Date</span></th>
	</tr>
	</tfoot>
	<tbody id="the-list">

<?php
	$jobs = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY 'order' ASC" );
	if(count($jobs) > 0) {
	$i = 0;
	foreach($jobs as $job) {
	$i++;
	 ?>

	<tr valign="top" class="post-<?php echo $job->id; if($i%2==0) { ?> alternate<?php } ?>" id="post-<?php echo $job->id; ?>">
	
	<td class="sortable" scope="row"><span style="margin:5px; display:block"><?php echo $i; ?></span></td>
	<td class="post-title sortable page-title column-title"><strong><a title="Edit “<?php $job->job_number; ?>”" href="<?php echo $link; ?>&action=edit&id=<?php echo $job->id; ?>" class="row-title">Job Sheet # <?php echo $job->job_number; ?></a></strong>
<div class="row-actions"><span class="edit"><a title="View this item" href="<?php echo $link; ?>&action=edit&id=<?php echo $job->id; ?>">View</a> | </span><span class="trash"><a href="<?php echo $link; ?>&action=trash&id=<?php echo $job->id; ?>" class="submitdelete" onclick="return ConfrmDelete();">Delete</a></span></div>
</td>			
<td class="post-title sortable page-title column-title"><?php echo $job->customer; ?></td>
<td class="post-title sortable page-title column-title"><?php echo getService($job->service); ?></td>
<td class="post-title sortable page-title column-title"><?php echo getCrew($job->crew_id); ?></td>
<td class="post-title sortable page-title column-title"><?php echo date('M j, Y', $job->date); ?></td>
</tr>
<?php } 
}
else { ?>
<tr valign="top">
<td colspan="2" align="center" height="20"><strong>No Jobs uploaded.</strong></td>
</tr>
<?php }
 ?>

		</tbody>
</table>
</div>
<?php if($task == 'edit') { ?>
<div class="add-edit-form">
	<div class="form-wrap">
	<h3><?php if($task == 'edit') { echo 'Update'; } else { echo 'Add New'; } ?></h3>
	<form name="job-form" method="post" action=""class="validate">
	<div class="form-field form-required">
		<label for="job_number">Job Number</label>
		<input name="job_number" id="job_number" class="job-data-required" type="text" value="<?php echo $job_number; ?>" size="40">
	</div>
	<div class="form-field form-required">
		<label for="job_customer">Job Customer</label>
		<input name="job_customer" id="job_customer" class="job-data-required" type="text" value="<?php echo $job_customer; ?>" size="40">
	</div>
	<div class="form-field form-required">
		<label for="job_date">Job Date</label>
		<input name="job_date" id="job_date" class="job-data-required" type="text" value="<?php echo date('M j, Y', $job_date); ?>" size="40">
	</div>
	<div class="form-field form-required">
		<label for="job_crew">Job Crew</label>
		<select name="job_crew" id="job_crew" class="job-data-required">
		<?php $crews = getCrews(); 
			if(count($crews)>0) {
			foreach($crews as $crew) { ?>
			<option value="<?php echo $crew->id; ?>"<?php if($crew->id == $job_crew_id) { echo ' selected="selected"'; } ?>><?php echo $crew->name; ?></option> 
		<?php } } ?>
		</select>
	</div>
	<div class="form-field form-required">
	<label for="job_service">Job Service</label>
	<select name="job_service" id="job_service" class="job-data-required">
	<?php $services = getJobServices(); 
		if(count($services)>0) {
		foreach($services as $service) { ?>
		<option value="<?php echo $service->id; ?>"<?php if($service->id == $job_service_id) { echo ' selected="selected"'; } ?>><?php echo $service->name; ?></option> 
	<?php } } ?>
	</select>
	</div>
	<div class="form-field form-required">
		<label for="job_address">Address</label>
		<input name="job_address" id="job_address" class="job-data-required" type="text" value="<?php echo $job_address; ?>" size="40">
	</div>

	<div class="form-field form-required">
		<label for="job_suburb">Suburb</label>
		<input name="job_suburb" id="job_suburb" class="job-data-required" type="text" value="<?php echo $job_suburb; ?>" size="40">
	</div>

	<div class="form-field form-required">
		<label for="job_melways_ref">Melway Ref</label>
		<input name="job_melways_ref" id="job_melways_ref" class="job-data-required" type="text" value="<?php echo $job_melways_ref; ?>" size="40">
	</div>

	<div class="form-field">
		<label for="job_equipment">Equipment</label>
		<textarea name="job_equipment" id="job_equipment" rows="5" cols="40"><?php echo $job_equipment; ?></textarea>
	</div>

	<div class="form-field form-required">
		<label for="job_start_time">Start Time</label>
		<input name="job_start_time" id="job_start_time" class="job-data-required" type="text" value="<?php echo $job_start_time; ?>" size="40">
	</div>

	<div class="form-field form-required">
		<label for="job_end_time">End Time</label>
		<input name="job_end_time" id="job_end_time" class="job-data-required" type="text" value="<?php echo $job_end_time; ?>" size="40">
	</div>

	<div class="form-field">
		<label for="job_details">Details</label>
		<textarea name="job_details" id="job_details" rows="5" cols="40"><?php echo $job_details; ?></textarea>
	</div>
	<p class="submit"><a href="<?php echo $link; ?>" class="button button-primary">Back</a></p>

	</form>
	</div>
<?php } ?>
</div>
<?php } ?>
