<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Template {

    private $ci;

    protected $title_separator = ' - ';
    protected $ga_id = FALSE; // UA-XXXXX-X

    protected $theme = 'default';

    protected $title = FALSE;
    protected $description = FALSE;

    protected $metadata = array();

    protected $js = array();
    protected $css = array();

    function __construct()
    {
        $this->ci =& get_instance();
    }

    public function set_theme($theme)
    {
        $this->theme = $theme;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

   public function set_description($description)
    {
        $this->description = $description;
    }

   public function add_metadata($name, $content)
    {
        $name = htmlspecialchars(strip_tags($name));
        $content = htmlspecialchars(strip_tags($content));

        $this->metadata[$name] = $content;
    }

   public function add_js($js)
    {
        $this->js[$js] = $js;
    }

   public function add_css($css)
    {
        $this->css[$css] = $css;
    }

   public function render($view = null, $data = array(), $return = FALSE)
    {
        if(empty($view)){
          $view = $this->ci->router->class."/".$this->ci->router->method;
        }
        // Not include master view on ajax request
        if ($this->ci->input->is_ajax_request())
        {
            $this->ci->load->view($view, $data);
            return;
        }

        // Title
        if (empty($this->title))
        {
            $title = '';
        }
        else
        {
            $title = $this->title;
        }

        // Description
        $description = $this->description;

        // Metadata
        $metadata = array();
        foreach ($this->metadata as $name => $content)
        {
            if (strpos($name, 'og:') === 0)
            {
                $metadata[] = '<meta property="' . $name . '" content="' . $content . '">';
            }
            else
            {
                $metadata[] = '<meta name="' . $name . '" content="' . $content . '">';
            }
        }
        $metadata = implode('', $metadata);

        // Javascript
        $js = array();
        foreach ($this->js as $js_file)
        {
            $js[] = '<script src="' . assets_url('js/' . $js_file) . '"></script>';
        }
        $js = implode('', $js);

        // CSS
        $css = array();
        foreach ($this->css as $css_file)
        {
            $css[] = '<link rel="stylesheet" href="' . assets_url('css/' . $css_file) . '">';
        }
        $css = implode('', $css);

        $header = $this->ci->load->ext_view('public/themes/'.$this->theme.'/header', array(),TRUE);



        $footer = $this->ci->load->ext_view('public/themes/'.$this->theme.'/footer', array(), TRUE);
        $main_content = $this->ci->load->view($view, $data, TRUE);
        return $this->ci->load->ext_view('public/themes/'.$this->theme.'/index', array(
            'title' => $title,
            'description' => $description,
            'metadata' => $metadata,
            'header' => $header,
            'footer' => $footer,
            'main_content' => $main_content,
            'js' => $js,
            'css' => $css,
            'ga_id' => $this->ga_id,
        ) , FALSE);
    }
}

