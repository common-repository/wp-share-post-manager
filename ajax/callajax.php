<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

$action = $_REQUEST['action'];
switch ($action)
{

	case 'status':
	global $wpdb;
	$select = "SELECT postid FROM `".$wpdb->prefix."pp_checked` WHERE `postid` = ".$_REQUEST['postid'];
	$fetchValues = $wpdb->get_results($select);
	if(!empty($fetchValues))
	{		
		$update = "UPDATE `".$wpdb->prefix."pp_checked` SET `checked` = '".$_REQUEST['status']."' WHERE `postid` = ".$_REQUEST['postid'];
		$wpdb->query($update);	
	}
	else 
	{
		$update = "INSERT INTO `".$wpdb->prefix."pp_checked` (`postid` ,`checked`) VALUES ('".$_REQUEST['postid']."', '".$_REQUEST['status']."');";
		$wpdb->query($update);	
	}	

	break;
	
	case 'checkauth':
	
	try
	{
		$options["connection_timeout"] = 25;
		$options['trace'] = 1;
		$options['cache_wsdl'] = 0;

		$parentSite =  get_site_url().'/';
		global $wpdb;
		$select = "SELECT * FROM `".$wpdb->prefix."pp_userdetails`";
		$getcredentials = $wpdb->get_results($select);
		
		foreach($getcredentials as $getcredential)
		{
			$url = $getcredential->siteurl.'wp-content/plugins/childpublicpost/soapresponse/server.php?wsdl';
			$client     = new SoapClient($url, $options);
			$myarray    = array($parentSite , $getcredential->siteurl);
			$response   = $client->CallServerFunction($myarray);
			//echo '<pre>';
			//print_r($response);
			//echo '</pre>';		
		}
			
		
 
	}
	catch(SoapFault $e)
	{
		echo "<pre>";
		print_r($e); 
	}

		 
	
	break;

}




?>
