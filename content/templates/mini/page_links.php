<?php 
/*
Custom:page_links
Description:友情链接
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="col-mb-12 col-8" id="main" role="main"> <article class="post shadow" itemscope="" itemtype="http://schema.org/BlogPosting"> <h1 class="post-title" itemprop="name headline"> 
<?php echo $log_title; ?>
</h1> 
<div class="post-content" itemprop="articleBody">
<?php 
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 class="image-link" data-lightbox="image" $6>$7</a>';$log_content = preg_replace($pattern, $replacement, $log_content);
echo $log_content; ?>
<?php
function sortLinks(){
	$db = Database::getInstance();
	global $CACHE;
	$sortlink_cache = $CACHE->readCache('sortlink');
foreach($sortlink_cache as $value){
$out .= '<h5>'.$sortlink_cache[$value['linksort_id']]['linksort_name'].'</h5> <div class="link-box">
';
$links = $db->query ("SELECT * FROM ".DB_PREFIX."link WHERE linksortid='$value[linksort_id]' AND hide='n' order by id DESC");
while ($row = $db->fetch_array($links)){
$sitepic = empty($row['sitepic']) ? BLOG_URL.'avatar/default.jpg' :$row['sitepic'];
$out .='<a href="'.$row['siteurl'].'" target="_blank" class="no-underline"><div class="thumb"><img width="200" height="200" src="'.$sitepic.'" alt="'.$row['description'].'"></div><div class="content"><div class="title"><span id="menu_index_6" name="menu_index_6"></span><h3> '.$row['sitename'].' </h3></div></div></a>';
	}
		$out .='</div>';
	}
	echo $out;
}?>
<?php echo sortLinks() ?>
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