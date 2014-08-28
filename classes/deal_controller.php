<?php	
	//this class will control deals
	
	class DealController{
		
		public $deal_importer, $deal_parser, $db;
						
		function init() {
			//add_action( 'init', array($this, 'initialize') );
		}
		
		
		function initialize(){
			$this->get_deal_importer();
			$deals = $this->deal_importer->get_deals(100, 1, 41, 2);	
						
			if($deals){
				foreach	($deals->deals as $deal){
					if($deal_parser = $this->get_deal_parser($deal)){
						$deal_parser->save();	
					}					
				}	
			}
			
		}
		
		
		function get_deal_importer(){
			if($this->deal_importer instanceof DealImporter){
				return $this->deal_importer;
			}
			elseif( $this->load_script( $this->get_path('/classes/deal_importer.php'), 'class', 'DealImporter') ){
				$this->deal_importer = new DealImporter();
				return $this->deal_importer;
			}
			else { //we are returning an empty object
				return null;
			}						
		}
		
		
		function get_deal_parser($deal = null){
			if($this->deal_parser instanceof DealParser){
				if($deal){
					$this->deal_parser->set_deal($deal);
				}
				return $this->deal_parser;
			}
			elseif( $this->load_script( $this->get_path('/classes/deal_parser.php'), 'class', 'DealParser') ){
				$this->deal_parser = new DealParser();
				$this->deal_parser->set_deal($deal);
				return $this->deal_parser;
			}
			else { //we are returning an empty object
				return null;
			}				
		}
		
		
		function get_db_object(){
			if($this->db instanceof DealImportDb){
				return $this->db;
			}
			elseif($this->load_script($this->get_path('/classes/db.php', 'class', 'DealImporterDb'))){
				$this->db = new DealImportDb();
			}
			
			return $this->db;
		}
		
		
		function get_path($path = ''){
			return WPAUTODEAL_DIR . $path;	
		}
		
		
		function load_script($path = '', $type=null, $name=''){
			switch($type){
				case 'class':
					if(!class_exists($name)){
						include $path;
					}
					break;
				case 'function':
					if(!function_exists($name)){
						include $path;
					}
					break;
				default:
					return false; //return false							
			}
			
			return true;
		}
		
		
	}
?>