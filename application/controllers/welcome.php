<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
       parent::__construct();
      // $this->load->library('Template');
    }  
    
    public function index()
    {
       $this->template->set_title('Welcome');
       $this->template->render();
    }
}


