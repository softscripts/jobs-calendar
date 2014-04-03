<?php function manage_customers() {

global $wpdb;

$link = get_bloginfo('url')."/wp-admin/admin.php?page=manage_customers";
$table_name = WP_customers_TABLE; 
$task = $_REQUEST['action'];
$id = $_REQUEST['id'];

/* Delete single record */
if($task == 'trash') {
	$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $id));
	echo '<script>location.href="'.$link.'"</script>';
}

/* Load values in edit mode */
if($task == 'edit') {
	$service = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
	$name = $service->name;
	
}

if(isset($_POST['submit'])) {
	$name = $_POST['service-name'];
	
	
	if($task == 'edit' && !empty($id)) {
		$wpdb->query("UPDATE `$table_name` SET `name`='$name' WHERE id='$id'"); 
		echo '<script>location.href="'.$link.'"</script>';		
	}
	else {

	$wpdb->query( $wpdb->prepare("INSERT INTO `$table_name`(`name`)	VALUES ( %s)", $name, $email ) );
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
	width: 45%;
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
	width: 50%;
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

jQuery('#job-service-submit').click(function(){
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

﻿<div class="add_new"><div id="icon-edit" class="icon32 icon32-posts-post"></div><h2>Manage customers</h2></div>

<div class="manage_listing">
<table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
	<tr>
	<th class="manage-column column-ID sortable desc" id="ID" scope="col" width="15%"><span style="margin:5px; display:block">ID</span></th>
	<th class="manage-column column-title sortable desc" id="title" scope="col"><span>Title</span></th>
	
	</tr>
	</thead>
	<tfoot>
	<tr>
	<th class="manage-column column-ID sortable desc" id="ID" scope="col" width="15%"><span style="margin:5px; display:block">ID</span></th>
	<th class="manage-column column-title sortable desc" scope="col"><span>Title</span></th>
       
	</tr>
	</tfoot>
	<tbody id="the-list">

<?php
	$customers = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY 'name' ASC" );
	if(count($customers) > 0) {
	$i = 0;
	foreach($customers as $service) {
	$i++;
	 ?>

	<tr valign="top" class="post-<?php echo $service->id; if($i%2==0) { ?> alternate<?php } ?>" id="post-<?php echo $service->id; ?>">
	
	<th class="check-column" scope="row"><span style="margin:5px; display:block"><?php echo $i; ?></span></th>

	<td class="post-title page-title column-title"><strong><a title="Edit “<?php $service->name; ?>”" href="<?php echo $link; ?>&action=edit&id=<?php echo $service->id; ?>" class="row-title"><?php echo $service->name; ?></a></strong>

<div class="row-actions"><span class="edit"><a title="Edit this item" href="<?php echo $link; ?>&action=edit&id=<?php echo $service->id; ?>">Edit</a> | </span><span class="trash"><a href="<?php echo $link; ?>&action=trash&id=<?php echo $service->id; ?>" class="submitdelete" onclick="return ConfrmDelete();">Delete</a></span></div>
</td>	
		
</tr>
<?php } 
}
else { ?>
<tr valign="top">
<td colspan="2" align="center" height="20"><strong>No customers found</strong></td>
</tr>
<?php }
 ?>

		</tbody>
</table>
</div>

<div class="add-edit-form">
	<div class="form-wrap">
	<h3><?php if($task == 'edit') { echo 'Update'; } else { echo 'Add New'; } ?></h3>
	<form name="service-form" method="post" action=""class="validate">
	<div class="form-field form-required">
		<label for="service-name">Name</label>
		<input name="service-name" id="service-name" type="text" class="job-data-required" value="<?php echo $name; ?>" size="40">
		
	</div>
	
	<p class="submit"><input type="submit" name="submit" id="job-service-submit" class="button button-primary" value="<?php if($task) { echo 'Update'; } else { echo 'Add New'; } ?>"><?php if($task == 'edit') { ?>  <a href="<?php echo $link; ?>" class="button button-primary">Cancel</a><?php } ?></p>
	</form>
	</div>
</div>
<?php } ?>
