<?php function manage_crews() {

global $wpdb;

$link = get_bloginfo('url')."/wp-admin/admin.php?page=manage_crews";
$table_name = WP_crews_TABLE; 
$task = $_REQUEST['action'];
$id = $_REQUEST['id'];

/* Delete single record */
if($task == 'trash') {
	$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $id));
	echo '<script>location.href="'.$link.'"</script>';
}

/* Load values in edit mode */
if($task == 'edit') {
	$crew = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
	$name = $crew->name;
	$order = $crew->order;
	$description = $crew->description;
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

﻿<div class="add_new"><div id="icon-edit" class="icon32 icon32-posts-post"></div><h2>Manage Crews</h2></div>

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
	$crews = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY 'order' ASC" );
	if(count($crews) > 0) {
	$i = 0;
	foreach($crews as $crew) {
	$i++;
	 ?>

	<tr valign="top" class="post-<?php echo $crew->id; if($i%2==0) { ?> alternate<?php } ?>" id="post-<?php echo $crew->id; ?>">
	
	<th class="check-column" scope="row"><span style="margin:5px; display:block"><?php echo $i; ?></span></th>
	<td class="post-title page-title column-title"><strong><a title="Edit “<?php $crew->name; ?>”" href="<?php echo $link; ?>&action=edit&id=<?php echo $crew->id; ?>" class="row-title"><?php echo $crew->name; ?></a></strong>
<div class="row-actions"><span class="edit"><a title="Edit this item" href="<?php echo $link; ?>&action=edit&id=<?php echo $crew->id; ?>">Edit</a> | </span><span class="trash"><a href="<?php echo $link; ?>&action=trash&id=<?php echo $crew->id; ?>" class="submitdelete" onclick="return ConfrmDelete();">Delete</a></span></div>
</td>			
</tr>
<?php } 
}
else { ?>
<tr valign="top">
<td colspan="2" align="center" height="20"><strong>No crews found</strong></td>
</tr>
<?php }
 ?>

		</tbody>
</table>
</div>

<div class="add-edit-form">
	<div class="form-wrap">
	<h3><?php if($task == 'edit') { echo 'Update'; } else { echo 'Add New'; } ?></h3>
	<form name="crew-form" method="post" action=""class="validate">
	<div class="form-field form-required">
		<label for="crew-name">Name</label>
		<input name="crew-name" id="crew-name" class="job-data-required" type="text" value="<?php echo $name; ?>" size="40">
		<p>The name is how it appears on calendar.</p>
	</div>
	<div class="form-field">
		<label for="crew-order">Order</label>
		<input name="crew-order" id="crew-order" class="job-data-required" type="text" value="<?php echo $order; ?>" size="40">
		<p>The order is how it orders on calendar.</p>
	</div>
	<div class="form-field">
		<label for="crew-description">Description</label>
		<textarea name="crew-description" id="crew-description" rows="5" cols="40"><?php echo $description; ?></textarea>
		<p>The description of crew. Optional</p>
	</div>
	<p class="submit"><input type="submit" name="submit" id="job-crew-submit" class="button button-primary" value="<?php if($task) { echo 'Update'; } else { echo 'Add New'; } ?>"><?php if($task == 'edit') { ?>  <a href="<?php echo $link; ?>" class="button button-primary">Cancel</a><?php } ?></p>
	</form>
	</div>
</div>
<?php } ?>
