<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Asset {

  protected $js = array();
  protected $css = array();

  public function add_js($js){
     $this->js[$js] = $js;
  }

  public function add_css($css){
     $this->css[$css] = $css;
  }
}
