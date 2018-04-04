<?php 
/*
Custom:page
Description:默认页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<header class="top-header" id="header">
<div class="flex-row">
	<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light on" id="menu-toggle"><i class="icon icon-lg icon-navicon"></i></a>
<div class="flex-col header-title ellipsis">
<?php echo $log_title; ?>
</div>
<div class="search-wrap" id="search-wrap">
		<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="back"><i class="icon icon-lg icon-chevron-left"></i></a> <form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">		
		<input id="key" class="search-input" autocomplete="off" name="keyword" placeholder="输入感兴趣的关键字"><a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="search"><i class="icon icon-lg icon-search"></i></a>
		</form>
	</div>
	<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="menuShare"><i class="icon icon-lg icon-share-alt"></i></a>
</div>
</header>
<header class="content-header post-header">
<div class="container fade-scale in">
<h1 class="title"> <?php echo $log_title; ?> </h1>
<h5 class="subtitle">
<time datetime="<?php echo gmdate('Y-n-j G:i', $date); ?>" itemprop="datePublished" class="page-time"> <?php echo gmdate('Y年n月j日', $date); ?> </time></h5>
</div>
</header>
<div class="container body-wrap">
<article id="post-data-sync-in-vue-single-page-application" class="post-article article-type-post fade in" itemprop="blogPost">
<div class="post-card">
<h1 class="post-card-title"> <?php echo $log_title; ?> </h1>
<div class="post-meta">
<time class="post-time" title="<?php echo gmdate('Y-n-j', $date); ?>" datetime="<?php echo gmdate('Y-n-j', $date); ?>" itemprop="datePublished"> <?php echo gmdate('Y年n月j日', $date); ?> </time>
</div>
<div  class="post-content" id="post-content" itemprop="postContent">
<?php 
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 class="image-link" data-lightbox="image" $6>$7</a>';$log_content = preg_replace($pattern, $replacement, $log_content);
echo $log_content; ?>
</div>
<div class="comments vcomment" id="comments">
<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
<?php blog_comments($comments); ?>
</div>
</article>
</div>
<?php
 include View::getView('footer');
?>