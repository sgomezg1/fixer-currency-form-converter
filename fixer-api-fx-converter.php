<?php

/**
 * Plugin Name: Fixer API FX Converter
 * Plugin URI: https://ilbkgroup.com/
 * Description: FX converter using GBR as basis currency. This works like a contact form.
 * Version: 1.0
 * Author: Sebastián Gómez Gutiérrez
 * Author URI: https://www.linkedin.com/in/sebastian-gomez-7b2966105/
 */
require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');
require_once(plugin_dir_path(__FILE__) . '/src/loadExternalLibraries.php');
require_once(plugin_dir_path(__FILE__) . '/src/loadView.php');
define("PLUGINPATH", plugin_dir_url("") . "fixer-api-fx-converter");
define("CREDENTIALS", require_once(plugin_dir_path(__FILE__) . '/src/credentials.php'));
define("APIURL", "https://api.apilayer.com/fixer");
/** Load external CSS and JS */

$thirdPartyLoader = new loadCssJsLibraries();
$viewLoader = new loadView();
