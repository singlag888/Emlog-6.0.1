<?php
/**
 * 评论邮件通知
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';$options_cache = $CACHE->updateCache('options');

if ($action == '') {
      $options_cache = $CACHE->readCache('options');
      extract($options_cache);
      $DB = Database::getInstance();

       $ex0 = $ex1= '';
       $t = 'ex'.$MAIL_SENDTYPE;
       $$t = 'checked="checked"';

       $SEND_MAIL = $SEND_MAIL == 'Y' ? 'checked="checked"' : '';
       $REPLY_MAIL = $REPLY_MAIL == 'Y' ? 'checked="checked"' : '';


       include View::getView('header');
	require_once(View::getView('sendmail'));
	include View::getView('footer');
	View::output();
}

if ($action == 'set') {
    LoginAuth::checkToken();
    $getData = array(
 'MAIL_SMTP' => isset($_POST['smtp']) ? addslashes($_POST['smtp']) :'',  
 'MAIL_PORT' => isset($_POST['port']) ? intval($_POST['port']) : '25',
  'MAIL_SENDEMAIL' => isset($_POST['sendemail']) ? addslashes($_POST['sendemail']) : '',
    'MAIL_PASSWORD' => isset($_POST['password']) ? addslashes($_POST['password']) : '',
      'MAIL_TOEMAIL' => isset($_POST['toemail']) ? addslashes($_POST['toemail']) : '',
        'MAIL_SENDTYPE' => isset($_POST['sendtype']) ? addslashes($_POST['sendtype']) : '0',
          'SEND_MAIL' => isset($_POST['issendmail']) ? addslashes($_POST['issendmail']) : 'N',
    'REPLY_MAIL' => isset($_POST['isreplymail']) ? addslashes($_POST['isreplymail']) : 'N',
 );
  foreach ($getData as $key => $val) {
		Option::updateOption($key, $val);   }
  
   $CACHE->updateCache('options');
   emDirect("./sendmail.php?activated=1");
}



if ($action == 'test') {
    LoginAuth::checkToken();
    $blogname = Option::get('blogname');
$subject = $content = '这是一封测试邮件';
if(sendmail_do(MAIL_SMTP, MAIL_PORT, MAIL_SENDEMAIL, MAIL_PASSWORD, MAIL_TOEMAIL, $subject, $content, $blogname))
{
	echo '<font color="green">发送成功！请到相应邮箱查收！：）</font>';
}

}



