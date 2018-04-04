<?php
/**
 * 全局项加载
 * @copyright (c) Emlog All Rights Reserved
 */

error_reporting(E_ALL);
ob_start();
header('Content-Type: text/html; charset=UTF-8');

define('EMLOG_ROOT', str_replace('\\','/',dirname(__FILE__)));

if (extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');
}

require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/include/lib/function.base.php';


//站点防护开关(1为开启，0关闭)
$webscan_switch= Option::get('webscan_switch');
$webscan_post= Option::get('webscan_post');
$webscan_get= Option::get('webscan_get');
$webscan_cookie= Option::get('webscan_cookie');
$webscan_referre= Option::get('webscan_referre');
$webscan_white_directory=Option::get('webscan_white_directory');
define('webscan_attack',	Option::get('attacks'));
require_once EMLOG_ROOT.'/include/lib/webscan.php';

blockIP_check();

doStripslashes();


$CACHE = Cache::getInstance();

$userData = array();

define('ISLOGIN',	LoginAuth::isLogin());

//站点时区
date_default_timezone_set(Option::get('timezone'));

//评论邮件通知配置
require_once EMLOG_ROOT.'/include/lib/phpmailer.php';
require_once EMLOG_ROOT.'/include/lib/smtp.php';
define('MAIL_SMTP', Option::get("MAIL_SMTP")); 
define('MAIL_PORT', Option::get('MAIL_PORT')); //smtp端口
define('MAIL_SENDEMAIL', Option::get('MAIL_SENDEMAIL')); //发信邮箱
define('MAIL_PASSWORD',Option::get('MAIL_PASSWORD')); //发信密码
define('MAIL_TOEMAIL', Option::get('MAIL_TOEMAIL')); //收信邮箱
define('MAIL_SENDTYPE', Option::get('MAIL_SENDTYPE'));
define('SEND_MAIL', Option::get('SEND_MAIL'));
define('REPLY_MAIL', Option::get('REPLY_MAIL'));

//用户组:admin管理员, writer联合撰写人, visitor访客
define('ROLE_ADMIN', 'admin');
define('ROLE_WRITER', 'writer');
define('ROLE_VISITOR', 'visitor');
//用户角色
define('ROLE', ISLOGIN === true ? $userData['role'] : ROLE_VISITOR);
//用户ID
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//站点固定地址
define('BLOG_URL', Option::get('blogurl'));
//模板库地址
define('TPLS_URL', BLOG_URL.'content/templates/');
//模板库路径
define('TPLS_PATH', EMLOG_ROOT.'/content/templates/');
//解决前台多域名ajax跨域
define('DYNAMIC_BLOGURL', Option::get("blogurl"));
//前台模板URL
session_start();
if(isset($_GET['theme'])){
$theme = $_GET['theme']=='reset' ? Option::get('nonce_templet') : $_GET['theme'];
$_SESSION['theme']=$theme;
}elseif(isset($_SESSION['theme'])){
$theme=$_SESSION['theme'];
}else{
    $theme='';
}
if($theme==''){
    define('TEMPLATE_NAME', Option::get('nonce_templet'));
}else{
    define('TEMPLATE_NAME', $theme);
}
define('TEMPLATE_URL', TPLS_URL.TEMPLATE_NAME.'/');

$active_plugins = Option::get('active_plugins');
$emHooks = array();
if ($active_plugins && is_array($active_plugins)) {
	foreach($active_plugins as $plugin) {
		if(true === checkPlugin($plugin)) {
			include_once(EMLOG_ROOT . '/content/plugins/' . $plugin);
		}
	}
}
