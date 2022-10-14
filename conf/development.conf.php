<?php

$config = array();

// Base URL of the web app. No trailing slash please!
$config["baseUrl"] = "";

// Debug mode
$config["debug"] = true;

// DATABASE
// Database host
$config["db"]["host"] = "";
$config["db"]["port"] = "";
$config["db"]["user"] = "";
$config["db"]["pass"] = "";

$config["email"]["from"] = "";
$config["email"]["smtp"]["host"] = "localhost";
$config["email"]["smtp"]["user"] = "";
$config["email"]["smtp"]["pass"] = "";

return $config;
