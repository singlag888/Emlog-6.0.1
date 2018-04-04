<?php 
/**
 * 微语部分
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<button class="mdui-btn mdui-btn-icon" mdui-menu="{target: '#qrcode'}" mdui-tooltip="{content: '在移动设备上阅读'}" id="oth-div"><i class="mdui-icon material-icons">&#xe326;</i></button>
<div class="mdui-menu" id="qrcode"> <img style="display: block;" src="https://pan.baidu.com/share/qrcode?w=155&h=155&url=<?php echo Url::log($logid); ?>&.jpg"> </div> 
<button class="mdui-btn mdui-btn-icon seai"><i class="mdui-icon material-icons">&#xe8b6;</i></button></div>
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
<div class="mdui-text-color-white-text mdui-typo-display-2 mdui-valign PostTitle PostTitle2" itemprop="name headline" itemtype="http://schema.org/BlogPosting">
<span class="mdui-center">
<?php echo $Navi_Model->getNaviNameByUrl('t');?>
</span>
</div>
<div class="PostTitleFill2 LazyLoad" data-original="<?php echo TEMPLATE_URL; ?>img/banner.jpg" style="background-image: url(<?php echo TEMPLATE_URL; ?>img/banner.jpg);">
</div>
<div class="PostTitleFillBack2 mdui-color-theme">
</div>
<div class="PostMain PostMain2">
<div class="ArtMain0 mdui-center mdui-shadow-12">
<article class="post post-content type-post status-publish format-standard has-post-thumbnail hentry category-develop category tag-material-design tag-mdx tag mdui-typo" itemprop="articleBody">
<?php 
    foreach($tws as $val):
    $img = empty($val['img']) ? "" : '<a title="查看图片" href="'.BLOG_URL.str_replace('thum-', '', $val['img']).'" target="_blank"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$val['img'].'"/></a>';
    ?>
 <div class="mdui-card staDiv postDiv mdui-center mdui-shadow-0">
 <div class="mdui-card-media outofSta">
 <div class="backGround"><i class="mdui-icon material-icons"> &#xe0b9;</i></div>
 <div class="staTime mdui-text-right"><i class="mdui-icon material-icons info-icon"> &#xe192; </i> <?php echo $val['date']; ?> </div>
 <article class="sayInSta mdui-valign">
  <span> <?php echo $val['t'].'<br/>'.$img;?> </span>
 </article>
 </div>
 </div>   
<?php endforeach;?>
</article>
<?php if($pageurl){ ?>
<nav id="comments-navi"> 
<?php echo $pageurl;?> 
</nav>
<?php } ?>    
</div>
</main>
<?php include View::getView('footer');?>
