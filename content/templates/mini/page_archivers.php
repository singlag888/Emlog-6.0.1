<?php 
/*
Custom:page_archivers
Description:文章归档
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="col-mb-12 col-8" id="main" role="main"> <article class="post shadow" itemscope="" itemtype="http://schema.org/BlogPosting"> <h1 class="post-title" itemprop="name headline"> 
<?php echo $log_title; ?>
</h1> 
<div class="post-content" itemprop="articleBody">
<?php
function displayRecord(){
global $CACHE; 
$record_cache = $CACHE->readCache('record');
$output = '';
foreach($record_cache as $value){
$output .= '<ul class="timeline"> <li><div class="time">'.$value['record'].'</div><div class="number">'.$value['lognum'].'</div>'.displayRecordItem($value['date']);
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
$output .= '<div class="content"><p> <time class="post-time"> '.date('n月d日',$row['date']).' </time><a class="title-link" href="'.$log_url.'">'.$row['title'].'</a></p> </div>' ;}
$output .= '</li></ul>';
$output = empty($output) ? '<li>暂无文章</li>' :$output;
return $output;
}
echo displayRecord();
?>
</div>
</article>
<?php if($allow_remark == 'y'){ ?>
 <div id="comments"> 
<div class="comments-title-box"> 
<div class="comments-title-line"></div> 
<span class="comments-title">精彩评论</span> 
</div>
<?php blog_comments($comments); ?>
<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
</div>
<?php } ?>
</div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>