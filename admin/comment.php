<?php
/**
 * 评论管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

$Comment_Model = new Comment_Model();

if ($action == '') {
    $blogId = isset($_GET['gid']) ? intval($_GET['gid']) : null;
    $hide = isset($_GET['hide']) ? addslashes($_GET['hide']) : '';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $addUrl_1 = $blogId ? "gid={$blogId}&" : '';
    $addUrl_2 = $hide ? "hide=$hide&" : '';
    $addUrl = $addUrl_1.$addUrl_2;

    $comment = $Comment_Model->getComments(1, $blogId, $hide, $page);
    $cmnum = $Comment_Model->getCommentNum($blogId, $hide);
    $hideCommNum = $Comment_Model->getCommentNum($blogId, 'y');
    $pageurl =  pagination($cmnum, Option::get('admin_perpage_num'), $page, "comment.php?{$addUrl}page=");

   
    include View::getView('header');
    require_once(View::getView('comment'));
    include View::getView('footer');
    View::output();
}

if ($action== 'del') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';

    LoginAuth::checkToken();

    $Comment_Model->delComment($id);
    $CACHE->updateCache(array('sta','comment'));
    emDirect("./comment.php?active_del=1");
}

if ($action== 'delbyip') {
    LoginAuth::checkToken();
    if (ROLE != ROLE_ADMIN) {
        emMsg('权限不足！', './');
    }
    $ip = isset($_GET['ip']) ? $_GET['ip'] : '';
    $Comment_Model->delCommentByIp($ip);
    $CACHE->updateCache(array('sta','comment'));
    emDirect("./comment.php?active_del=1");
}

if ($action=='hide') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';
    $Comment_Model->hideComment($id);
    $CACHE->updateCache(array('sta','comment'));
    emDirect("./comment.php?active_hide=1");
}
if ($action=='show') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';
    $Comment_Model->showComment($id);
    $CACHE->updateCache(array('sta','comment'));
    emDirect("./comment.php?active_show=1");
}

if ($action== 'admin_all_coms') {
    $operate = isset($_POST['operate']) ? $_POST['operate'] : '';
    $comments = isset($_POST['com']) ? array_map('intval', $_POST['com']) : array();

    if ($operate == '') {
        emDirect("./comment.php?error_b=1");
    }
    if ($comments == '') {
        emDirect("./comment.php?error_a=1");
    }
    if ($operate == 'del') {
        $Comment_Model->batchComment('delcom', $comments);
        $CACHE->updateCache(array('sta','comment'));
        emDirect("./comment.php?active_del=1");
    }
    if ($operate == 'hide') {
        $Comment_Model->batchComment('hidecom', $comments);
        $CACHE->updateCache(array('sta','comment'));
        emDirect("./comment.php?active_hide=1");
    }
    if ($operate == 'pub') {
        $Comment_Model->batchComment('showcom', $comments);
        $CACHE->updateCache(array('sta', 'comment'));
        emDirect("./comment.php?active_show=1");
    }
}

if ($action== 'reply_comment') {
    include View::getView('header');
    $commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
    $commentArray = $Comment_Model->getOneComment($commentId);
    extract($commentArray);
    require_once(View::getView('comment_reply'));
    include View::getView('footer');
    View::output();
}

if ($action== 'edit_comment') {
    $commentId = isset($_GET['cid']) ? intval($_GET['cid']) : '';
    doAction('comment_reply', $commentId, $reply);
    $commentArray = $Comment_Model->getOneComment($commentId, FALSE);
    if (!$commentArray) {
        emMsg('不存在该评论！', './comment.php');
    }
    extract($commentArray);


    include View::getView('header');
    require_once(View::getView('comment_edit'));
    include View::getView('footer');
    View::output();
}

if ($action=='doreply') {
    $reply = isset($_POST['reply']) ? trim(addslashes($_POST['reply'])) : '';
    $commentId = isset($_POST['cid']) ? intval($_POST['cid']) : '';
    $blogId = isset($_POST['gid']) ? intval($_POST['gid']) : '';
    $hide = isset($_POST['hide']) ? addslashes($_POST['hide']) : 'n';
    	if(REPLY_MAIL == 'Y')
	{
		$DB = Option::EMLOG_VERSION >= '5.3.0' ? Database::getInstance() : MySql::getInstance();
		$blogname = Option::get('blogname');
		$Comment_Model = new Comment_Model();
		$commentArray = $Comment_Model->getOneComment($commentId);
		extract($commentArray);
		$subject="您在【{$blogname}】发表的评论收到了回复";
		if(strpos($mail, '@139.com') === false)
		{
			$emBlog = new Log_Model();
			$logData = $emBlog->getOneLogForHome($gid);
			$log_title = $logData['log_title'];
			$content =  '<style type="text/css">.qmbox{margin:0;padding:0;font-family:微软雅黑;background-color:#fff}.qmbox a{text-decoration:none;}.qmbox .box{position:relative;width:780px;padding:0;margin:0 auto;border:1px solid #ccc;font-size:13px;color:#333;}.qmbox .header{width:100%;padding-top:50px;}.qmbox .logo{float:right;padding-right:50px;}.qmbox .clear{clear:both;}.qmbox .content{width:585px;padding:0 50px;}
.qmbox .content p{line-height:40px;word-break:break-all;}.qmbox .content ul{padding-left:40px;}
.qmbox .xiugai{height:50px;line-height:30px;font-size:16px;}.qmbox .xiugai a{color:#0099ff;}
.qmbox .fuzhi{word-break:break-all;color:#b0b0b0;}.qmbox .table{border:1px solid #ccc;border-left:0;border-top:0;border-collapse:collapse;}
.qmbox .table td{border:1px solid #ccc;border-right:0;border-bottom:0;padding:6px;min-width:160px;}.qmbox .gray{background:#f5f5f5;}
.qmbox .no_indent{font-weight:bold;height:40px;line-height:40px;}.qmbox .no_after{height:40px;line-height:40px; text-align:right;font-weight:bold}
.qmbox .btnn{padding:50px 0 0 0;font-weight:bold}.qmbox .btnn a{padding-right:20px;text-decoration:none !important;color:#000;}.qmbox .need{background:#fa9d00;}
.qmbox .noneed{background:#3784e0;}.qmbox .footer{width:100%;height:10px;padding-top:20px;) repeat-x left bottom;}</style><div class="qmbox"><div class="box"><div class="header"></div><div class="content"><p class="no_indent">'.$poster.'您好，您之前在《'.$log_title.'》发表的的评论：</p><p style="line-height:25px;padding:10px;background:#EDECF2;border-radius:4px;">'.$comment.'</p><p class="no_indent">'.$userData['username'].'给您的回复：</p><p style="line-height:25px;padding:10px;background:#5C96BE;border-radius:4px;color:#fff;">'.$reply.'</p> <p>时间：'.date("Y-m-d",time()).'</p>
<p>状态：通过</p>
<p>本邮件为'.$blogname.'自动发送，请勿直接回复.</p> <table cellspacing="0" class="table">	</table> <div class="btnn"><a href="'.Url::log($gid).'#'.$cid.'" target="_blank">查看该文章</a></div> </div><div class="footer clear"></div></div></div>';
		}else{
			$content = $reply;
		}
		if($mail != '')	sendmail_do(MAIL_SMTP, MAIL_PORT, MAIL_SENDEMAIL, MAIL_PASSWORD, $mail, $subject, $content, $blogname);
	}else{
		return;
	}

    if ($reply == '') {
        emDirect("./comment.php?error_c=1");
    }
    if (strlen($reply) > 2000) {
        emDirect("./comment.php?error_d=1");
    }
    if (isset($_POST['pub_it'])) {
        $Comment_Model->showComment($commentId);
        $hide = 'n';
    }
    $Comment_Model->replyComment($blogId, $commentId, $reply, $hide);
    $CACHE->updateCache('comment');
    $CACHE->updateCache('sta');
    doAction('comment_reply', $commentId, $reply);
    emDirect("./comment.php?active_rep=1");
}

if ($action=='doedit') {
    $name = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
    $mail = isset($_POST['mail']) ? addslashes(trim($_POST['mail'])) : '';
    $url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
    $comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
    $commentId = isset($_POST['cid']) ? intval($_POST['cid']) : '';

    if ($comment == '') {
        emDirect("./comment.php?error_e=1");
    }
    if (strlen($comment) > 2000) {
        emDirect("./comment.php?error_d=1");
    }

    $commentData = array(
        'poster' => $name,
        'mail' => $mail,
        'url' => $url,
        'comment' => $comment,
    );

    $Comment_Model->updateComment($commentData, $commentId);
    $CACHE->updateCache('comment');
    emDirect("./comment.php?active_edit=1");
}
