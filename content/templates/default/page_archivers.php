<?php 
/*
Custom:page_archivers
Description:文章归档
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<header class="top-header" id="header">
<div class="flex-row">
<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light on" id="menu-toggle"><i class="icon icon-lg icon-navicon"></i>
</a>
<div class="flex-col header-title ellipsis">归档</div>
<div class="search-wrap" id="search-wrap"><a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="back"><i class="icon icon-lg icon-chevron-left"></i></a> 
<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">		
		<input id="key" class="search-input" autocomplete="off" name="keyword" placeholder="输入感兴趣的关键字"><a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="search"><i class="icon icon-lg icon-search"></i></a>
		</form>
	</div>
<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="menuShare"><i class="icon icon-lg icon-share-alt"></i></a>
</div>
</header>
<header class="content-header archives-header">
<div class="container fade-scale in">
<h1 class="title">归档</h1>
<h5 class="subtitle"></h5>
</div>
</header>
<div class="container body-wrap fade in">
<?php
function displayRecord(){
global $CACHE; 
$record_cache = $CACHE->readCache('record');
$output = '';
foreach($record_cache as $value){
$output .= '<h3 class="archive-separator">'.$value['record'].'('.$value['lognum'].')</h3>'.displayRecordItem($value['date']);
}
return $output;
}
function displayRecordItem($record){
if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
$days = getMonthDayNum($match[2], $match[1]);
$record_stime = Strtotime($record . '01');
$record_etime = $record_stime + 3600 * 24 * $days;
} else {
	$record_stime = Strtotime($record);
	$record_etime = $record_stime + 3600 * 24;
}
$sql = "and date>=$record_stime and date<$record_etime order by top desc ,date desc";
$result = archiver_db($sql);
return $result;
			}
function archiver_db($condition = ''){
				$DB = Database::getInstance();
				$sql = "SELECT gid, title, date,views FROM " . DB_PREFIX . "blog WHERE type='blog' and hide='n' $condition";
				$result = $DB->query($sql);

				while ($row = $DB->fetch_array($result)) {
					$log_url = Url::log($row['gid']);
$output .= '<div class="waterfall">
<div class="waterfall-item"> <article class="article-card archive-article"><div class="post-meta"><time class="post-time" title="'.date('m月d日',$row['date']).'" datetime="'.date('m月d日',$row['date']).'" itemprop="datePublished"> '.date('n月d日',$row['date']).' </time></div><h3 class="post-title" itemprop="name"><a class="post-title-link" href="'.$log_url.'">'.$row['title'].'</a></h3> </article> </div></div> ' ;}
$output = empty($output) ? '<li>暂无文章</li>' : $output;
return $output;
}
echo displayRecord();
?>
</div>
<?php include View::getView('footer');?>