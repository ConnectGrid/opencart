<?php
// Version
define('VERSION', '3.0.3.3');

// Configuration
define ('OPENCART_CONFIG_FILE', "{$_SERVER['DOCUMENT_ROOT']}/../opencart-config.php");
define ('OPENCART_ADMIN_CONFIG_FILE', "{$_SERVER['DOCUMENT_ROOT']}/../opencart-admin-config.php");

if (is_file(OPENCART_CONFIG_FILE)) {
	require_once OPENCART_CONFIG_FILE;
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');