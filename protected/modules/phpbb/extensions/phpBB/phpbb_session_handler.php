<?php
if(!defined('IN_PHPBB')) define('IN_PHPBB', true);
$phpbb_root_path = "path/to/forum";//absoulute physical path of the phpbb 3 forum
$phpEx = "php";//phpbb used extensions
require_once($phpbb_root_path."common.".$phpEx);
// Start session management
$user->session_begin();
// End session management
?>