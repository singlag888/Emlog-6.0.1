<?php 
/*
Custom:page_links
Description:友情链接
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<header class="top-header" id="header">
<div class="flex-row">
<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light on" id="menu-toggle"><i class="icon icon-lg icon-navicon"></i>
</a>
<div class="flex-col header-title ellipsis"> <?php echo $log_title; ?> </div>
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
<h1 class="title"> <?php echo $log_title; ?> </h1>
<h5 class="subtitle"></h5>
</div>
</header>
<div class="container body-wrap fade in">
<div  class="post-content" id="post-content" itemprop="postContent">
<?php 
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 class="image-link" data-lightbox="image" $6>$7</a>';$log_content = preg_replace($pattern, $replacement, $log_content);
echo $log_content; ?>
</div>
<?php
function sortLinks(){
	$db = Database::getInstance();
	global $CACHE;
	$sortlink_cache = $CACHE->readCache('sortlink');
foreach($sortlink_cache as $value){
$out .= '<h5 style="padding-top:10px;padding-bottom:10px">'.$sortlink_cache[$value['linksort_id']]['linksort_name'].'</h5> <div class="link-box">
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
   <?php if($allow_remark == 'y'){ ?>
<div class="comments vcomment" id="comments">
<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
<?php blog_comments($comments); ?>
</div>
<?php } ?>
</div>
<?php include View::getView('footer');?>