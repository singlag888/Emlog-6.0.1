<?php 
/**
 * 阅读文章页面
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
<time class="post-time" title="<?php echo gmdate('Y-n-j', $date); ?>" datetime="<?php echo gmdate('Y-n-j', $date); ?>" itemprop="datePublished"> <?php echo gmdate('Y年n月j日', $date); ?> <span class="right"><?php editflg($logid,$author); ?> </span></time>
</div>
<div class="post-content" id="post-content" itemprop="postContent">
<?php 
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 class="image-link" data-lightbox="image" $6>$7</a>';$log_content = preg_replace($pattern, $replacement, $log_content);
echo $log_content; ?>
<?php doAction('log_related', $logData); ?>
</div>
<blockquote class="post-copyright">
<div class="content">
<?php if($copy=="1"){ ?>
<span class="post-time"> 版权说明:若无特殊注明,转载请保留文章出处</span> <br/> <span class="post-time"> 文章分类: <?php blog_sort($logid); ?> </span>  <br/> <span class="post-time"> 字数统计:本文共有 <?php echo mb_strlen(preg_replace(array("'<(.*?)>'is","' '","'\n\r'","' '","'\r'","'\n'"),'',$log_content),'UTF-8');?> 个</span> <br>本文链接:<?php echo Url::log($logid); ?> 
<?php }else{ ?>
<span class="post-time"> 版权说明: 本文为转载文章,源自互联网,由本站整编 </span> <br/> <span class="post-time"> 文章分类: <?php blog_sort($logid); ?> </span> <br/> <span class="post-time"> 字数统计:本文共有 <?php echo mb_strlen(preg_replace(array("'<(.*?)>'is","' '","'\n\r'","' '","'\r'","'\n'"),'',$log_content),'UTF-8');?> 个字</span><br>原文地址:<a href="<?php echo $copyurl ?>" target="_blank"> <?php echo $copyurl ?></a>
<?php } ?>
</div>
<footer>
<?php blog_author($author); ?>
</footer>
</blockquote>
<div class="page-reward">
<a id="rewardBtn" href="javascript:;" class="page-reward-btn waves-effect waves-circle waves-light">赏</a></div>
<div class="post-footer">
<ul class="article-tag-list">
<?php blog_tag($logid);?>
</ul>
	<div class="page-share-wrap">
				<div class="page-share" id="pageShare">
					<ul class="reset share-icons">
						<li><a class="weibo share-sns" target="_blank" href="http://service.weibo.com/share/share.php?url=<?php echo Url::log($logid); ?>&title=《<?php echo $log_title; ?>》 — <?php echo $site_title; ?>&pic=<?php echo TEMPLATE_URL; ?>img/face.jpg" data-title="微博"><i class="icon icon-weibo"></i></a></li>
						<li><a class="weixin share-sns wxFab" href="javascript:;" data-title="微信"><i class="icon icon-weixin"></i></a></li>
						<li><a class="qq share-sns" target="_blank" href="http://connect.qq.com/widget/shareqq/index.html?url=<?php echo Url::log($logid); ?>&title=《<?php echo $log_title; ?>》 — <?php echo $site_title; ?>&source= <?php echo $site_description; ?>" data-title=" qq"><i class="icon icon-qq"></i></a></li>
						<li><a class="facebook share-sns" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo Url::log($logid); ?>" data-title=" facebook"><i class="icon icon-facebook"></i></a></li>
						<li><a class="twitter share-sns" target="_blank" href="https://twitter.com/intent/tweet?text=《<?php echo $log_title; ?>》 — Yusen's Blog&url=<?php echo Url::log($logid); ?>&via=http://imys.net" data-title=" twitter"><i class="icon icon-twitter"></i></a></li>
						<li><a class="google share-sns" target="_blank" href="https://plus.google.com/share?url=<?php echo Url::log($logid); ?>" data-title=" google+"><i class="icon icon-google-plus"></i></a></li>
					</ul>
				</div>
				<a href="javascript:;" id="shareFab" class="page-share-fab waves-effect waves-circle"><i class="icon icon-share-alt icon-lg"></i></a>
			</div>
		</div>
</div>
<?php neighbor_log($neighborLog)?>
<div class="comments vcomment" id="comments">
<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
<?php blog_comments($comments); ?>
</div>
</article>
<div id="reward" class="page-modal reward-lay">
		<a class="close" href="javascript:;"><i class="icon icon-close"></i></a>
		<h3 class="reward-title"><i class="icon icon-quote-left"></i> 请我吃辣条~ <i class="icon icon-quote-right"></i></h3>
		<div class="reward-content">
			<div class="reward-code">
				<img id="rewardCode" src="<?php echo TEMPLATE_URL; ?>img/wechat.png" alt="打赏二维码">
			</div>
			<label class="reward-toggle">
			<div class="reward-toggle-ctrol">
				<span class="reward-toggle-item wechat">微信</span>
			</div>
			</label>
		</div>
	</div>
</div>
<?php
 include View::getView('footer');
?>