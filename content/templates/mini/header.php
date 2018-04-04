<?php
/*
Template Name:Em6.0.1极速版
Description:简单明了,全功能调用版,给您们参考写模板用,如果还有Bug,请自行修复,不要太讲究了,前台模板而已
Version:1.0
ForEmlog:6.0.1
Author:老司机(Flyer)
Author Url:https://crazyus.us
Sidebar Amount:1
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html>
<html class="no-js">
<head> 
<meta charset="utf-8"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"> 
<meta name="renderer" content="webkit">
<meta http-equiv="windows-Target" contect="_top"> <meta name="robots" content="all"> 
<meta name="format-detection" content="telephone=no"> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
<link rel="icon" href="<?php echo BLOG_URL; ?>favicon.ico" type="image/x-icon"> 
<link rel="shortcut icon" href="<?php echo BLOG_URL; ?>favicon.ico" type="image/x-icon">
<title> <?php echo $site_title; ?> <?php echo page_tit($page); ?>  </title>  
<link href="//cdn.bootcss.com/normalize/7.0.0/normalize.min.css" rel="stylesheet"> 
<link rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>css/grid.css"> 
<link rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>css/style.css"> 
<!--[if lt IE 9]> 
<script src="http://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script> 
<script src="http://cdn.staticfile.org/respond.js/1.3.0/respond.min.js"></script> 
<![endif]-->  
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="template" content="mini"> 
<meta name="generator" content="emlog6.0.1" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<?php if(isset($sortName)): ?>
<link rel="canonical" href="<?php echo Url::sort($sortid);?>" />
<?php elseif(isset($logid)):?>
<link rel="canonical" href="<?php echo Url::log($logid);?>" />
<?php else:?>
<?php endif;?>
<link href="<?php echo TEMPLATE_URL; ?>css/lightbox.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo BLOG_URL; ?>admin/tinymce/plugins/codesample/css/prism.css">
<script src="<?php echo BLOG_URL; ?>admin/tinymce/plugins/codesample/prism.js"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
 <body> 
<!--[if lt IE 8]>
 <div class="browsehappy" role="dialog">当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>.</div> 
<![endif]--> 
<header id="header" class="clearfix Navbar visible">
    <div class="container">
        <div class="row">
            <div class="site-name col-mb-3 col-2">
<a id="logo" href="<?php echo BLOG_URL; ?>"> <?php echo $blogname; ?> </a> <p class="description hide"> <?php echo $bloginfo; ?> </p>
</div>
<div class="col-mb-9 col-7">
<nav id="nav-menu" class="clearfix" role="navigation">
<?php blog_navi();?>
</nav>
</div>
<div class="site-search kit-hidden-tb col-3"> 
<form id="search" name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php" role="search"> 
<label for="s" class="sr-only">搜索关键字</label>
 <input type="text" name="keyword" class="text" placeholder="">
<button type="submit" class="submit">搜索</button> 
</form> 
</div> 
<div class="hamburger hide" id="hamburger-1"> 
<span class="line"></span> 
<span class="line"></span> 
<span class="line"></span> 
</div>
</div>
</div>
</header>
<div id="body">
    <div class="container">
        <div class="row">