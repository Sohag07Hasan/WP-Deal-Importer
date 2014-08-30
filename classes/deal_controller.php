<?php	
	//this class will control deals
	
	class DealController{
		
		public $deal_importer, $deal_parser, $db;
		
		
		/**
		 * Initialize functionalities of the plugin
		 * */				
		function init() {
			//add_action( 'init', array($this, 'initialize') );
			
			add_action('admin_menu', array($this, 'admin_menu_for_deal_importer')); //add amdin menu
		}
		
		
		function initialize(){
			$this->get_deal_importer();
			$deals = $this->deal_importer->get_deals(100, 1, 41, 2);	
			
			//var_dump($deals); exit;
						
			if($deals){
				foreach	($deals->deals as $deal){
					if($deal_parser = $this->get_deal_parser($deal)){
						$deal_parser->save();	
					}					
				}	
			}
			
			exit;						
		}
		
		
		/*
		 * Create an object of DealImporter Class
		 * Saves the object in $deal_importer variable
		 * 
		 * */
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
		
		
		/**
		 * Cretes an object of DealParser class
		 * saves the object in $deal_parser variable
		 * @$deal: if present it will parse the deal 
		 * 
		 * */
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
		
		
		/**
		 * Creates an object of DealImportDB class
		 * creates every interface with database
		 * */
		function get_db_object(){
			if($this->db instanceof DealImportDb){
				return $this->db;
			}
			elseif($this->load_script($this->get_path('/classes/db.php', 'class', 'DealImporterDb'))){
				$this->db = new DealImportDb();
			}
			
			return $this->db;
		}
		
		
		/** 
		 * Generate absolute path from relative path 
		 * @path: ex '/class/db.php'
		 */
		 function get_path($path = ''){
			return WPAUTODEAL_DIR . $path;	
		}
		
		
		/**
		 * dynamically load script cheking different condition
		 * @path: absolute path like '/opt/lampp..../sth.php'
		 * @type: type that needs to be checked like 'class', 'function' etc
		 * @name: name of the type like DealImportDB, 'wp_redirect' etc
		 */
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
		
		
		/**
		 * Initialize adim interface
		 */
		 function admin_menu_for_deal_importer(){
		 	add_menu_page('wordpress deal importer', 'F deals', 'manage_options', 'f_deals', array($this, 'f_deal_menu_page'));
		 }
		
		
		/**
		 * menu page to control deal activities 
		 */
		 function f_deal_menu_page(){
		 	
		 }
	}
?>