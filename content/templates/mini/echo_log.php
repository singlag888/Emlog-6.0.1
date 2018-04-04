<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="col-mb-12 col-8" id="main" role="main"> <article class="post shadow" itemscope="" itemtype="http://schema.org/BlogPosting"> 
<h1 class="post-title" itemprop="name headline"> 
<?php echo $log_title; ?> 
</h1> 
<ul class="post-meta">  
<li>时间: <time datetime="<?php echo gmdate('Y-n-j', $date); ?>" itemprop="datePublished"> <?php echo gmdate('Y-n-j', $date); ?> </time>
</li> 
<li>分类: <?php blog_sort($logid); ?> 
</li> 
</ul> 
<div class="post-content" itemprop="articleBody"> 
<?php 
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 class="image-link" data-lightbox="image" $6>$7</a>';$log_content = preg_replace($pattern, $replacement, $log_content);
echo $log_content; ?>
<?php doAction('log_related', $logData); ?>
<div class="copy-say-after">
<?php if($copy=="1"){ ?>
<span class="post-time"> 版权说明:若无特殊注明,转载请保留文章出处</span> <br/> <span class="post-time"> 文章分类: <?php blog_sort($logid); ?> </span>  <br/> <span class="post-time"> 字数统计:本文共有 <?php echo mb_strlen(preg_replace(array("'<(.*?)>'is","' '","'\n\r'","' '","'\r'","'\n'"),'',$log_content),'UTF-8');?> 个</span> <br><span>本文链接:<?php echo Url::log($logid); ?></span> 
<?php }else{ ?>
<span class="post-time"> 版权说明: 本文为转载文章,源自互联网,由本站整编 </span> <br/> <span class="post-time"> 文章分类: <?php blog_sort($logid); ?> </span> <br/> <span class="post-time"> 字数统计:本文共有 <?php echo mb_strlen(preg_replace(array("'<(.*?)>'is","' '","'\n\r'","' '","'\r'","'\n'"),'',$log_content),'UTF-8');?> 个字</span><br><span>原文地址:<a href="<?php echo $copyurl ?>" target="_blank"> <?php echo $copyurl ?></a></span>
<?php } ?>
</div>
</div> 
<p itemprop="keywords" class="tags">标签: <?php blog_tag($logid); ?> 
</p> 
</article>
 <div id="comments"> 
<div class="comments-title-box"> 
<div class="comments-title-line"></div> 
<span class="comments-title">精彩评论</span> </div>
<?php blog_comments($comments); ?>
<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
</div> <?php neighbor_log($neighborLog); ?>

</div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>