<?php
/**
 * 站点首页模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<div class="col-mb-12 col-8" id="main" role="main">
<?php doAction('index_loglist_top'); ?>
<?php
    if (!empty($logs)):
        foreach ($logs as $value):
 ?>
<article class="post shadow index" itemscope="" itemtype="http://schema.org/BlogPosting"> 
<h2 class="post-title" itemprop="name headline"> 
<a itemtype="url" href="<?php echo $value['log_url']; ?>"> <?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?> <?php echo $value['log_title']; ?> </a> 
</h2> 
<div class="post-content" itemprop="articleBody"> 
<?php if(!empty($value['thumbs'])){?>
<img src="<?php echo $value['thumbs']; ?>">
<?php } ?>
<?php echo subString(strip_tags($value['log_description']),0,180,"..."); ?> </div> 
<ul class="post-meta">  
<li>时间: <time datetime="<?php echo gmdate('Y-n-j', $value['date']); ?>" itemprop="datePublished"> <?php echo gmdate('Y-n-j', $value['date']); ?> </time>
</li> 
<li itemprop="interactionCount"><a itemprop="discussionUrl" href="<?php echo $value['log_url']; ?>#comments"> <?php echo $value['comnum']; ?> 条评论</a></li> <li><a itemtype="url" href="<?php echo $value['log_url']; ?>">阅读全文</a></li> </ul>
</article> 
<?php
        endforeach;
    else:
        ?>
        <div class="error">
            <h2 class="post-title"> 未找到 </h2>
            <p> 抱歉，没有符合您查询条件的结果 </p>        </div>
        <?php endif; ?> <ol class="page-navigator"> 
 <?php echo $page_url; ?>
 </ol>
 </div>
<?php
include View::getView('side');
include View::getView('footer');
?>