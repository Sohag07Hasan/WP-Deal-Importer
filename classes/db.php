<?php 
/*\
 * This class is to save entries into wordpress database
 * */
 
 class DealImportDb{
 	
	public $db_name, $deal_table, $deal_table_meta;
 	
	function __construct(){
		global $wpdb;
		$this->deal_table = $wpdb->posts;
		$this->deal_table_meta = $wpdb->postsmeta;
	}
	
	
	function insert_deal($id, $title, $content, $end_date){
		$attr = array(
			'post_type' 	=> 'post',
			'post_status' 	=> 'publish',
			'post_title' 	=> $title,
			'post_content' 	=> $content
		);
		
		//duplicate checking
		if($this->if_deal_exists($id)) return false;
		
		var_dump($attr); 
		//end date checking ane it will be chcking 
		
		$deal_id = wp_insert_post($attr);
		
		var_dump($deal_id);
		
		return $deal_id;		
	}
	
	
	function insert_deal_meta($deal_id, $info){
		if (!$deal_id || count($info) <1) return;
		
		//var_dump($info); //checking $info
		//return;
		
		foreach($info as $key => $value){
			update_post_meta($deal_id, $key, $value);
		}		
	}
	
	
	function if_deal_exists($id){
		global $wpdb;
				
		$query = $wpdb->prepare("select post_id from {$wpdb->postmeta} where meta_key like 'id' and meta_value like '%s'", $id);
						
		if($wpdb->get_var($query)){
			return true;
		}
		else {
			return false;
		}
	}
	
	
 }
 
?>