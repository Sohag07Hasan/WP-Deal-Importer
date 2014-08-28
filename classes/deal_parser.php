<?php 
//this class is to parse deal into database

class DealParser{
	
	private $deal, $title, $description, $end_date, $deal_id, $id, $meta_info, $meta_keys;
	
	function __construct($deal = null){
		if($deal){
			$this->deal = $deal;
		}
		
		$this->meta_keys = array('id', 'discountPercent', 'country', 'businessIds', 
								'latLngs', 'city', 'provider', 'realPriceWithSymbol', 
								'dealPriceWithSymbol', 'showDealUrl', 'buyDealUrl', 
								'image200_H', 'image350_H', 'image450_H', 'timeLeft');
	}
	
	
	function parse(){
		
		//solid info broken into deal
		$this->deal_id 		= $this->deal->id;
		$this->title  		= $this->deal->title;
		$this->end_date 	= $this->end_date;
		$this->description 	= $this->description;
		
		foreach($this->meta_keys as $key){
			$this->meta_info[$key] = $this->deal->{$key};
		}
				
	}
	
	
	
	function save(){
		global $deal_controller;
		$deal_controller->load_script('/classes/db.php', 'class', 'DealImportDb');
		
		$a_deal = new DealImportDb();
		$deal_id = $a_deal->insert_deal($this->id, $this->title, $this->content);
		$a_deal->insert_deal_meta($deal_id, $this->meta_info);		
	}
	
	
	/*
	 * Set a new deal
	 * */
	 function set_deal($deal = null){
	 	if(empty($deal)) return false;
		
		//var_dump($deal);return;
		
		$this->deal = $deal;
		$this->parse();
		
	 }
	
}

?>