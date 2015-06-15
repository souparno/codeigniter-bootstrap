<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
           //    $this->load->library('template');
           //    $this->template->set_title('Welcome');

echo "Hello";           
echo assets_url('css/bootstrap.min.css');
echo "Hi";

$this->load->view('template/base_view');
	}
}


