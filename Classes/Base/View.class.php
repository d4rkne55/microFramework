<?php

/**
 * Basic class for templating
 */
// TODO: method for getting a template's markup without including it
// TODO: some handling for using base templates (?)
class View
{
    protected $templateDir;
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
            include($this->templateDir . $template);
        } else {
            throw new Exception('View: Template not found!');
        }
    }

    public function __get($var) {
        if (isset($this->vars[$var])) {
            return $this->vars[$var];
        }

        return null;
    }
}