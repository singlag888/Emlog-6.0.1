<?php
/**
 * 后台全局项加载
 * @copyright (c) Emlog All Rights Reserved
 */

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/admin/views/');//后台当前模板路径


$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

$avatars = empty($user_cache[UID]['avatar']) ? './views/app/img/avatar.jpg' : '../'.$user_cache[UID]['avatar'];

$loginname =  $user_cache[UID]['name'];

function welcome(){
$h=date('G');
if ($h<11) echo '早上好';
else if ($h<13) echo '中午好';
else if ($h<17) echo '下午好';
else echo '晚上好';
}

function count_user_all(){
$db = Database::getInstance();
$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "user");
return $data['total'];
}
//清楚SESSION方法
function clearSession(){
	session_start();    
	session_unset();    
	session_destroy();  
}
//登录验证
if ($action == 'login') {
    $username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
    $password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
    $ispersis = isset($_POST['ispersis']) ? intval($_POST['ispersis']) : false;
    $img_code = Option::get('login_code') == 'y' && isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

    $loginAuthRet = LoginAuth::checkUser($username, $password, $img_code);
    
    if ($loginAuthRet === true) {
        LoginAuth::setAuthCookie($username, $ispersis);
        emDirect("./");
    } else{
        if(isset($_SESSION['code'])){
             unset($_SESSION['code']);
         }
        clearSession();
        LoginAuth::loginPage($loginAuthRet);
    }
}
//退出
if ($action == 'logout') {
    setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
    clearSession();
    emDirect("../");
}

if (ISLOGIN === false) {
    LoginAuth::loginPage();
}

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE == ROLE_WRITER && !in_array($request_uri, array('cache', 'write_log','admin_log','attachment','blogger','comment','index','save_log','faq'))) {
    emMsg('权限不足！','./');
}
