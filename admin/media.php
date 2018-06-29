<?php
/**
 * 附件管理
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';
if ($action == '') {
$db=Database::getInstance(); 
include View::getView('header');
require_once(View::getView('media'));
include View::getView('footer');
View::output();
}

