<?php
/**
 * 站点首页模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<button class="mdui-btn mdui-btn-icon seai"><i class="mdui-icon material-icons"> &#xe8b6; </i></button>
	</div>
</div>
</header>
<div class="titleBarGobal mdui-appbar mdui-shadow-0 mdui-text-color-white-text" id="SearchBar">
<form class="mdui-toolbar mdui-appbar-fixed" role="search" name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php" id="searchform" >
<div class="outOfSearch mdui-valign">
<label for="s"><i class="mdui-icon material-icons seaicon"> &#xe8b6; </i></label><input class="seainput" type="text" name="keyword" id="s" autocomplete="off" placeholder="搜索什么..." value="">
		</div>
		<div class="mdui-toolbar-spacer">
		</div>
		<a class="mdui-btn mdui-btn-icon sea-close"><i class="mdui-icon material-icons"> &#xe5cd; </i></a>
	</form>
</div>
<div class="theFirstPageBackGround mdui-color-theme">
</div>
<div class="theFirstPage LazyLoad" data-original="<?php echo TEMPLATE_URL; ?>img/banner.jpg" style="background-image: url(<?php echo TEMPLATE_URL; ?>img/banner.jpg);">
</div>
<div class="theFirstPageSay mdui-valign mdui-typo mdui-text-color-white-text">
	<h1 class="mdui-center"> <?php echo $bloginfo; ?> </h1>
</div>
<div class="main">
<?php doAction('index_loglist_top'); ?>
<?php 
foreach($logs as $value): 
if($value['sortop']=='y'){ ?>
<div class="mdx-same-posts mdx-hot-posts mdui-center">
		<h3>推荐文章</h3>
		<div class="mdx-hp-h3-fill">
		</div>
		<div id="mdx-sp-out-c">
			<div class="mdx-hp-g-l">
			</div>
			<div class="mdx-hp-g-r" style="display: block;">
			</div>
			<ul class="mdx-posts-may-related">
		        <?php echo istop() ?>
			</ul>
		</div>
	</div>
<?php 
};
endforeach;
?>
<?php 
if (!empty($logs)):
?>
	<h3 class="mdx-all-posts">最新文章</h3>
	<main class="postList mdui-center" id="postlist">
<?php 
foreach($logs as $value): 
$thumbs = empty($value['thumbs']) ? TEMPLATE_URL.'img/no.jpg' : $value['thumbs'];
?>	
	<div class="mdui-card postDiv mdui-center mdui-hoverable">
		<div class="mdui-card-media">
			<img src="<?php echo $thumbs ?>" alt="<?php echo $thumbs ?>" title="<?php echo $value['log_title']; ?>">
			<div class="mdui-card-media-covered mdui-card-media-covered-gradient">
				<div class="mdui-card-primary">
		<a href="<?php echo $value['log_url']; ?>">
		<div class="mdui-card-primary-title">
						<?php topflg($value['top'], $value['sortop'], isset($sortid)?$sortid:''); ?><?php echo $value['log_title']; ?>
					</div>
					</a>
				</div>
			</div>
		</div>
		<div class="mdui-card-actions">
			<p class="ct1-p mdui-text-color-black">
				<?php echo subString(strip_tags($value['log_description']),0,180,"..."); ?>
			</p>
			<p>
			</p>
			<div class="mdui-divider underline">
			</div>
			<span class="info">&nbsp;&nbsp;<i class="mdui-icon material-icons info-icon"> &#xe417; </i> <?php echo $value['views']; ?>&nbsp;&nbsp;<i class="mdui-icon material-icons info-icon"> &#xe192; </i> <?php echo gmdate('Y-n-j', $value['date']); ?> </span><a class="mdui-btn mdui-ripple mdui-ripple-white coun-read mdui-text-color-theme-accent" href="<?php echo $value['log_url']; ?>">去围观</a>
		</div>
	</div>	
<?php 
endforeach;
else:
?>
<main class="postList mdui-center" id="postlist"> <br><br><br><i class="mdui-icon material-icons mdui-center mdx-search-empty"> &#xe811; </i><br><br><br><h1 class="mdui-center mdx-search-empty-text">前方似乎禁止通行</h1><h2 class="mdui-center mdx-search-empty-text">什么也没找到，换个词搜搜试试？</h2><br><br></main> 
<?php endif;?>		
<?php if($page_url){ ?>
<nav id="comments-navi"> 
<?php echo $page_url;?> 
</nav>
<?php } ?>
</main>
<?php
include View::getView('footer');
?>