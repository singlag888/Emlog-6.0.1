<?php 
/*
Custom:page_archivers
Description:文章归档
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<button class="mdui-btn mdui-btn-icon" mdui-menu="{target: '#qrcode'}" mdui-tooltip="{content: '在移动设备上阅读'}" id="oth-div"><i class="mdui-icon material-icons">&#xe326;</i></button>
<div class="mdui-menu" id="qrcode"> <img style="display: block;" src="https://pan.baidu.com/share/qrcode?w=155&h=155&url=<?php echo Url::log($logid); ?>&.jpg"> </div> 
<button class="mdui-btn mdui-btn-icon seai"><i class="mdui-icon material-icons">&#xe8b6;</i></button></div>
</div>
</header>
<div class="titleBarGobal mdui-appbar mdui-shadow-0 mdui-text-color-white-text" id="SearchBar">
<form class="mdui-toolbar mdui-appbar-fixed" role="search" name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php" id="searchform" >
<div class="outOfSearch mdui-valign">
<label for="s"><i class="mdui-icon material-icons seaicon"> &#xe8b6; </i></label><input class="seainput" type="text" name="keyword" id="s" autocomplete="off" placeholder="搜索什么..." value="">
		</div>
		<div class="mdui-toolbar-spacer">
		</div>
		<a class="mdui-btn mdui-btn-icon sea-close"><i class="mdui-icon material-icons"> &#xe5cd; </i></a>
	</form>
</div>
<div class="mdui-text-color-white-text mdui-typo-display-2 mdui-valign PostTitle PostTitle2" itemprop="name headline" itemtype="http://schema.org/BlogPosting">
<span class="mdui-center">
<?php echo $log_title; ?>
</span>
</div>
<div class="PostTitleFill2 LazyLoad" data-original="<?php echo TEMPLATE_URL; ?>img/banner.jpg" style="background-image: url(<?php echo TEMPLATE_URL; ?>img/banner.jpg);">
</div>
<div class="PostTitleFillBack2 mdui-color-theme">
</div>
<div class="PostMain PostMain2">
<div class="ArtMain0 mdui-center mdui-shadow-12">
<article class="post post-content type-post status-publish format-standard has-post-thumbnail hentry category-develop category tag-material-design tag-mdx tag mdui-typo" itemprop="articleBody">
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
</article>
</div>
</main>
<?php include View::getView('footer');?>