<?php 
/*
Custom:page
Description:默认页面
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
<?php echo $log_title; ?>
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
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 class="image-link" data-lightbox="image" $6>$7</a>';$log_content = preg_replace($pattern, $replacement, $log_content);
echo $log_content; ?>
</article>
<div class="spanout">
<span style="padding-left:-10px">
<i class="mdui-icon material-icons"> &#xe417; </i>
<?php echo $views; ?> 人查看
</sapn>
<span class="mdui-text-color-black-disabled timeInPost" itemprop="datePublished"><i class="mdui-icon material-icons info-icon"> &#xe192; </i> 
<?php echo gmdate('Y年n月j日', $date); ?>
</span>


		</div>
		<div class="mdx-same-posts">
			<h3>你可能会感兴趣</h3>
			<div id="mdx-sp-out-c">
				<ul class="mdx-posts-may-related">
					<?php  echo random_log() ?>
				</ul>
			</div>
		</div>

<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
<div class="comms mdui-center" id="comments">
<?php blog_comments($comments); ?>			
<div class="mdx-comments-loading">
				<div class="mdui-valign">
					<div>
						<div class="mdui-spinner">
							<div class="mdui-spinner-layer ">
								<div class="mdui-spinner-circle-clipper mdui-spinner-left">
									<div class="mdui-spinner-circle">
									</div>
								</div>
								<div class="mdui-spinner-gap-patch">
									<div class="mdui-spinner-circle">
									</div>
								</div>
								<div class="mdui-spinner-circle-clipper mdui-spinner-right">
									<div class="mdui-spinner-circle">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php
 include View::getView('footer');
?>