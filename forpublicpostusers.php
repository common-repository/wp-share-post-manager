<script type="text/javascript">
	/* <![CDATA[*/
	jQuery(document).ready(function(){
		jQuery('#memberlist').dataTable();
	});
	/*  ]]> */
</script>

<div class="wrap">
 <table class="wp-list-table widefat fixed " id="memberlist">
	<thead><tr>
	<th style="text-align:center;"><u>ID</u></th>
	<th style="text-align:center;"><u>SiteUrl</u></th>
	<th style="text-align:center;"><u>Edit</u></th>
	<th style="text-align:center;"><u>Delete</u></th>
	</tr></thead>
<tbody>
	<?php 
		global $wpdb; $serialNumber = 1; 
		$select = "SELECT * FROM ".$wpdb->prefix."pp_userdetails";
		$fetchCredentials = $wpdb->get_results($select);
		foreach($fetchCredentials as $fetchCredential){?>

		<tr style="text-align:center;">
			<td><?php echo $serialNumber; ?></td>
			<td><?php echo $fetchCredential->siteurl; ?></td>
			<td><a href="admin.php?page=credential&act=upd&id=<?php echo $fetchCredential->id ?>"><?php echo 'Edit'; ?></a></td>
			<td><a href="admin.php?page=credential&act=delete&id=<?php echo $fetchCredential->id ?>"><?php echo 'Delete'; ?></a></td>
		</tr>
	<?php $serialNumber++; } ?>
</tbody>
</table>
</div>
