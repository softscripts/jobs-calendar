<?php
ini_set("display_errors",1);
$wp_abspath 	= dirname(__FILE__);
$wp_abspath_1 = str_replace('wp-content/plugins/jobs-calendar/calendar', '', $wp_abspath);
$wp_abspath_1 = str_replace('wp-content\plugins\jobs-calendar\calendar', '', $wp_abspath_1);
require_once($wp_abspath_1 .'wp-config.php');

global $wpdb, $wp_version;
if ( is_user_logged_in() ) { // access only for users

/* Load available data */
$type 		= $_REQUEST['type'];
$date 		= $_REQUEST['date'];
$crew_id	= $_REQUEST['crew'];
$job_id 	= $_REQUEST['job'];
$status   = 0;

require_once ( 'util.php' );

$crew_table 		= WP_crews_TABLE;
$jobs_table 		= WP_jobs_TABLE;
$service_table 	= WP_services_TABLE;
$job_services 	= getJobServices();
$job_customers = getJobCustomers();

if($_POST['job-submit']) {

	$job_id = $_POST['job_id'];
	$crew_id = $_POST['crew_id'];
	$date = $_POST['date'];
	$service = $_POST['service'];
	$job_number = $_POST['job_number'];
	$customer = $_POST['customer'];
	$address = $_POST['address'];
	$suburb = $_POST['suburb'];
	$melways_ref = $_POST['melways_ref'];
	$equipment = $_POST['equipment'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$details = $_POST['details'];

	$data = array();
	$data[] = "`crew_id`='".$crew_id."'";
	$data[] = "`date`='".$date."'";
	$data[] = "`service`='".$service."'";
	$data[] = "`job_number`='".$job_number."'";
	$data[] = "`customer`='".$customer."'";
	$data[] = "`address`='".$address."'";
	$data[] = "`suburb`='".$suburb."'";
	$data[] = "`melways_ref`='".$melways_ref."'";
	$data[] = "`equipment`='".$equipment."'";
	$data[] = "`start_time`='".$start_time."'";
	$data[] = "`end_time`='".$end_time."'";
	$data[] = "`details`='".$details."'";

	if(!empty($job_id)) {
		$wpdb->query("UPDATE `$jobs_table` SET ".implode(', ', $data)." WHERE id=$job_id");
		//$wpdb->show_errors();
		$status = 1;
	}
	else {
		$wpdb->query( $wpdb->prepare("INSERT INTO `$jobs_table`(`crew_id`, `date`, `service`, `job_number`, `customer`, `address`, `suburb`, `melways_ref`, `equipment`, `start_time`, `end_time`, `details`)	VALUES ( %d, %s, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s )", $crew_id, $date, $service, $job_number, $customer, $address, $suburb, $melways_ref, $equipment, $start_time, $end_time, $details ) );
		//$wpdb->show_errors();
		$status = 1;
	}


}

if($job_id) {
	$job = $wpdb->get_row( "SELECT * FROM $jobs_table WHERE id=$job_id ORDER BY 'order' ASC" );
}

?>
<html>
<head>
<link rel='stylesheet' id='jc_css-css'  href='css/style.css' type='text/css' media='all' />
<script type='text/javascript' src='js/jquery.js?ver=1.8.3'></script>
<script type='text/javascript' src='js/scripts.js'></script>
<?php if($status == 1) { ?>
<script>parent.tb_remove();
 parent.location.reload(1)</script>
<?php } ?>
</head>
<body class="job-upload-body">


<?php if($type == 'form') { //Jobs upload/edit form ?>
<div class="job-upload-form">
	<form name="job-upload" method="POST" action="">
		<?php if($job_id) { ?>
		<div class="fieldSet">
			<a href="<?php echo JC_PLUGIN_URL.'/calendar/print.php?job_id='.$job_id; ?>" id="print_job" target="_blank" class="button">Print</a>
		</div>
		<?php } ?>
		<div class="fieldSet">
			<label for="service">Service</label>
			<select name="service" class="job-data-required" id="service">
				<?php if(count($job_services)>0) {
					foreach($job_services as $service) {  ?>
				<option value="<?php echo $service->id; ?>"<?php if($service->id==$job->service) { echo ' selected="selected"'; } ?>><?php echo $service->name; ?></option>
				<?php } 
						} ?>
			</select>
		</div>
		<div class="fieldSet">
			<label for="job_number">Job Number</label>
			<input type="text" name="job_number" class="job-data-required" id="job_number" value="<?php echo $job->job_number; ?>" />
		</div>
		<div class="fieldSet">
			<label for="customer">Customer</label>
                        <select name="customer" class="job-data-required">
				<option value="">--Please Select--</option>
                                <?php if(count($job_customers)>0) {
					foreach($job_customers as $customers) {  ?>
				<option value="<?php echo $customers->id; ?>"<?php if($customers->id==$job->customer) { echo ' selected="selected"'; } ?>><?php echo $customers->name; ?></option>
				<?php } 
				} ?>
                        </select>
			
		</div>
		<div class="fieldSet margin">
			<label for="job-address">Address <a href="https://maps.google.com/maps?q=<?php echo $job->address; ?> <?php echo $job->suburb; ?>" id="job_map" target="_blank" class="button">Map</a></label>
			<input type="text" name="address" class="job-data-required" id="job-address" value="<?php echo $job->address; ?>" />
		</div>
		<div class="fieldSet">
			<label for="job-suburb">Suburb</label>
			<input type="text" name="suburb" class="job-data-required" id="job-suburb" value="<?php echo $job->suburb; ?>" />
		</div>
		<div class="fieldSet">
			<label for="melways_ref">Melways Ref</label>
			<input type="text" name="melways_ref" class="job-data-required" id="melways_ref" value="<?php echo $job->melways_ref; ?>" />
		</div>
		<div class="fieldSet">
			<label for="equipment">Equipment Needed</label>
			<textarea name="equipment" class="job-data-required" id="equipment"><?php echo $job->equipment; ?></textarea>
		</div>
		<div class="fieldSet">
			<div class="sMall">
				<label for="start_time">Start Time</label>
				<select name="start_time" id="start_time">
				<?php for($i=0; $i<=24; $i++) {
							$t1 = $i.'.00';
							$t2 = $i.'.50'; ?>
					<option value="<?php echo getTime($t1); ?>"<?php if(!empty($job->start_time) && $job->start_time == getTime($t1)) { echo ' selected="selected"'; } ?>><?php echo getTime($t1); ?></option>
					<option value="<?php echo getTime($t2); ?>"<?php if(!empty($job->start_time) && $job->start_time == getTime($t2)) { echo ' selected="selected"'; } ?>><?php echo getTime($t2); ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="sMall last">
				<label for="end_time">End Time</label>
				<select name="end_time" id="end_time">
				<?php for($i=0; $i<=24; $i++) {
							$t1 = $i.'.00';
							$t2 = $i.'.50'; ?>
					<option value="<?php echo getTime($t1); ?>"<?php if(!empty($job->end_time) && $job->end_time == getTime($t1)) { echo ' selected="selected"'; } ?>><?php echo getTime($t1); ?></option>
					<option value="<?php echo getTime($t2); ?>"<?php if(!empty($job->end_time) && $job->end_time == getTime($t2)) { echo ' selected="selected"'; } ?>><?php echo getTime($t2); ?></option>
				<?php } ?>
				</select>

			</div>
		</div>
		<div class="fieldSet">
			<label for="details">Details</label>
			<textarea name="details" class="job-data-required" id="details"><?php echo $job->details; ?></textarea>
		</div>
		<div class="fieldSet">
			<input type="hidden" name="date" value="<?php echo $date; ?>" />
			<input type="hidden" name="crew_id" value="<?php echo $crew_id; ?>" />
			<input type="hidden" name="job_id" value="<?php echo $job_id; ?>" />
			<input type="submit" name="job-submit" id="job-submit" value="<?php if($job_id) { echo 'Update'; } else { echo 'Book Now'; } ?>" />
		</div>
	</form>
</div>
<?php } //endif
} ?>
