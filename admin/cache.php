<?php
/**
 * 数据缓冲
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
$DB = Database::getInstance();
   function format_size($size) {
	$measure = "Byte";
	    if ($size >= 1024) {
				$size = $size / 1024;
				$measure = "KiB";
			}
           if ($size >= 1024) {
				$size = $size / 1024;
				$measure = "MB";
			}
               $return = sprintf('%0.4s',$size);
           if (substr($return, -1) == "." ) $return = substr($return, 0, -1);
                return $return . " ". $measure;
		}
   
       include View::getView('header');
	require_once(View::getView('cache'));
	include View::getView('footer');
	View::output();
}


if ($action == 'Cache') {
	$CACHE->updateCache();
	emDirect('./cache.php?active_mc=1');
}


if($action == 'suc'){
LoginAuth::checkToken();
$DB = Database::getInstance();
$alltables = $DB->query("SHOW TABLES");
echo "<thead>
  <tr>
<th><b>数据表</b></th>
<th class=\"tdcenter\"><b>状态</b></th>
 </tr>
 </thead>
 <tbody>";
while ($table = mysqli_fetch_assoc($alltables))
{
   echo "<tr>";
   foreach ($table as $key => $tablename)
   {
      echo "<td>".$tablename."</td>";
     $DB->query("OPTIMIZE TABLE $tablename") or emMsg("优化失败");
     echo "<td class=\"tdcenter\">优化成功</td>";
  }
  echo "</tr>";
}
echo " </tbody>";
}