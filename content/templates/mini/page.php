<?php 
/*
Custom:page
Description:默认页面
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
</div>
</article>
 <div id="comments"> 
<div class="comments-title-box"> 
<div class="comments-title-line"></div> 
<span class="comments-title">精彩评论</span> </div>
<?php blog_comments($comments); ?>
<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
</div>
</div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>