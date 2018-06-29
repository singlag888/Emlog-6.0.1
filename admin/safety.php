<?php
/**
 * 站点防护
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';$options_cache = $CACHE->updateCache('options');

if ($action == '') {
      $options_cache = $CACHE->readCache('options');
      extract($options_cache);
      $DB = Database::getInstance();
       $webscan_switch = $webscan_switch == '1' ? 'checked="checked"' : '';
       $webscan_post = $webscan_post == '1' ? 'checked="checked"' : '';
       $webscan_get = $webscan_get == '1' ? 'checked="checked"' : '';
       $webscan_cookie = $webscan_cookie == '1' ? 'checked="checked"' : '';
       $webscan_referre = $webscan_referre == '1' ? 'checked="checked"' : '';
       

       include View::getView('header');
	require_once(View::getView('safety'));
	include View::getView('footer');
	View::output();
}

if ($action == 'set') {
    LoginAuth::checkToken();
    	$getData = array(
  'webscan_switch' => isset($_POST['webscan_switch']) ? addslashes($_POST['webscan_switch']) : '0',
    'webscan_post' => isset($_POST['webscan_post']) ? addslashes($_POST['webscan_post']) : '0',
      'webscan_get' => isset($_POST['webscan_get']) ? addslashes($_POST['webscan_get']) : '0',
        'webscan_cookie' => isset($_POST['webscan_cookie']) ? addslashes($_POST['webscan_cookie']) : '0',
          'webscan_referre' => isset($_POST['webscan_referre']) ? addslashes($_POST['webscan_referre']) : '0',
    'webscan_white_directory' => isset($_POST['webscan_white_directory']) ? addslashes($_POST['webscan_white_directory']) : '',
        'webscan_block_ip' => isset($_POST['webscan_block_ip']) ? addslashes($_POST['webscan_block_ip']) : '',
         'attacks' => isset($_POST['attacks']) ? addslashes($_POST['attacks']) : '',
 );
  foreach ($getData as $key => $val) {
		Option::updateOption($key, $val);   }
  
   $CACHE->updateCache('options');
   emDirect("./safety.php?activated=1");
}



if ($action == 'rest') {
    LoginAuth::checkToken();
    $db = Database::getInstance();
    $row=$db->once_fetch_array("SELECT * FROM `".DB_NAME."`.`".DB_PREFIX."options` WHERE `option_name` LIKE 'webscan_log'");
    $db->query("UPDATE `".DB_NAME."`.`".DB_PREFIX."options` SET option_value = '0' WHERE `option_name` LIKE 'webscan_log'");
  $CACHE->updateCache();
  emDirect("./safety.php?rested=1");
}



//清空数据
if ($action == 'dell_all') {
LoginAuth::checkToken();
 $DB = Database::getInstance();
$DB->query("TRUNCATE TABLE ".DB_PREFIX."block");
$CACHE->updateCache();
  emDirect("./safety.php?dell=1");	
}

