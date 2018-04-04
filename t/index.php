<?php
/**
 * 微语
 * @copyright (c) Emlog All Rights Reserved
*/

require_once '../init.php';

define('TEMPLATE_PATH', TPLS_PATH.TEMPLATE_NAME.'/');//前台模板路径

$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

if (Option::get('istwitter') == 'n') {
    emMsg('抱歉，微语未开启前台访问！', BLOG_URL);
}

if ($action == 'cal') {
    Calendar::generate();
}

if ($action == '') {
	$user_cache = $CACHE->readCache('user');
    $options_cache = Option::getAll();
    extract($options_cache);
    
    $Twitter_Model = new Twitter_Model();
    $Navi_Model = new Navi_Model();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $tws = $Twitter_Model->getTwitters($page);
    $twnum = $Twitter_Model->getTwitterNum();
    $pageurl =  pagination($twnum, Option::get('index_twnum'), $page, BLOG_URL.'t/?page=');
    $avatar = empty($user_cache[UID]['avatar']) ? '../admin/views/app/img/avatar.jpg' : '../' . $user_cache[UID]['avatar'];


    $site_title = $Navi_Model->getNaviNameByType(Navi_Model::navitype_t) . ' - ' . $site_title;

    include View::getView('header');
    require_once View::getView('t');
    View::output();
}


