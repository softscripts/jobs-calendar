<?php
ini_set("display_errors",1);
$wp_abspath 	= dirname(__FILE__);
$wp_abspath_1 = str_replace('wp-content/plugins/jobs-calendar/calendar', '', $wp_abspath);
$wp_abspath_1 = str_replace('wp-content\plugins\jobs-calendar\calendar', '', $wp_abspath_1);
require_once($wp_abspath_1 .'wp-config.php');

global $wpdb, $wp_version;

if ( is_user_logged_in() ) { // access only for users

/* Load available data */
$job_id 	= $_REQUEST['job_id'];
$status   = 0;

require_once ( 'util.php' );

$crew_table 		= WP_crews_TABLE;
$jobs_table 		= WP_jobs_TABLE;
$service_table 	= WP_services_TABLE;

if($job_id) {
	$job = $wpdb->get_row( "SELECT * FROM $jobs_table WHERE id=$job_id ORDER BY 'order' ASC" );
}


?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Job Details</title>
<link rel='stylesheet' id='jc_css-css'  href='css/style.css' type='text/css' media='all' />
</head>
<body onload="window.print();">
<div class="print_job">
	<table border="0" width="100%" cellpadding="3">
		<tr>
			<td align="left"><h2>Job Sheet/Time Sheet</h2></td>
			<td align="right"><h2>RABS Sweeping Services</h2></td>
		</tr>
	</table>
	<h2 style="text-align: center"><?php echo getService($job->service); ?></h2>
	<table border="1" rules="all" width="100%" cellpadding="3">
		<tr>
			<td width="80%">Day: <?php echo date('D', $job->date); ?></td>
			<td valign="top" rowspan="2">Job Sheet # <?php echo $job->job_number; ?></td>
		</tr>
		<tr>
			<td>Date: <?php echo date('jS M', $job->date); ?></td>
		</tr>
		<tr>
			<td colspan="2">Client: <?php echo $job->customer; ?></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" class="gray_head">Job Location</td>
		</tr>
		<tr>
			<td>1. <?php echo $job->address; ?></td>
			<td>Melway Ref: <?php echo $job->melways_ref; ?></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table border="1" rules="all" width="100%" cellpadding="3">
		<tr>
			<td width="22%">Name</td>
			<td width="13%">Start<br />Yard</td>
			<td width="13%">On Site</td>
			<td width="13%">Lunch</td>
			<td width="13%">Finish<br />Day</td>
			<td width="13%">Left Site</td>
			<td width="13%">Finished</td>
		</tr>
		<tr>
			<td>James</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Aldo</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Dave</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Walter</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Ean</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Kyle</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Jason</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Adrian</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Joey</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="7" class="gray_head">&nbsp;</td>
		</tr>
		<tr>
			<td>Plant</td>
			<td colspan="2">Type</td>
			<td colspan="2">Plant Number</td>
			<td colspan="2">Hire Number</td>
		</tr>
		<tr>
			<td>Paver</td>
			<td colspan="2">Vogelle</td>
			<td colspan="2">5103-2</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Steel Roller</td>
			<td colspan="2">Hamm</td>
			<td colspan="2">HD 14</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Multi Roller</td>
			<td colspan="2">Hamm</td>
			<td colspan="2">TT14</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Bobcat</td>
			<td colspan="2">Bobcat</td>
			<td colspan="2">S130</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Bobcat Broom</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Bobcat Broom</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Compressor</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Wacker Plate</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Float Moves</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Other</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Other</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Other</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<table border="1" rules="all" width="100%" style="margin-top: 30px;" cellpadding="3">
		<tr>
			<td width="22%">Material</td>
			<td width="26%">Supplied By</td>
			<td width="26%">Tonnes</td>
			<td width="26%">Used</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
	</table>
</div>

</body>
</html>
<?php } ?>
