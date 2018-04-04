<?php
/**
 * 安装向导
 */
define('EMLOG_ROOT', dirname(__FILE__));
define('DEL_INSTALLER', 1);
require_once EMLOG_ROOT.'/include/lib/function.base.php';
header('Content-Type: text/html; charset=UTF-8');
doStripslashes();
$act = isset($_GET['action'])? $_GET['action'] : '';
if(!$act){
// 检测是否安装过
if (file_exists('./install/install.lock')) {
    emMsg('你已经安装过该系统，重新安装需要先删除install/install.lock 文件');
}
// 同意协议页面
if(@!isset($_GET['c']) || @$_GET['c']=='agreement'){
    require './install/agreement.html';
}
// 检测环境页面
if(@$_GET['c']=='test'){
    require './install/test.html';
}
// 创建数据库页面
if(@$_GET['c']=='create'){
    require './install/create.html';
}
}

// 安装成功页面

if($act == 'install' || $act == 'reinstall'){
$db_host = isset($_POST['hostname']) ? addslashes(trim($_POST['hostname'])) : '';
    $db_user = isset($_POST['dbuser']) ? addslashes(trim($_POST['dbuser'])) : '';
    $db_pw = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
    $db_name = isset($_POST['dbname']) ? addslashes(trim($_POST['dbname'])) : '';
    $db_prefix = isset($_POST['dbprefix']) ? addslashes(trim($_POST['dbprefix'])) : '';
    $admin = isset($_POST['admin']) ? addslashes(trim($_POST['admin'])) : '';
    $adminpw = isset($_POST['adminpw']) ? addslashes(trim($_POST['adminpw'])) : '';
    $adminpw2 = isset($_POST['adminpw2']) ? addslashes(trim($_POST['adminpw2'])) : '';
    $result = '';

    if($db_prefix == ''){
        emMsg('数据库表前缀不能为空!');
    }elseif(!preg_match("/^[\w_]+_$/",$db_prefix)){
        emMsg('数据库表前缀格式错误!');
    }elseif($admin == '' || $adminpw == ''){
        emMsg('登录名和密码不能为空!');
    }elseif(strlen($adminpw) < 6){
        emMsg('登录密码不得小于6位');
    }elseif($adminpw!=$adminpw2)	 {
        emMsg('两次输入的密码不一致');
    }

    //初始化数据库类
    define('DB_HOST',   $db_host);
    define('DB_USER',   $db_user);
    define('DB_PASSWD', $db_pw);
    define('DB_NAME',   $db_name);
    define('DB_PREFIX', $db_prefix);

    $DB = Database::getInstance();
    $CACHE = Cache::getInstance();
    if($act != 'reinstall' && $DB->num_rows($DB->query("SHOW TABLES LIKE '{$db_prefix}blog'")) == 1){
        echo <<<EOT
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
<title>EMLOG安装程序</title>
<link href="./admin/views/plugins/bootstrap-3.3.0/css/bootstrap.min.css" rel="stylesheet"/>
<link href="./admin/views/plugins/material-design-iconic-font-2.2.0/css/material-design-iconic-font.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="./install/css/install.css">
<script src="./admin/views/plugins/jquery.1.12.4.min.js"></script>
<script src="./admin/views/plugins/bootstrap-3.3.0/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="./install/js/html5shiv.min.js"></script>
<script type="text/javascript" src="./install/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="nav">
    <div class="inside">
        <p class="name">Emlog<span>安装向导</span></p>
        <ul class="schedule active">
            <li class="number">4</li>
            <li class="word">重新安装</li>
        </ul>
    </div>
</div>
<div id="out">
    <div class="inside">
        <div class="box create">
                <div class="row">
     <div class="col-xs-12 col-sm-6 col-md-8 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
<i class="zmdi zmdi-time-restore-setting"></i> 重新安装
                </div>
           <div class="panel-body">
           <form name="form1" method="post" action="install.php?action=reinstall">
    <input name="hostname" type="hidden" class="input" value="$db_host">
    <input name="dbuser" type="hidden" class="input" value="$db_user">
    <input name="password" type="hidden" class="input" value="$db_pw">
    <input name="dbname" type="hidden" class="input" value="$db_name">
    <input name="dbprefix" type="hidden" class="input" value="$db_prefix">
    <input name="admin" type="hidden" class="input" value="$admin">
    <input name="adminpw" type="hidden" class="input" value="$adminpw">
    <input name="adminpw2" type="hidden" class="input" value="$adminpw2">
<div class="form-group">
<p>
你的Emlog看起来已经安装过了,继续安装将会覆盖原有数据，确定要继续吗？
</p>
 </div>
                <p class="agree">
                    <a class="btn btn-primary" href="javascript:history.back(-1)" >上一步</a>
                    <input class="btn btn-success" type="submit" value="继续安装">
                </p>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
</body>
</html>
EOT;
        exit;
    }
    
    if(!is_writable('config.php')){
        emMsg('配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为可写');
    }
if(!is_writable(EMLOG_ROOT.'/content/cache')){
        emMsg('缓存文件不可写。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为可写');
    }
    $config = "<?php\n"
    ."//mysql database address\n"
    ."define('DB_HOST','$db_host');"
    ."\n//mysql database user\n"
    ."define('DB_USER','$db_user');"
    ."\n//database password\n"
    ."define('DB_PASSWD','$db_pw');"
    ."\n//database name\n"
    ."define('DB_NAME','$db_name');"
    ."\n//database prefix\n"
    ."define('DB_PREFIX','$db_prefix');"
    ."\n//auth key\n"
    ."define('AUTH_KEY','".getRandStr(32).md5($_SERVER['HTTP_USER_AGENT'])."');"
    ."\n//cookie name\n"
    ."define('AUTH_COOKIE_NAME','EM_AUTHCOOKIE_".getRandStr(32,false)."');"
    ."\n";

    $fp = @fopen('config.php', 'w');
    $fw = @fwrite($fp, $config);
    if (!$fw){
        emMsg('配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为可写');
    }
    fclose($fp);

    //密码加密存储
    $PHPASS = new PasswordHash(8, true);
    $adminpw = $PHPASS->HashPassword($adminpw);

    $dbcharset = 'utf8';
    $type = 'MYISAM';
    $table_charset_sql = $DB->getMysqlVersion() > '4.1' ? 'ENGINE='.$type.' DEFAULT CHARSET='.$dbcharset.';' : 'ENGINE='.$type.';';
    if ($DB->getMysqlVersion() > '4.1' ){
        $DB->query("ALTER DATABASE `{$db_name}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;", true);
    }

    $widgets = Option::getWidgetTitle();
    $sider_wg = Option::getDefWidget();

    $widget_title = serialize($widgets);
    $widgets = serialize($sider_wg);
    $white = addslashes('admin|\/content\/');
    define('BLOG_URL', realUrl());

    $sql = "
DROP TABLE IF EXISTS {$db_prefix}block;
CREATE TABLE {$db_prefix}block (
  id int(10) unsigned NOT NULL auto_increment,
  date int(10) NOT NULL default '0',
  serverip varchar(200) NOT NULL default '',
  attack_num int(10) NOT NULL default '0',
UNIQUE KEY serverip (serverip),
KEY block (id)
)".$table_charset_sql."
DROP TABLE IF EXISTS {$db_prefix}blog;
CREATE TABLE {$db_prefix}blog (
  gid int(10) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  date bigint(20) NOT NULL,
  content longtext NOT NULL,
  excerpt longtext NOT NULL,
  thumbs varchar(255) NOT NULL default '',
  alias VARCHAR(200) NOT NULL DEFAULT '',
  author int(10) NOT NULL default '1',
  sortid int(10) NOT NULL default '-1',
  copy int(10) NOT NULL default '-1',
  copyurl varchar(255) NOT NULL default '',
  type varchar(20) NOT NULL default 'blog',
  views int(10) unsigned NOT NULL default '0',
  comnum int(10) unsigned NOT NULL default '0',
  attnum int(10) unsigned NOT NULL default '0',
  top enum('n','y') NOT NULL default 'n',
  sortop enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  checked enum('n','y') NOT NULL default 'y',
  allow_remark enum('n','y') NOT NULL default 'y',
  password varchar(255) NOT NULL default '',
  template varchar(255) NOT NULL default '',
  tags text,
  PRIMARY KEY (gid),
  KEY author (author),
  KEY views (views),
  KEY comnum (comnum),
  KEY sortid (sortid),
  KEY top (top,date)
)".$table_charset_sql."
INSERT INTO {$db_prefix}blog (gid,title,date,content,excerpt,thumbs,author,sortid,copy,copyurl,views,comnum,attnum,top,sortop,hide,allow_remark,password,template,tags) VALUES (1, '欢迎使用Emlog', '".time()."', '恭喜您成功安装了Emlog，这是系统自动生成的演示文章。编辑或者删除它，然后开始您的创作吧！', '','', 1,1,1,'',0, 0, 0, 'n', 'n', 'n', 'y', '','',1);
DROP TABLE IF EXISTS {$db_prefix}attachment;
CREATE TABLE {$db_prefix}attachment (
  aid int(10) unsigned NOT NULL auto_increment,
  blogid int(10) unsigned NOT NULL default '0',
  filename varchar(255) NOT NULL default '',
  filesize int(10) NOT NULL default '0',
  filepath varchar(255) NOT NULL default '',
  addtime bigint(20) NOT NULL default '0',
  width int(10) NOT NULL default '0',
  height int(10) NOT NULL default '0',
  mimetype varchar(40) NOT NULL default '',
  thumfor int(10) NOT NULL default 0,
  PRIMARY KEY  (aid),
  KEY blogid (blogid)
)".$table_charset_sql."
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE {$db_prefix}comment (
  cid int(10) unsigned NOT NULL auto_increment,
  gid int(10) unsigned NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  date bigint(20) NOT NULL,
  poster varchar(20) NOT NULL default '',
  comment text NOT NULL,
  mail varchar(60) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  ip varchar(128) NOT NULL default '',
  hide enum('n','y') NOT NULL default 'n',
  useragent varchar(128) NOT NULL default '',
  PRIMARY KEY  (cid),
  KEY gid (gid),
  KEY date (date),
  KEY hide (hide)
)".$table_charset_sql."
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE {$db_prefix}options (
option_id INT( 11 ) UNSIGNED NOT NULL auto_increment,
option_name VARCHAR( 255 ) NOT NULL ,
option_value LONGTEXT NOT NULL ,
PRIMARY KEY (option_id),
KEY option_name (option_name)
)".$table_charset_sql."
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogname','点滴记忆');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('bloginfo','使用Emlog搭建的站点');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_title','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_description','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_key','emlog');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('log_title_style','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogurl','".BLOG_URL."');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('icp','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('footer_info','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_perpage_num','15');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_num','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_fulltext','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_lognum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_comnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_twnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newtwnum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_randlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_hotlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_subnum','20');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('nonce_templet','default');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_style','admin-default');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('tpl_sidenum','1');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_needchinese','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_interval',60);
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgravatar','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isthumbnail','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_maxsize','20480');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_type','rar,zip,gif,jpg,jpeg,png,txt,pdf,docx,doc,xls,xlsx');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_imgmaxw','420');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('att_imgmaxh','460');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_paging','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_pnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_order','newer');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('login_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('iscomment','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkcomment','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isurlrewrite','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias_html','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgzipenable','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isexcerpt','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('excerpt_subnum','300');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istwitter','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('timezone','Asia/Shanghai');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('active_plugins','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widget_title','$widget_title');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_widget','a:0:{}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets1','$widgets');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets4','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('detect_url','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_log','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_switch','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_post','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_get','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_cookie','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_referre','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_white_directory','".$white."');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('webscan_block_ip','0.0.0.0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('attacks','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('MAIL_SMTP','stmp.163.com');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('MAIL_PORT','25');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('MAIL_SENDEMAIL','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('MAIL_PASSWORD','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('MAIL_TOEMAIL','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('MAIL_SENDTYPE','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('SEND_MAIL','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('REPLY_MAIL','0');
DROP TABLE IF EXISTS {$db_prefix}link;
CREATE TABLE {$db_prefix}link (
  id int(10) unsigned NOT NULL auto_increment,
  sitename varchar(30) NOT NULL default '',
  siteurl varchar(75) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  sitepic varchar(255) NOT NULL default '',
  linksortid int(10) unsigned NOT NULL default '0',
  hide enum('n','y') NOT NULL default 'n',
  taxis int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$table_charset_sql."
INSERT INTO {$db_prefix}link (id, sitename, siteurl, description,sitepic,linksortid, taxis) VALUES (1, 'emlog', 'http://www.emlog.net', '官方主页','',1,0);
DROP TABLE IF EXISTS {$db_prefix}sortlink;
CREATE TABLE {$db_prefix}sortlink (
  linksort_id int(10) unsigned NOT NULL auto_increment,
  linksort_name varchar(255) NOT NULL default '',
  taxis int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (linksort_id)
)".$table_charset_sql."
INSERT INTO {$db_prefix}sortlink (linksort_id, linksort_name, taxis) VALUES (1, '默认分类', 0);
DROP TABLE IF EXISTS {$db_prefix}navi;
CREATE TABLE {$db_prefix}navi (
  id int(10) unsigned NOT NULL auto_increment,
  naviname varchar(30) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  newtab enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  taxis int(10) unsigned NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  isdefault enum('n','y') NOT NULL default 'n',
  type tinyint(3) unsigned NOT NULL default '0',
  type_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$table_charset_sql."
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (1, '首页', '', 1, 'y', 1);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (2, '微语', 't', 2, 'y', 2);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (3, '登录', 'admin', 3, 'y', 3);
DROP TABLE IF EXISTS {$db_prefix}tag;
CREATE TABLE {$db_prefix}tag (
  tid int(10) unsigned NOT NULL auto_increment,
  tagname varchar(60) NOT NULL default '',
  gid text NOT NULL,
  PRIMARY KEY  (tid),
  KEY tagname (tagname)
)".$table_charset_sql."
INSERT INTO {$db_prefix}tag (tid, tagname, gid) VALUES
(1, '默认', '1');
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE {$db_prefix}sort (
  sid int(10) unsigned NOT NULL auto_increment,
  sortname varchar(255) NOT NULL default '',
  alias VARCHAR(200) NOT NULL DEFAULT '',
  taxis int(10) unsigned NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  description text NOT NULL,
  template varchar(255) NOT NULL default '',
  PRIMARY KEY  (sid)
)".$table_charset_sql."
INSERT INTO {$db_prefix}sort (sid,sortname,alias, taxis, pid, description, template) VALUES
(1, '默认', 'default', 1, 0, '', '');
DROP TABLE IF EXISTS {$db_prefix}twitter;
CREATE TABLE {$db_prefix}twitter (
id INT NOT NULL AUTO_INCREMENT,
content text NOT NULL,
img varchar(200) DEFAULT NULL,
author int(10) NOT NULL default '1',
date bigint(20) NOT NULL,
PRIMARY KEY (id),
KEY author (author)
)".$table_charset_sql."
INSERT INTO {$db_prefix}twitter (id, content, img, author, date) VALUES (1, '使用微语记录您身边的新鲜事', '', 1, '".time()."');
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE {$db_prefix}user (
  uid int(10) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password varchar(64) NOT NULL default '',
  nickname varchar(20) NOT NULL default '',
  role varchar(60) NOT NULL default '',
  ischeck enum('n','y') NOT NULL default 'n',
  photo varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  website varchar(75) NOT NULL default '',
PRIMARY KEY  (uid),
KEY username (username)
)".$table_charset_sql."
INSERT INTO {$db_prefix}user (uid, username, password, role) VALUES (1,'$admin','".$adminpw."','admin');";


    $array_sql = preg_split("/;[\r\n]/", $sql);
    foreach($array_sql as $sql){
        $sql = trim($sql);
        if ($sql){
            $DB->query($sql);
        }
    }
    //重建缓存
    $CACHE->updateCache();
    @touch('./install/install.lock');

    $result .= "
        <p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">恭喜，安装成功！</p>
        <p>您的Emlog已经安装好了，现在可以开始您的创作了，就这么简单!</p>
        <p><b>用户名</b>：{$admin}</p>
        <p><b>密 码</b>：您刚才设定的密码</p>";
    if (DEL_INSTALLER === 1 && !@unlink('./install.php') || DEL_INSTALLER === 0) {
        $result .= '<p style="color:red;margin:10px 20px;">强烈建议:请手动删除根目录下安装文件：install.php和install目录</p> ';
    }
    $result .= "<p style=\"text-align:right;\"><a href=\"./\">访问首页</a> | <a href=\"./admin/\">登录后台</a></p>";
    emMsg($result, 'none');


}