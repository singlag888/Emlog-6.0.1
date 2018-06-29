<?php

/**
 * 附件处理
 * @copyright (c) Emlog All Rights Reserved
 */
require_once 'globals.php';

$DB = Database::getInstance();

//上传表单显示
if ($action == 'selectFile') {
    $attachnum = 0;
    $logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
    $multi = isset($_GET['multi']) ? intval($_GET['multi']) : 0;

    if ($logid) {
        $Log_Model = new Log_Model();
        $row = $Log_Model->getOneLogForAdmin($logid);
        $attachnum = (int)$row['attnum'];
    }
    $maxsize = changeFileSize(Option::getAttMaxSize());
    //允许附件类型
    $att_type_str = '';
    $att_type_for_muti = '';
    foreach (Option::getAttType() as $val) {
        $att_type_str .= " $val";
        $att_type_for_muti .= '*.'.$val.';';
    }
    $view_tpl = $multi ? 'upload_multi' : 'upload';
    require_once(View::getView($view_tpl));
    View::output();
}

//上传附件
if ($action == 'upload') {
    $logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
    $attach = isset($_FILES['attach']) ? $_FILES['attach'] : '';
    if ($attach) {
        for ($i = 0; $i < count($attach['name']); $i++) {
            if ($attach['error'][$i] != 4) {
                $isthumbnail = Option::get('isthumbnail') == 'y' ? true : false;

                $file_name = Database::getInstance()->escape_string($attach['name'][$i]);
                $file_error = $attach['error'][$i];
                $file_tmp_name = $attach['tmp_name'][$i];
                $file_size = $attach['size'][$i];

                $file_info = uploadFile($file_name, $file_error, $file_tmp_name, $file_size, Option::getAttType(), false, $isthumbnail);
                // 写入附件信息
                $query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s', 0)";
                $query = sprintf($query, $logid, $file_info['file_name'], $file_info['size'], $file_info['file_path'], time(), $file_info['width'], $file_info['height'], $file_info['mime_type']);
                $DB->query($query);
                $aid = $DB->insert_id();
                $DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum+1 WHERE gid=$logid");
                // 写入缩略图信息
                if (isset($file_info['thum_file'])) {
                    $query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')";
                    $query = sprintf($query, $logid, $file_info['file_name'], $file_info['thum_size'], $file_info['thum_file'], time(), $file_info['thum_width'], $file_info['thum_height'], $file_info['mime_type'], $aid);
                    $DB->query($query);		
                }
            }
        }
    }
    emDirect("attachment.php?action=attlib&logid=$logid");
}

//批量上传
if ($action == 'upload_multi') {
    $logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
    $attach = isset($_FILES['attach']) ? $_FILES['attach'] : '';
    if ($attach) {
        if ($attach['error'] != 4) {
            $isthumbnail = Option::get('isthumbnail') == 'y' ? true : false;
            $attach['name'] = Database::getInstance()->escape_string($attach['name']);
            $file_info = uploadFileBySwf($attach['name'], $attach['error'], $attach['tmp_name'], $attach['size'], Option::getAttType(), false, $isthumbnail);
            // 写入附件信息
            $query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s',0)";
            $query = sprintf($query, $logid, $file_info['file_name'], $file_info['size'], $file_info['file_path'], time(), $file_info['width'], $file_info['height'], $file_info['mime_type']);
            $DB->query($query);
            $aid = $DB->insert_id();
            $DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum+1 WHERE gid=$logid");
            // 写入缩略图信息
            if (isset($file_info['thum_file'])) {
                $query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')";
                $query = sprintf($query, $logid, $file_info['file_name'], $file_info['thum_size'], $file_info['thum_file'], time(), $file_info['thum_width'], $file_info['thum_height'], $file_info['mime_type'], $aid);
                $DB->query($query);		
            }
        }
    }
}

