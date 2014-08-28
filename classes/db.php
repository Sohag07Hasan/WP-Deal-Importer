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
	
	
	function insert_deal($id, $title, $content){
		$attr = array(
			'post_type' 	=> 'post',
			'post_status' 	=> 'publish',
			'post_title' 	=> $title,
			'post_content' 	=> $content
		);
		
		//duplicate checking
		if($this->is_exists($id)) return false;
		
		$deal_id = wp_insert_post($attr);
		
		return $deal_id;		
	}
	
	
	function insert_deal_meta($deal_id, $info){
		if (!$deal_id || count($info) <1) return;
		
		foreach($info as $key => $value){
			update_post_meta($deal_id, $key, $value);
		}		
	}
	
	
	function is_exists($id){
		global $wpdb;
		$query = "select post_id from {$wpdb->post_meta} where meta_key like 'id' and meta_value like '$id'";
		
		if($wpdb->get_var($query)){
			return true;
		}
		else {
			return false;
		}
	}
	
	
 }
 
?>