<?php require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
class SOAPClientFunctionsManager
{

	function CallClientFunction()
	{
		global $wpdb;
		$select = "SELECT * FROM `".$wpdb->prefix."pp_checked` WHERE checked = 1";
		$fetchPostIds = $wpdb->get_results($select);
		$getPostDatas = array();
		foreach($fetchPostIds as $fetchPostId)
		{ $getPostDatas[] =  get_post($fetchPostId->postid); }
		return $getPostDatas;
	}
}
if(!extension_loaded("soap")){
  dl("php_soap.dll");
}

ini_set("soap.wsdl_cache_enabled","0");
$server = new SoapServer("client.wsdl");
$server->setClass("SOAPClientFunctionsManager");
$server->handle();
?>
