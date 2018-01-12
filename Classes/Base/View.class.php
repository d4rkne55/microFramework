<?php

/**
 * Basic class for templating
 */
class View
{
    protected $templateDir;
    public $baseTemplate;
    private $subOutput;
    private $vars = array();


    public function __construct($templateDir = 'templates/') {
        if (substr($templateDir, -1) != '/') {
            $templateDir .= '/';
        }
        $this->templateDir = $templateDir;

        if (!file_exists($this->templateDir)) {
            throw new Exception("View: Template directory doesn't exist.");
        }
    }

    /**
     * Renders template with passed variables
     *
     * @param string $template  filename of the template to render
     * @param array  $vars      variables to pass to the template, optional
     * @throws Exception        when template not found
     */
    public function render($template, $vars = array()) {
        $this->vars = $vars;

        if (file_exists($this->templateDir . $template)) {
            ob_start();
            include($this->templateDir . $template);

            $this->subOutput = ob_get_clean();

            if ($this->baseTemplate) {
                if (file_exists($this->templateDir . $this->baseTemplate)) {
                    include($this->templateDir . $this->baseTemplate);
                } else {
                    throw new Exception('View: Template not found!');
                }
            } else {
                echo $this->subOutput;
            }
        } else {
            throw new Exception('View: Template not found!');
        }
    }

    public function renderSub() {
        return $this->subOutput;
    }

    public function __get($var) {
        if (isset($this->vars[$var])) {
            return $this->vars[$var];
        }

        return null;
    }
}