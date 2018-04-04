<?php
/**
 * 站点首页模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<header class="top-header" id="header">
<div class="flex-row">
	<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light on" id="menu-toggle"><i class="icon icon-lg icon-navicon"></i></a>
	<div class="flex-col header-title ellipsis">
		<?php echo $blogname; ?>
	</div>
	<div class="search-wrap" id="search-wrap">
		<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="back"><i class="icon icon-lg icon-chevron-left"></i></a>
<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">		
		<input id="key" class="search-input" autocomplete="off" name="keyword" placeholder="输入感兴趣的关键字"><a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="search"><i class="icon icon-lg icon-search"></i></a>
		</form>
	</div>
	<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="menuShare"><i class="icon icon-lg icon-share-alt"></i></a>
</div>
</header>
<header class="content-header index-header">
<div class="container fade-scale">
	<h1 class="title"> <?php echo $blogname; ?> </h1>
	<h5 class="subtitle"> <?php echo $bloginfo; ?> </h5>
</div>
</header>
<div class="container body-wrap">
<?php doAction('index_loglist_top'); ?>
<ul class="post-list">
 <?php
    if (!empty($logs)):
        foreach ($logs as $value):
   ?>
 		<li class="post-list-item fade"><article id="post-data-sync-in-vue-single-page-application" class="article-card article-type-post" itemprop="blogPost">
		<div class="post-meta">
			<time class="post-time" title="<?php echo gmdate('Y-n-j', $value['date']); ?>" datetime="<?php echo gmdate('Y-n-j', $value['date']); ?>" itemprop="datePublished"> <?php echo gmdate('Y年n月j日', $value['date']); ?> </time>
		</div>
		<h3 class="post-title" itemprop="name"><a class="post-title-link" href="<?php echo $value['log_url']; ?>"> <?php topflg($value['top'], $value['sortop'], isset($sortid)?$sortid:''); ?> <?php echo $value['log_title']; ?> </a></h3>
<div class="post-content" id="post-content" itemprop="postContent">  
<?php echo subString(strip_tags($value['log_description']),0,180,"..."); ?> <a href="<?php echo $value['log_url']; ?>" class="post-more waves-effect waves-button">阅读全文…</a>
</div>
<div class="post-footer">
<ul class="article-tag-list">
<?php blog_tag($value['logid']); ?> 
</ul>
</div>
</article>
</li>
<?php
 endforeach;
    else:
 ?>
 <div class="search-panel in" id="search-panel">
 <ul class="search-result" id="search-result">
 <li class="tips"><i class="icon icon-coffee icon-3x"></i>
 <p> 抱歉，没有符合您查询条件的结果 </p></li>
 </ul>
 </div>
<?php endif; ?>
</ul>
<?php if($page_url){ ?>
 <nav id="page-nav">
 <div class="inner">
<?php echo $page_url;?> 
</div>
</nav>
<?php } ?>
</div>
<?php
include View::getView('footer');
?>