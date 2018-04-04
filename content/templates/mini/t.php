<?php 
/*
* 每日一语部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="col-mb-12 col-8" id="main" role="main"> <article class="post shadow" itemscope="" itemtype="http://schema.org/BlogPosting"> 
<h1 class="post-title" itemprop="name headline"> 
<?php echo $Navi_Model->getNaviNameByUrl('t');?>
</h1> 
<div class="post-contents" itemprop="articleBody"><div class="tw">
<?php 
   foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    $avatar = empty($user_cache[$val['author']]['avatar']) ? 
                BLOG_URL . 'admin/views/app/img/avatar.jpg' : 
                BLOG_URL . $user_cache[$val['author']]['avatar'];

    $img = empty($val['img']) ? "" : '<a title="查看图片" href="'.BLOG_URL.str_replace('thum-', '', $val['img']).'" target="_blank" class="image-link" data-lightbox="image"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$val['img'].'"/></a>';
			?> 
			<li class="li">
				<div class="tw-body">
					<div class="tw-text">
						<div class="gravatar">
							<img src="<?php echo $avatar; ?>" width="32px" height="32px" />
						</div>
						<div class="tw-meta">
							<span class="author"><?php echo $author; ?></span>
							<span class="time">(<?php echo $val['date'];?>)</span>
						</div>
						<div class="tw-p">
			<?php echo $val['t'].'<br/><br/>'.$img;?>
						</div>
					</div>
				</div>


			</li>
			<?php endforeach;?>
	</div>
</div>
</<article>
</div>
<?php if($pageurl) {?>
<ol class="page-navigator"> 
<?php echo $pageurl;?>
</ol>
<?php } ?>
<?php
 include View::getView('side');
 include View::getView('footer');
?>