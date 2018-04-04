<?php
/**
 * 发表评论
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Comment_Controller {
    function addComment($params) {
        $name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
        $content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
        $mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
        $url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
        $imgcode = isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';
        $blogId = isset($_POST['gid']) ? intval($_POST['gid']) : -1;
        $pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
        
       
 

if($_POST['send']=='y') {     
if(SEND_MAIL == 'Y' || REPLY_MAIL == 'Y')
	{
$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
		$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
		$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
		$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
		$gid = isset($_POST['gid']) ? intval($_POST['gid']) : (isset($_GET['gid']) ? intval($_GET['gid']) : -1);
		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
		$http_referer = empty($_SERVER['HTTP_REFERER']) ? BLOG_URL : $_SERVER['HTTP_REFERER'];

		$blogname = Option::get('blogname');
		$Log_Model = new Log_Model();
		$logData = $Log_Model->getOneLogForHome($gid);
		$log_title = $logData['log_title'];
		$subject = "文章《{$log_title}》收到了新的评论";
  if(!empty($commail)){$commail = $commail;}else{$commail = '未填写';};
  if(!empty($comurl)){$comurl = $comurl;}else{$comurl = '未填写';};
		if(strpos(MAIL_TOEMAIL, '@139.com') === false)
		{
			$comment = '<style type="text/css">.qmbox{margin:0;padding:0;font-family:微软雅黑;background-color:#fff}.qmbox a{text-decoration:none;}.qmbox .box{position:relative;width:780px;padding:0;margin:0 auto;border:1px solid #ccc;font-size:13px;color:#333;}.qmbox .header{width:100%;padding-top:50px;}.qmbox .logo{float:right;padding-right:50px;}.qmbox .clear{clear:both;}.qmbox .content{width:585px;padding:0 50px;}
.qmbox .content p{line-height:40px;word-break:break-all;}.qmbox .content ul{padding-left:40px;}
.qmbox .xiugai{height:50px;line-height:30px;font-size:16px;}.qmbox .xiugai a{color:#0099ff;}
.qmbox .fuzhi{word-break:break-all;color:#b0b0b0;}.qmbox .table{border:1px solid #ccc;border-left:0;border-top:0;border-collapse:collapse;}
.qmbox .table td{border:1px solid #ccc;border-right:0;border-bottom:0;padding:6px;min-width:160px;}.qmbox .gray{background:#f5f5f5;}
.qmbox .no_indent{font-weight:bold;height:40px;line-height:40px;color:#737171}.qmbox .no_indent a{text-decoration:none !important;color:#737171}.qmbox .no_indent span{padding-right:20px;}.qmbox .no_after{height:40px;line-height:40px; text-align:right;font-weight:bold}
.qmbox .btnn{padding:50px 0 0 0;font-weight:bold}.qmbox .btnn a{padding-right:20px;text-decoration:none !important;color:#000;}.qmbox .need{background:#fa9d00;}
.qmbox .noneed{background:#3784e0;}.qmbox .footer{width:100%;height:10px;padding-top:20px;}</style><div class="qmbox"><div class="box"><div class="header"></div><div class="content"><p class="no_indent" style="color:#383838">文章《'.$log_title.'》最新评论内容：</p><p style="line-height:25px;padding:10px;background:#5C96BE;border-radius:4px;color:#fff;">'.$comment.'</p
>
<p class="no_indent"><span>评论作者：'.$comname.'</span></p>
<p>时间：'.date("Y-m-d",time()).'</p>
<p>状态：通过</p>
<p>本邮件为'.$blogname.'自动发送，请勿直接回复</p>
<table cellspacing="0" class="table">	</table><div class="btnn"><a href="'.Url::log($gid).'" target="_blank">查看该文章</a></div></div><div class="footer clear"></div></div></div>';
		}else{
			$comment = $comment;
		}
		
		
		if(SEND_MAIL == 'Y')
		{
		
		if(ROLE == 'visitor') 
		sendmail_do(MAIL_SMTP, MAIL_PORT, MAIL_SENDEMAIL, MAIL_PASSWORD, MAIL_TOEMAIL, $subject, $comment, $blogname);
		}
		
		if(REPLY_MAIL == 'Y')
		{
			if($pid > 0)
			{
				$DB = Option::EMLOG_VERSION >= '5.3.0' ? Database::getInstance() : MySql::getInstance();
				$Comment_Model = new Comment_Model();
				$pinfo = $Comment_Model->getOneComment($pid);
		$custom=empty($comname) ? '博主':$comname;
				if(!empty($pinfo['mail']))
				{
					$subject = "您在【{$blogname}】发表的评论收到了回复";
					$reply = '<style type="text/css">.qmbox{margin:0;padding:0;font-family:微软雅黑;background-color:#fff}.qmbox a{text-decoration:none;}.qmbox .box{position:relative;width:780px;padding:0;margin:0 auto;border:1px solid #ccc;font-size:13px;color:#333;}.qmbox .header{width:100%;padding-top:50px;}.qmbox .logo{float:right;padding-right:50px;}.qmbox .clear{clear:both;}.qmbox .content{width:585px;padding:0 50px;}
.qmbox .content p{line-height:40px;word-break:break-all;}.qmbox .content ul{padding-left:40px;}
.qmbox .xiugai{height:50px;line-height:30px;font-size:16px;}.qmbox .xiugai a{color:#0099ff;}
.qmbox .fuzhi{word-break:break-all;color:#b0b0b0;}.qmbox .table{border:1px solid #ccc;border-left:0;border-top:0;border-collapse:collapse;}
.qmbox .table td{border:1px solid #ccc;border-right:0;border-bottom:0;padding:6px;min-width:160px;}.qmbox .gray{background:#f5f5f5;}
.qmbox .no_indent{font-weight:bold;height:40px;line-height:40px;}.qmbox .no_after{height:40px;line-height:40px; text-align:right;font-weight:bold}
.qmbox .btnn{padding:50px 0 0 0;font-weight:bold}.qmbox .btnn a{padding-right:20px;text-decoration:none !important;color:#000;}.qmbox .need{background:#fa9d00;}
.qmbox .noneed{background:#3784e0;}.qmbox .footer{width:100%;height:10px;padding-top:20px;}</style><div class="qmbox"><div class="box"><div class="header"></div><div class="content"><p class="no_indent">'.$pinfo['poster'].' 您好，您之前在《'.$log_title.'》发表的的评论：</p><p style="line-height:25px;padding:10px;background:#EDECF2;border-radius:4px;">'.$pinfo['comment'].'</p><p class="no_indent">'. $custom.' 给您的回复：</p><p style="line-height:25px;padding:10px;background:#5C96BE;border-radius:4px;color:#fff;">'.$content.'</p> <p>时间：'.date("Y-m-d",time()).'</p>
<p>状态：通过</p>
<p>本邮件为'.$blogname.'自动发送，请勿直接回复.</p> <table cellspacing="0" class="table">	</table><div class="btnn"><a href="'.Url::log($gid).'#'.$pid.'" target="_blank">查看该文章</a></div></div><div class="footer clear"></div></div></div>';
	sendmail_do(MAIL_SMTP, MAIL_PORT, MAIL_SENDEMAIL, MAIL_PASSWORD, $pinfo['mail'], $subject, $reply, $blogname);
				}
			}
		}
	}else{
		return;
	}
}      
           
        if (ISLOGIN === true) {
            $CACHE = Cache::getInstance();
            $user_cache = $CACHE->readCache('user');
            $name = addslashes($user_cache[UID]['name_orig']);
            $mail = addslashes($user_cache[UID]['mail']);
            $url = addslashes(BLOG_URL);
        }

        if ($url && strncasecmp($url,'http',4)) {
            $url = 'http://'.$url;
        }

        doAction('comment_post');

        $Comment_Model = new Comment_Model();
        $Comment_Model->setCommentCookie($name,$mail,$url);
        if($Comment_Model->isLogCanComment($blogId) === false) {
            emMsg('评论失败：该文章已关闭评论');
        } elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true) {
            emMsg('评论失败：已存在相同内容评论');
        } elseif (ROLE == ROLE_VISITOR && $Comment_Model->isCommentTooFast() === true) {
            emMsg('评论失败：您提交评论的速度太快了，请稍后再发表评论');
        } elseif (empty($name)) {
            emMsg('评论失败：请填写姓名');
        } elseif (strlen($name) > 20) {
            emMsg('评论失败：姓名不符合规范');
        } elseif ($mail != '' && !checkMail($mail)) {
            emMsg('评论失败：邮件地址不符合规范');
        } elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false) {
            emMsg('评论失败：禁止使用管理员昵称或邮箱评论');
        } elseif (!empty($url) && preg_match("/^(http|https)\:\/\/[^<>'\"]*$/", $url) == false) {
            emMsg('评论失败：主页地址不符合规范','javascript:history.back(-1);');
        } elseif (empty($content)) {
            emMsg('评论失败：请填写评论内容');
        } elseif (strlen($content) > 8000) {
            emMsg('评论失败：内容不符合规范');
        } elseif (ROLE == ROLE_VISITOR && Option::get('comment_needchinese') == 'y' && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $content)) {
            emMsg('评论失败：评论内容需包含中文');
        } elseif (ISLOGIN == false && Option::get('comment_code') == 'y' && session_start() && (empty($imgcode) || $imgcode !== $_SESSION['code'])) {
            emMsg('评论失败：验证码错误');
        } else {
            $_SESSION['code'] = null;
            $Comment_Model->addComment($name, $content, $mail, $url, $imgcode, $blogId, $pid);
        }
    }
}
