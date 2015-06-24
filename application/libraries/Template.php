<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Template {

    private $_ci;

    protected $brand_name = 'CodeIgniter Skeleton';
    protected $title_separator = ' - ';
    protected $ga_id = FALSE; // UA-XXXXX-X

    protected $layout = 'default';

    protected $title = FALSE;
    protected $description = FALSE;

    protected $metadata = array();

    protected $js = array();
    protected $css = array();

    function __construct()
    {
        $this->_ci =& get_instance();
    }

    public function set_layout($layout)
    {
        $this->layout = $layout;
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

   public function render($view, $data = array(), $return = FALSE)
    {
        // Not include master view on ajax request
        if ($this->_ci->input->is_ajax_request())
        {
            $this->_ci->load->view($view, $data);
            return;
        }

        // Title
        if (empty($this->title))
        {
            $title = $this->brand_name;
        }
        else
        {
            $title = $this->title . $this->title_separator . $this->brand_name;
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

        $header = $this->_ci->load->view('template/header', array(), TRUE);
        $footer = $this->_ci->load->view('template/footer', array(), TRUE);
        $main_content = $this->_ci->load->view($view, $data, TRUE);

        $body = $this->_ci->load->view('template/layout/' . $this->layout, array(
            'header' => $header,
            'footer' => $footer,
            'main_content' => $main_content,
        ), TRUE);

        return $this->_ci->load->view('template/base_view', array(
            'title' => $title,
            'description' => $description,
            'metadata' => $metadata,
            'js' => $js,
            'css' => $css,
            'body' => $body,
            'ga_id' => $this->ga_id,
        ), $return);
    }
}

