<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

       function __construct() {
        $this->load->helper(array('form','url')); 
       }

	public function create()
	{
            $config['upload_path'] = './uploads';
            $this->load->library('upload',$config);


            if(!this->upload->do_upload()){
              // this throws error
              $data = array('data'=>$this->upload->display_errors());
            } else {
              // this doesnot throw any error
              $data = array('data'=>$this->upload->data());
            }

            $this->template->set_title('Welcome');
            $this->template->load_view('welcome_message', $data);
	}
}
