<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
            $this->template->set_title('Welcome');
            $this->template->load_view('welcome_message');
	}
}


