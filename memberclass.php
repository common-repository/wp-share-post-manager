<?php

	class memberClass
	{
		function addCredential($tblname,$meminfo)
		{
			global $wpdb;
			$insert  = "INSERT INTO ".$tblname." (`siteurl`) ";
			$insert .= " values ('".$meminfo['siteurl']."')";
			$wpdb->query($insert);
			return true;
 		}
		 
		function updCredential($tblname,$meminfo)
		{  
			global $wpdb;
			$update = "UPDATE ".$tblname." SET 
				`siteurl`  = '".$meminfo['siteurl']."' 
				 WHERE id = ".$meminfo['id'];
			$wpdb->query($update);
			return true;
			 
		}

		function deleteCredential($tblname,$id)
		{  
			global $wpdb;
			$delete = "DELETE FROM ".$tblname." WHERE id = ".$id;
			$wpdb->query($delete);
			return true;
			 
		}
	}


?>
