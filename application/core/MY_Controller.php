<?php 
class MY_Controller extends CI_Controller {
 public function __construct(){
               parent::__construct();

		$this->load =& load_class('Loader', 'core', 'MY_');
		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
              
                $this->load->config('assets'); 
                $this->load->helper('url');
                $this->load->library('template');
	} 
 }
