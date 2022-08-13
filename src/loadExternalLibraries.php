<?php

class loadCssJsLibraries
{
    public function __construct()
    {
        add_action("init", array($this, "loadLibraries"));
    }
    public function loadCss()
    {
        wp_register_style("main-css", PLUGINPATH . "/css/styles.css");
        wp_enqueue_style("main-css");
    }

    public function loadScripts()
    {
        wp_enqueue_script('query', PLUGINPATH . "/js/query.js");
        wp_register_script("axios", PLUGINPATH . "/js/axios.js");
        wp_register_script("jquery-validate", PLUGINPATH . "/js/jquery-validate.js");
        wp_register_script("jquery-validate-additional-methods", PLUGINPATH . "/js/jquery-validate-additional-methods.js");
        wp_register_script("debounce", "https://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js");
        wp_register_script("variables", PLUGINPATH . "/js/variables.js");
        wp_register_script("logic", PLUGINPATH . "/js/logic.js", array("query"));

        wp_enqueue_script("query");
        wp_enqueue_script("axios");
        wp_enqueue_script("jquery-validate");
        wp_enqueue_script("jquery-validate-additional-methods");
        wp_enqueue_script("debounce");
        wp_enqueue_script("variables");
        wp_enqueue_script("logic");
    }

    public function loadLibraries()
    {
        $this->loadCss();
        $this->loadScripts();
    }
}
