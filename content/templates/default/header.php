<?php
/*
Template Name:默认模板
Description:默认模板,简洁优雅,页面自带归档{page_archivers},友链{page_links},自行体验吧
Version:1.0
ForEmlog:6.0.1
Author:老司机(Flyer)
Author Url:https://crazyus.us
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="canonical" href="<?php echo BLOG_URL; ?>">
<title><?php echo $site_title; ?> <?php echo page_tit($page); ?> </title>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
<meta name="theme-color" content="#3F51B5">
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="generator" content="emlog" />
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo $site_title; ?>">
<meta property="og:url" content="<?php echo BLOG_URL; ?>">
<meta property="og:site_name" content="<?php echo $site_title; ?>">
<meta property="og:description" content="<?php echo $site_description; ?>">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $site_title; ?>">
<meta name="twitter:description" content="<?php echo $site_description; ?>">
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link rel="shortcut icon" href="<?php echo BLOG_URL; ?>favicon.ico">
<?php if(isset($sortName)): ?>
<link rel="canonical" href="<?php echo Url::sort($sortid);?>" />
<?php elseif(isset($logid)):?>
<link rel="canonical" href="<?php echo Url::log($logid);?>" />
<?php else:?><?php endif;?>
<link href="<?php echo TEMPLATE_URL; ?>css/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TEMPLATE_URL; ?>css/lightbox.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo BLOG_URL; ?>admin/tinymce/plugins/codesample/css/prism.css">
<script src="<?php echo BLOG_URL; ?>admin/tinymce/plugins/codesample/prism.js"></script>
<script src="<?php echo BLOG_URL; ?>admin/views/plugins/fastclick.min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/jquery/jquery-1.11.0.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/lightbox.min.js"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<script>window.lazyScripts=[];</script>
<!-- custom head -->
<?php doAction('index_head'); ?>
</head>
<body>
<div id="loading" class="active">
</div>
<aside id="menu"  <?php if (!blog_tool_ishome()) :?>class="hide"<?php endif ;?>>
<div class="inner flex-row-vertical">
	<a href="javascript:;" class="header-icon waves-effect waves-circle waves-light" id="menu-off"><i class="icon icon-lg icon-close"></i></a>
<?php blogger()?>
	</div>
	<div class="scroll-wrap flex-col">
		<ul class="nav">
<?php blog_navi();?>
		</ul>
	</div>
</div>
</aside>
<main id="main">
