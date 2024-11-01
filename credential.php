<?php

	global $wpdb;
	 
	if($_REQUEST["act"] == 'upd')
	{  
		$select = "SELECT * FROM ".$table_name = $wpdb->prefix . "pp_userdetails WHERE id = ".$_REQUEST["id"];
		$result = mysql_query($select) or die ('Error, query failed');
		if (mysql_num_rows($result) > 0 )
		{
			if($row = mysql_fetch_assoc($result))
			{
				$id        		= $row['id'];
				$siteurl         	= $row['siteurl'];
			 	$hide     		= $row['hide'];
			 	$btn	   		= "Update Credential";
				$hidval	   		= '2';
			}
		}
	}
	else
	{
		$btn	  	 	="Add Credential";
		$id       		= "";
		$siteurl         	= "";
	 	$hide  		    	= "";
		$url   		 	= "";
		$hidval	         	= '1';
	}
?>
<div xmlns="https://www.w3.org/1999/xhtml" class="wrap nosubsub">

	<div class="icon32" id="icon-edit"><br/></div>
<h2><?php echo $btn;?></h2>
<div id="col-left">
	<div class="col-wrap">
		<div>
			<div class="form-wrap">
				 
				<form class="validate" action="admin.php?page=credential" method="post" id="addtag">

					<div class="form-field">
						<label for="tag-name">Site Url <small><i>(Type You Child Site Url with ' / ' )</i></samll></label>

						<input type="text" size="40" id="siteurl" name="siteurl" value="<?php echo $siteurl; ?>"/> <br />
						<small><i><?php echo 'Like : '.get_option('siteurl').'/' ;  ?></i></samll>	
					</div>
  
					<p class="submit">
						<input type="submit" value="<?php echo $btn; ?>" class="button" id="submit" name="submit"/>
						<input type="hidden" name="addme" value=<?php echo $hidval;?> >
						<input type="hidden" name="id" value=<?php echo $id;?> >
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
