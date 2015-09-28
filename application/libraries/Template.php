<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Template {
    private $ci;
    protected $title_separator = ' - ';
    protected $ga_id;
    protected $theme;
    protected $title;
    protected $description;
    protected $metadata = array();
    protected $js = array();
    protected $css = array();

    function __construct() {
        $this->ci = & get_instance();
    }

    public function set_theme($theme) {
        $this->theme = $theme;
    }

    public function set_title($title) {
        $this->title = $title;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function add_metadata($name, $content) {
        $name = htmlspecialchars(strip_tags($name));
        $content = htmlspecialchars(strip_tags($content));
        $this->metadata[$name] = $content;
    }

    public function add_js($js) {
        $this->js[$js] = $js;
    }

    public function add_css($css) {
        $this->css[$css] = $css;
    }

    public function get_title() {
        if (empty($this->title)) {
            $this->title = '';
        }
        return $this->title;
    }
    
    public function get_description() {
        if (empty($this->description)) {
            $this->description = '';
        }
        return $this->description;
    }

    public function get_metadata(){
        $metadata = array();
        foreach ($this->metadata as $name => $content) {
            if (strpos($name, 'og:') === 0) {
                $metadata[] = '<meta property="' . $name . '" content="' . $content . '">';
            } else {
                $metadata[] = '<meta name="' . $name . '" content="' . $content . '">';
            }
        }
        return implode('', $metadata);
    }
    
    public function get_js(){
        $js = array();
        foreach ($this->js as $js_file) {
            $js[] = '<script src="' . assets_url('js/' . $js_file) . '"></script>';
        }
        return implode('', $js);
    }
    
    public function get_css(){
        $css = array();
        foreach ($this->css as $css_file) {
            $css[] = '<link rel="stylesheet" href="' . assets_url('css/' . $css_file) . '">';
        }
        return implode('', $css);
    }

    public function get_theme() {
        if(!$this->theme) {
            $this->theme = 'default';
        }
        return $this->theme;
    }
    
    public function render($data = array(), $return = FALSE) {
        $view = $this->ci->router->class . "/" . $this->ci->router->method;
        if ($this->ci->input->is_ajax_request()) {
            $this->ci->load->view($view, $data);
            return;
        }

        $title = $this->get_title();
        $description = $this->get_description();
        $metadata = $this->get_metadata();
        $js = $this->get_js();
        $css = $this->get_css();
        $theme = $this->get_theme();
        $header = $this->ci->load->ext_view('public/themes/' . $theme . '/header', array(), TRUE);
        $footer = $this->ci->load->ext_view('public/themes/' . $theme . '/footer', array(), TRUE);
        $content = $this->ci->load->view($view, $data, TRUE);
        
        return $this->ci->load->ext_view('public/themes/' . $theme . '/index', array(
            'title' => $title,
            'description' => $description,
            'metadata' => $metadata,
            'header' => $header,
            'footer' => $footer,
            'main_content' => $content,
            'js' => $js,
            'css' => $css,
            'ga_id' => $this->ga_id,
        ), FALSE);
    }

}
