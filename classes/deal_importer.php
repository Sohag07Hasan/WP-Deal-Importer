<?php 
	/* Deal importer class */
	
	class DealImporter {
		
		private $api_key, $publisher_id, $deal_source;
				
		function __construct(){
			$this->api_key 		= 'VN43ZG2LLHKHHIU6';
			$this->publisher_id = '316';			
			$this->deal_source	= 'http://api.firsatbufirsat.com/deal/browse.html';
		}
		
		
		/**
		 * Geneates api url using differnt conditional
		 * helper function to be used by get_deal()
		 * @item_in_page: number of item to be shown
		 * @page_no: current page number
		 * @city_id: city based deal 
		 * @tag_ids: Tag based deal 
		 */	
		private function get_import_url($item_in_page=null, $page_no=null, $city_id=null, $tag_ids=null){
			$params = array(
				'apiKey' 		=> $this->api_key,
				'publisherId' 	=> $this->publisher_id,
				'cityId' 		=> $city_id,
				'tagIds' 		=> $tag_ids,
				'itemInPage' 	=> $item_in_page,
				'p' 			=> $page_no
				
			);
			
			return add_query_arg($params, $this->deal_source);
		}
		
		
		/**
		 * Import deals depends on query arguments
		 * @item_in_page: number of item to be shown
		 * @page_no: current page number
		 * @city_id: city based deal 
		 * @tag_ids: Tag based deal 
		 */	
		function get_deals($item_in_page=null, $page_no=null, $city_id=null, $tag_ids=null){
			$deal_url = $this->get_import_url($item_in_page=null, $page_no=null, $city_id=null, $tag_ids=null);
			
			//wp wrapper to make get request
			$response = wp_remote_get($deal_url);
			
						
			if(is_wp_error($response)) return false; //return false/null if response is faulty
			
			if($response['response']['code'] == 200){
				$jason_encoded_deals = $response['body'];
				$deals = json_decode($jason_encoded_deals);
				return $deals;
			}
			
			return false;
			
		}
		
	}
?>