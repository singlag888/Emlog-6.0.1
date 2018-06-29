<?php
/**
 * 管理中心
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';


//最近回复
function newcomm(){
	global $CACHE;
	$db=Database::getInstance();
        $sql = "SELECT cid,gid,date,poster,mail,comment FROM " . DB_PREFIX . "comment WHERE hide='n' ORDER BY date DESC LIMIT 0,5";
        $ret= $db->query($sql);
        if($db->num_rows($ret) != 0){
        while($row = $db->fetch_array($ret)){
echo "<li> <span> ".date("Y-m-d",$row['date'])." </span> <a href=\"".Url::log($row['gid'])."#comment-".$row["cid"]."\">".$row['poster'].":".htmlspecialchars ($row['comment'])."</a></li>";        
}   
}else{
echo "<li><a>暂时没有回复</a></li>";
}            
}

//最近一语
function newt(){
	global $CACHE;
	$db=Database::getInstance();
        $sql = "SELECT date,author,img,content FROM " . DB_PREFIX . "twitter  ORDER BY date DESC LIMIT 0,5";
        $ret= $db->query($sql);
        if($db->num_rows($ret) != 0){
        while($row = $db->fetch_array($ret)){
echo "<li> <span>".date("Y-m-d",$row['date'])."</span> <a href=\"../t\" target=\"_blank\">". emoFormat($row['content'])."</a></li>";        
}                
}else{
echo "<li><a href=\"./twitter.php\">博主不知要说啥,快去说说</a></li>";
}            
}


if ($action == '') {
	$avatar = empty($user_cache[UID]['avatar']) ? './views/app/img/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
	$name =  $user_cache[UID]['name'];

	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$DB = Database::getInstance();
	$mysql_ver = $DB->getMysqlVersion();
	$php_ver = PHP_VERSION;
	$uploadfile_maxsize = ini_get('upload_max_filesize');
	$safe_mode = ini_get('safe_mode');

	if (function_exists("imagecreate")) {
		if (function_exists('gd_info')) {
			$ver_info = gd_info();
			$gd_ver = $ver_info['GD Version'];
		} else{
			$gd_ver = '支持';
		}
	} else{
		$gd_ver = '不支持';
	}

       include View::getView('header');
	require_once(View::getView('index'));
	include View::getView('footer');
	View::output();
}


if ($action == 'usestyle') {
    LoginAuth::checkToken();
    $styleName = isset($_GET['style']) ? addslashes($_GET['style']) : '';
  Option::updateOption('admin_style', $styleName);
   $CACHE->updateCache('options');
   emDirect("index.php?activated=1");
}


//phpinfo()
if ($action == 'phpinfo') {
if (ROLE == ROLE_ADMIN){
	@phpinfo() OR emMsg("phpinfo函数被禁用!");
}else{
   emMsg('权限不足！','./');
}
}
