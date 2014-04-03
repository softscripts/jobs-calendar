<?php 
function job_func($atts) {
if ( is_user_logged_in() ) { // access only for users

$date = "";
$monday = "";
global $wpdb;
if (isset($_GET['n_startdate'])) {
    $date = $_GET['n_startdate'];
    $lastweek = strtotime("next week", $date);
    $monday = strtotime("last Monday", $lastweek);
} else if ( isset($_GET['p_startdate'])) {
    $date = $_GET['p_startdate'];
    $lastweek = strtotime("-28 days", $date);
    $monday = strtotime("first Monday", $lastweek);
} else {
    $date = strtotime(date('Y-m-d H:i:s'));
    $today = strtotime("today", $date);
		$chkWeek = date('w', $today);
		if($chkWeek == 1) {
	    $monday = $today;
		}
		else {
	    $monday = strtotime("last Monday", $date);
		}
}

$tueday = strtotime('+1 day ', $monday);
$wedday = strtotime('+2 day ', $monday);
$thuday = strtotime('+3 day ', $monday);
$friday = strtotime('+4 day ', $monday);
$satday = strtotime('+5 day ', $monday);
$sunday = strtotime('+6 day ', $monday);


if ( get_option('permalink_structure') ) { 
	$prev_url = JobPageURL().'?p_startdate='.strtotime("-1 day", $monday);
	$next_url = JobPageURL().'?n_startdate='.strtotime("+28 day", $monday);
}
else {
	$prev_url = JobPageURL().'&p_startdate='.strtotime("-1 day", $monday);
	$next_url = JobPageURL().'&n_startdate='.strtotime("+28 day", $monday);
}

$upload_url = JC_PLUGIN_URL.'/calendar/upload.php?type=form&';


$st_date = $monday;
$ed_date = strtotime("+27 day ", $monday);

$crews_table = WP_crews_TABLE; 
$crews = $wpdb->get_results( "SELECT * FROM $crews_table ORDER BY 'order' ASC" );


?>

<?php add_thickbox(); ?>

<div class="jobs-calendar-wrapper">
	
		<div class="jobs-calendar-month-container">
			<div class="calendar-month"><a href="<?php echo $prev_url;  ?>" class="left_arr"><span>Previous</span></a>
			<?php echo date('F Y', $monday)?>
			<a href="<?php echo $next_url;  ?>" class="right_arr"><span>Next</span></a></div>
		</div>
	

     <?php for($i=1;$i<=4;$i++){ ?>

      <?php   	$tueday = strtotime('+1 day ', $monday);
        	$wedday = strtotime('+2 day ', $monday);
		$thuday = strtotime('+3 day ', $monday);
		$friday = strtotime('+4 day ', $monday);
		$satday = strtotime('+5 day ', $monday);
		$sunday = strtotime('+6 day ', $monday);	 ?>

        <div class="jobs-calendar-head">
		<div class="jobs-calendar-head-container">
			
			Week <?php echo $i; ?>
			
		</div>
	</div>

	<div class="jobs-calendar">
		<table border="0">
		<tr class="job-header">
			<td class="index">&nbsp;</td>
			<td>Monday<span>[<?php echo date('M j, Y', $monday)?>]</span></td>
			<td>Tuesday<span>[<?php echo date('M j, Y', $tueday);?>]</span></td>
			<td>Wednesday<span>[<?php echo date('M j, Y', $wedday);?>]</span></td>
			<td>Thursday<span>[<?php echo date('M j, Y', $thuday);?>]</span></td>
			<td>Friday<span>[<?php echo date('M j, Y', $friday);?>]</span></td>
			<td>Saturday<span>[<?php echo date('M j, Y', $satday);?>]</span></td>
			<td>Sunday<span>[<?php echo date('M j, Y', $sunday);?>]</span></td>
		</tr>
	<?php if(count($crews) > 0) { 
		foreach($crews as $crew) { 

		$mondayJob = getJob($monday, $crew->id);
		if(count($mondayJob) > 0) { $mondayJobID = '&job='.$mondayJob->id; } else { $mondayJobID = ""; }

		$tuedayJob = getJob($tueday, $crew->id);
		if(count($tuedayJob) > 0) { $tuedayJobID = '&job='.$tuedayJob->id; } else { $tuedayJobID = ""; }

		$weddayJob = getJob($wedday, $crew->id);
		if(count($weddayJob) > 0) { $weddayJobID = '&job='.$weddayJob->id; } else { $weddayJobID = ""; }

		$thudayJob = getJob($thuday, $crew->id);
		if(count($thudayJob) > 0) { $thudayJobID = '&job='.$thudayJob->id; } else { $thudayJobID = ""; }

		$fridayJob = getJob($friday, $crew->id);
		if(count($fridayJob) > 0) { $fridayJobID = '&job='.$fridayJob->id; } else { $fridayJobID = ""; }

		$satdayJob = getJob($satday, $crew->id);
		if(count($satdayJob) > 0) { $satdayJobID = '&job='.$satdayJob->id; } else { $satdayJobID = ""; }

		$sundayJob = getJob($sunday, $crew->id);
		if(count($sundayJob) > 0) { $sundayJobID = '&job='.$sundayJob->id; } else { $sundayJobID = ""; }
?>
		<tr class="job-data-container">
			<td class="index"><?php echo $crew->name; ?></td>
			<td class="job-data"><a href="<?php echo $upload_url.'date='.$monday.'&crew='.$crew->id.$mondayJobID; ?>&TB_iframe=true&width=250&height=650" class="thickbox"><?php if(count($mondayJob)>0) { ?><span><?php echo $mondayJob->customer; ?><br /><?php echo $mondayJob->address; ?><br/><?php echo $mondayJob->suburb; ?></span><?php } else { ?>&nbsp;<?php } ?></a></td>
			<td class="job-data"><a href="<?php echo $upload_url.'date='.$tueday.'&crew='.$crew->id.$tuedayJobID; ?>&TB_iframe=true&width=250&height=650" class="thickbox"><?php if(count($tuedayJob)>0) { ?><span><?php echo $tuedayJob->customer; ?><br /><?php echo $tuedayJob->address; ?><br/><?php echo $tuesdayJob->suburb; ?></span><?php } else { ?>&nbsp;<?php } ?></a></td>
			<td class="job-data"><a href="<?php echo $upload_url.'date='.$wedday.'&crew='.$crew->id.$weddayJobID; ?>&TB_iframe=true&width=250&height=650" class="thickbox"><?php if(count($weddayJob)>0) { ?><span><?php echo $weddayJob->customer; ?><br /><?php echo $weddayJob->address; ?><br/><?php echo $weddayJob->suburb; ?></span><?php } else { ?>&nbsp;<?php } ?></a></td>
			<td class="job-data"><a href="<?php echo $upload_url.'date='.$thuday.'&crew='.$crew->id.$thudayJobID; ?>&TB_iframe=true&width=250&height=650" class="thickbox"><?php if(count($thudayJob)>0) { ?><span><?php echo $thudayJob->customer; ?><br /><?php echo $thudayJob->address; ?><br/><?php echo $thudayJob->suburb; ?></span><?php } else { ?>&nbsp;<?php } ?></a></td>
			<td class="job-data"><a href="<?php echo $upload_url.'date='.$friday.'&crew='.$crew->id.$fridayJobID; ?>&TB_iframe=true&width=250&height=650" class="thickbox"><?php if(count($fridayJob)>0) { ?><span><?php echo $fridayJob->customer; ?><br /><?php echo $fridayJob->address; ?><br/><?php echo $fridayJob->suburb; ?></span><?php } else { ?>&nbsp;<?php } ?></a></td>
			<td class="job-data"><a href="<?php echo $upload_url.'date='.$satday.'&crew='.$crew->id.$satdayJobID; ?>&TB_iframe=true&width=250&height=650" class="thickbox"><?php if(count($satdayJob)>0) { ?><span><?php echo $satdayJob->customer; ?><br /><?php echo $satdayJob->address; ?><br/><?php echo $satdayJob->suburb; ?></span><?php } else { ?>&nbsp;<?php } ?></a></td>
			<td class="job-data"><a href="<?php echo $upload_url.'date='.$sunday.'&crew='.$crew->id.$sundayJobID; ?>&TB_iframe=true&width=250&height=650" class="thickbox"><?php if(count($sundayJob)>0) { ?><span><?php echo $sundayJob->customer; ?><br /><?php echo $sundayJob->address; ?><br/><?php echo $sundayJob->suburb; ?></span><?php } else { ?>&nbsp;<?php } ?></a></td>
		</tr>
	<?php } //end foreach
			} //end if
		else { ?>
	<tr class="job-data-container">
		<td colspan="8"><div style="text-align: center">Add Crews</div></td>
	</tr>
	<?php	} ?>
		</table>
	</div>
       <?php
          $monday = strtotime('+1 day ', $sunday); 
     } ?>

</div>

<?php } //end if
} ?>
