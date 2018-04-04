<?php
/*
Template Name: Material Design
Description: 一款轻快、优雅且强大的 Material Design,由 AxtonYao 制作,老司机移植,随便移植的,没怎么优化,没时间,暗藏很多功能,我就不移植咯
Version:1.0
ForEmlog:6.0.1
Author:老司机(Flyer)
Author Url:https://crazyus.us
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="preload" href="<?php echo TEMPLATE_URL; ?>mdui/icons/material-icons/MaterialIcons-Regular.woff2" as="font" type="font/woff2" crossorigin="">
<title itemprop="name"> <?php echo $site_title; ?> <?php echo page_tit($page); ?> </title>
<meta property="og:title" content="<?php echo $site_title; ?>">
<meta property="og:type" content="article">
<meta property="og:url" content="https://flyhigher.top">
<meta property="og:description" content="<?php echo $site_description; ?>">
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
<?php if(isset($sortName)): ?>
<link rel="canonical" href="<?php echo Url::sort($sortid);?>" />
<?php elseif(isset($logid)):?>
<link rel="canonical" href="<?php echo Url::log($logid);?>" />
<?php else:?>
<?php endif;?>
<link rel="shortcut icon" href="<?php echo BLOG_URL; ?>favicon.ico">
<meta name="theme-color" content="#3f51b5">
<link rel="stylesheet" id="mdx_mdui_css-css" href="<?php echo TEMPLATE_URL; ?>mdui/css/mdui.min.css?ver=42.35" type="text/css" media="all">
<link rel="stylesheet" id="mdx_style_css-css" href="<?php echo TEMPLATE_URL; ?>style.css?ver=42.35" type="text/css" media="all">
<link href="<?php echo TEMPLATE_URL; ?>css/lightbox.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo BLOG_URL; ?>admin/tinymce/plugins/codesample/css/prism.css">
<script src="<?php echo BLOG_URL; ?>admin/tinymce/plugins/codesample/prism.js"></script>
<script src="<?php echo BLOG_URL; ?>admin/views/plugins/fastclick.min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/jquery/jquery-1.11.0.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/lightbox.min.js"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body class="mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded">
<div class="OutOfsearchBox">
	<div class="searchBoxFill">
	</div>
</div>
<div class="fullScreen sea-close">
</div>
<div class="mdui-drawer mdui-color-white mdui-drawer-close mdui-drawer-full-height" id="left-drawer">
	<div class="sideImg LazyLoad" data-original="<?php echo TEMPLATE_URL; ?>img/default.png" style="background-image: url(<?php echo TEMPLATE_URL; ?>img/default.png);">
		<button class="mdui-btn mdui-btn-icon mdui-ripple nightVision mdui-text-color-white mdui-valign mdui-text-center" mdui-tooltip="{content: '切换日间/夜间模式'}" id="tgns" mdui-drawer-close="{target: '#left-drawer'}"><i class="mdui-icon material-icons">&#xe3a9;</i></button>
	<?php echo blogger()	?>
	</div>
<nav role="navigation">
	<ul id="mdx_menu" class="mdui-list">
		<?php blog_navi();?>
	</ul>
	</nav>
</div>
<header role="banner">
<div class="titleBarGobal mdx-sh-ani mdui-appbar mdui-shadow-0 mdui-text-color-white-text" id="titleBar">
	<div class="mdui-toolbar mdui-toolbar-self mdui-appbar-fixed topBarAni">
		<button class="mdui-btn mdui-btn-icon" id="menu" mdui-drawer="{target:'#left-drawer',overlay:true,swipe:true}"><i class="mdui-icon material-icons">menu</i></button>
		<span class="mdui-typo-headline"> 
		<?php echo $blogname; ?> 
		</span>
		<div class="mdui-toolbar-spacer">
</div>
