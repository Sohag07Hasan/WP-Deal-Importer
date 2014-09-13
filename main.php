<?php 

/*
Plugin Name: Wp Customized Deals
Author: Mahibul Hasan
Description: This plugin imports deals using third party API and to earn money by affiliate
*/

define("WPAUTODEAL_FILE", __FILE__);
define("WPAUTODEAL_DIR", dirname(__FILE__));
define("WPAUTODEAL_URL", plugins_url('/', __FILE__));


include WPAUTODEAL_DIR . '/classes/deal_controller.php';
$deal_controller = new DealController();
global $deal_controller;
$deal_controller->init();
//$deal_controller->initialize();
	
?>