//附件库
if ($action == 'attlib') {
    $logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
    $sql = "SELECT * FROM " . DB_PREFIX . "attachment WHERE blogid = $logid AND thumfor = 0";
    $query = $DB->query($sql);
    $attach = array();
    while ($row = $DB->fetch_array($query)) {
        $attsize = changeFileSize($row['filesize']);
        $filename = htmlspecialchars($row['filename']);
        $attach[$row['aid']] = array(
                'attsize'  => $attsize,
                'aid'      => $row['aid'],
                'filepath' => $row['filepath'],
                'filename' => $filename,
                'width'    => $row['width'],
                'height'   => $row['height'],
        );		
        $thum = $DB->once_fetch_array('SELECT * FROM ' . DB_PREFIX . 'attachment WHERE thumfor = '. $row['aid']);
        if ($thum) {
            $attach[$row['aid']]['thum_filepath']	= $thum['filepath'];
            $attach[$row['aid']]['thum_width']	    = $thum['width'];
            $attach[$row['aid']]['thum_height']  	= $thum['height'];
        }
    }
    $attachnum = count($attach);
    include View::getView('attlib');
    View::output();
}

//删除附件
if ($action == 'del_attach') {
    LoginAuth::checkToken();
    $aid = isset($_GET['aid']) ? intval($_GET['aid']) : '';
    $query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE aid = $aid ");
    $attach = $DB->fetch_array($query);
    $logid = $attach['blogid'];
    if (file_exists($attach['filepath'])) {
        @unlink($attach['filepath']) or emMsg("删除附件失败!");
    }

    $query = $DB->query("SELECT * FROM ".DB_PREFIX."attachment WHERE thumfor = ".$attach['aid']);
    $thum_attach = $DB->fetch_array($query);
    if ($thum_attach) {
        if (file_exists($thum_attach['filepath'])) {
            @unlink($thum_attach['filepath']) or emMsg("删除附件失败!");
        }
        $DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$thum_attach['aid']} ");
    }

    $DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum-1 WHERE gid = {$attach['blogid']}");
    $DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$attach['aid']} ");
    emDirect("attachment.php?action=attlib&logid=$logid");
}

//删除附件管理
if ($action == 'del_media') {
   LoginAuth::checkToken();
	$aid = isset($_GET['aid']) ? intval($_GET['aid']) : '';
	$query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE aid = $aid ");
	$attach = $DB->fetch_array($query);
	$logid = $attach['blogid'];
	if (file_exists($attach['filepath'])) {
		@unlink($attach['filepath']) or emMsg(langs('attachment_delete_error'));
	}

	$query = $DB->query("SELECT * FROM ".DB_PREFIX."attachment WHERE thumfor = ".$attach['aid']);
	$thum_attach = $DB->fetch_array($query);
	if ($thum_attach) {
		if (file_exists($thum_attach['filepath'])) {
			@unlink($thum_attach['filepath']) or emMsg(langs('attachment_delete_error'));
		}
	
		$DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$thum_attach['aid']} ");
	}

	$DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum-1 WHERE gid = {$attach['blogid']}");
	$DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$attach['aid']} ");
	
	$CACHE->updateCache();
	emDirect("./media.php?active_del=1");
	
}

//批量删除附件
if ($action== 'dell_all_media') {$media = isset($_POST['media']) ? $_POST['media'] : '';
LoginAuth::checkToken();
if (!$media) {
emDirect("./media.php?active_del=1");
}
foreach ($media as $key=>$value) {
	$DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$key} ");
}
$CACHE->updateCache();
emDirect("./media.php?active_del=1");
}

//微语图片上传
if ($action == 'upload_tw_img') {
        LoginAuth::checkToken();
	$filename = iconv('UTF-8', 'GBK', $_FILES['file']['name']); 
      $uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
       move_uploaded_file($_FILES["file"]["tmp_name"],
      $uppath.$filename);
      echo $filename;
      exit;    
}



