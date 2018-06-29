<?php
/**
 * 在线商店
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$site_store_data = base64_encode('https://cn.ibossnewyork.com/wp-content/uploads/data/app/data.zip');
	include View::getView('header');
	require_once(View::getView('store'));
	include View::getView('footer');
	View::output();
}

if ($action == 'instpl') {
        LoginAuth::checkToken();
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = 'tpl';
	$source_typename = '模板';
	$source_typeurl = '<a href="template.php">查看模板</a>';
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');
}

if ($action == 'insplu') {
       LoginAuth::checkToken();
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$source_type = 'plu';
	$source_typename = '插件';
	$source_typeurl = '<a href="plugin.php">查看插件</a>';
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');
}

if ($action == 'insupdata') {
       LoginAuth::checkToken();
	$source = base64_decode(isset($_GET['source']) ? trim($_GET['source']) : '');
	$source_type = 'data';
	$source_typename = '商店数据';
	$source_typeurl = '<a href="javascript:" onclick="self.location=document.referrer;">返回上一页</a>';
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');
}


if ($action == 'update' && ROLE == ROLE_ADMIN) {
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$upsql = isset($_GET['upsql']) ? trim($_GET['upsql']) : '';
	$source_type = 'upd';
	$source_typename = '系统升级';
	$source_typeurl = '<a href="./">刷新返回首页</a>';
	
     if(!empty($_GET['upsql'])){
     if(ROLE!=ROLE_ADMIN){
        emMsg("没权限访问");
       }
	$DB = Database::getInstance();
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE `" . DB_NAME . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
	$temp_file = emFecthFile($upsql);
	if (!$temp_file) {
		 exit('error_down');
	}
	$sql = file($temp_file);
	@unlink($temp_file);
	array_unshift($sql,$setchar);
	$query = '';
	foreach ($sql as $value) {
		if (!$value || $value[0]=='#') {
			continue;
		}
	$value = str_replace("{db_prefix}", DB_PREFIX, trim($value));
if (preg_match("/\;$/i", $value)) {
			$query .= $value;
			$DB->query($query);
			$query = '';
		} else{
			$query .= $value;
		}
	}
	$CACHE->updateCache();
	}
	include View::getView('header');
	require_once(View::getView('store_install'));
	include View::getView('footer');
}




if ($action == 'addon') {
if(ROLE!=ROLE_ADMIN){
        emMsg("没权限访问");
    }
    $source = $_GET['source'];
    $source_type = $_GET['type'];
    
    if (empty($source)) {
		exit('error');
	}
$temp_file = emFecthFile($source);

if (!$temp_file) {
		 exit('error_down');
	}
if($source_type == 'tpl'){
$unzip_path = '../content/templates/';
}
if($source_type == 'plu'){
$unzip_path = '../content/plugins/';
}
if($source_type == 'upd'){
$unzip_path = '../';
}
if($source_type == 'data'){
$unzip_path = '../admin/views/data';
}
$ret = emUnZip($temp_file, $unzip_path, $source_type);

@unlink($temp_file);
	switch ($ret) {
		case 0:
			exit('succ');
			break;
		case 1:
		case 2:
			exit('error_dir');
			break;
		case 3:
			exit('error_zip');
			break;
	}
}
