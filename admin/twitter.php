<?php
/**
 * 微语
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Twitter_Model = new Twitter_Model();
 $uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
 
if ($action == '') {         $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$tws = $Twitter_Model->getTwitters($page,1);
	$twnum = $Twitter_Model->getTwitterNum(1);
	$pageurl =  pagination($twnum, Option::get('admin_perpage_num'), $page, 'twitter.php?page=');
	$avatar = empty($user_cache[UID]['avatar']) ? './views/app/img/avatar.jpg' : '../' . $user_cache[UID]['avatar'];

	include View::getView('header');
	require_once(View::getView('twitter'));
	include View::getView('footer');
	View::output();
}
// 发布微语.
if ($action == 'post') {
	$t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';
	$img = isset($_POST['img']) ? addslashes(trim($_POST['img'])) : '';

    LoginAuth::checkToken();

	if ($img && !$t) {
		$t = '分享图片';
	}

	if (!$t) {
		emDirect("twitter.php?error_a=1");
	}

	$tdata = array('content' => $Twitter_Model->formatTwitter($t),
			'author' => UID,
			'date' => time(),
			'img' => str_replace('../', '', $img)
	);

	$twid = $Twitter_Model->addTwitter($tdata);
	$CACHE->updateCache(array('sta','newtw'));
	doAction('post_twitter', $t, $twid);
	emDirect("twitter.php?active_t=1");
}
// 删除微语.
if ($action == 'del') {
    LoginAuth::checkToken();
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	$Twitter_Model->delTwitter($id);
	$CACHE->updateCache(array('sta','newtw'));
	emDirect("twitter.php?active_del=1");
}

