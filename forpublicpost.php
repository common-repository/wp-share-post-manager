<?php
/*
Plugin Name: Wp share Post Manager
Plugin URI: http://www.cisin.com/
Description: For Public Post.
Version: 1.0
Author: CIS Team
Author URI: http://www.cisin.com
*/

require_once("memberclass.php");
$objMem = new memberClass();

$table_name = $wpdb->prefix . "pp_userdetails";

function addPublicPost() {


//-- create server.wsdl

global $wpdb;
$SiteUrl = get_option('siteurl');

$wsdl = "<?xml version='1.0'?>
<definitions name='ClientWsdl' targetNamespace='urn:ClientWsdl' xmlns:tns='urn:ClientWsdl'  xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/wsdl/soap/' xmlns:soapenc='http://schemas.xmlsoap.org/soap/encoding/' xmlns:wsdl='http://schemas.xmlsoap.org/wsdl/' xmlns='http://schemas.xmlsoap.org/wsdl/'>";

$wsdl .= "<message name='getCallClientFunctionRequest'>
		<part name='myelement2' type='xsd:array'/>
	</message>
	<message name='getCallClientFunctionResponse'>
		<part name='Result' type='xsd:array'/>		
	</message>";

$wsdl .= "<binding name='orderBinding' type='tns:orderPortType'>
		<soap:binding style='rpc' transport='http://schemas.xmlsoap.org/soap/http'/>
			<operation name='CallClientFunction'>
				<soap:operation soapAction='urn:CallClientFunction'/>
				<input>
					<soap:body use='encoded' namespace='urn:CallClientFunction' encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'/>
				</input>
				<output>
					<soap:body use='encoded' namespace='urn:CallClientFunction' encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'/>
				</output>
			</operation>
	</binding>";
 
$wsdl .= "<service name='orderService'>
		<port name='StockQuotePort' binding='tns:orderBinding'>
			<soap:address location='".$SiteUrl."/wp-content/plugins/forpublicpost/soaprequest/client.php' />
		</port>
	</service>
</definitions>";

	$path = $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/forpublicpost/soaprequest/';
	$clientFile = $path."client.wsdl";
	if(!file_exists($clientFile))
	{
		$handle = fopen($clientFile, "a+");
		fwrite($handle, $wsdl);
		$contents = fread($handle, filesize($clientFile));
	}
	fclose($handle);  
 
	 
	$table_name = $wpdb->prefix."pp_userdetails";
	$MSQL  = "show tables like '$table_name'";

	$table_name1 = $wpdb->prefix."pp_checked";
	$MSQL1  = "show tables like '$table_name1'";

	if($wpdb->get_var($MSQL) != $table_name)
	{
		$sql = "CREATE TABLE `wp_pp_userdetails` (
			  `id` int(11) NOT NULL auto_increment,
			  `siteurl` varchar(255) NOT NULL,
			   PRIMARY KEY  (`id`)
			)";

		require_once(ABSPATH . "wp-admin/includes/upgrade.php");
		dbDelta($sql);
	}

	if($wpdb->get_var($MSQL1) != $table_name1)
	{
		$sql1 = "CREATE TABLE `".$table_name1."` (
				`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
				`postid` INT( 11 ) NOT NULL ,
				`checked` INT( 11 ) NOT NULL ,
				PRIMARY KEY ( `id` )
				) ";

		require_once(ABSPATH . "wp-admin/includes/upgrade.php");
		dbDelta($sql1);
	}
}

function removePublicPost(){
	
	global $wpdb;
	$table = $wpdb->prefix . "pp_userdetails";
	$structure = "drop table if exists $table";
	$wpdb->query($structure);  

	$table1 = $wpdb->prefix . "pp_checked";
	$structure1 = "drop table if exists $table1";
	$wpdb->query($structure1);  
}

	/* Hook Plugin */
	register_activation_hook(__FILE__,'addPublicPost');
	register_deactivation_hook(__FILE__ , 'removePublicPost' );


	/* Creating Menus */
	function member_Menu()
	{
		/* Adding menus */
		add_menu_page(__('For Public Post'),'For Public Post', 8,'forpublicpost/forpublicpost.php', 'forpublicpost');
		add_submenu_page('forpublicpost/forpublicpost.php', 'Credentials List', 'Credentials List', 8, 'setting', 'setting');
		add_submenu_page('forpublicpost/forpublicpost.php', 'New Credential', 'New Credential', 8, 'credential', 'credential');
		 

		wp_register_style('demo_table.css', plugin_dir_url(__FILE__) . 'css/demo_table.css');
		wp_enqueue_style('demo_table.css');

		wp_register_script('jquery.dataTables.js', plugin_dir_url(__FILE__) . 'js/jquery.dataTables.js', array('jquery'));
		wp_enqueue_script('jquery.dataTables.js');

	}

	
add_action('admin_menu', 'member_Menu');


function forpublicpost() {
	include "forpublicpostdata.php";
}

function setting() {
	include "forpublicpostusers.php";
}

function credential() {
	include "credential.php";
}

if(isset($_POST["submit"]))
{
	if($_POST["addme"] == "1")
	{
		$objMem->addCredential($table_name = $wpdb->prefix . "pp_userdetails",$_POST);
		header("Location:admin.php?page=setting&info=saved");
		exit;
	}
	else if($_POST["addme"] == "2")
	{
		$objMem->updCredential($table_name = $wpdb->prefix . "pp_userdetails",$_POST);
		header("Location:admin.php?page=setting&info=upd");
		exit;
	}
}

if($_REQUEST['act'] == 'delete')
{
	$objMem->deleteCredential($table_name = $wpdb->prefix . "pp_userdetails",$_REQUEST['id']);
	header("Location:admin.php?page=setting");
	exit;
}


 

?>
