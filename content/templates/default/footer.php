<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<footer class="footer">
<?php if (Option::get('rss_output_num')):?>
<div class="top">
<p>
<span><a href="<?php echo BLOG_URL; ?>rss.php" target="_blank" class="rss" title="rss"><i class="icon icon-lg icon-rss"></i></a></span><span>博客内容遵循 <a rel="license" href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh">知识共享 署名 - 非商业性 - 相同方式共享 4.0 国际协议</a></span>
</p>
</div>
<?php endif;?>
<div class="bottom">
<p>
<?php if($icp){ ?>
 <span><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <br/>
<?php } ?>© 2018 - 2019 </span><span> <a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a> <br/>
Power by <a href="https://crazyus.us/" target="_blank">Emlog</a><br/>
<?php if($footer_info){ ?>
<?php echo $footer_info; ?><br/>
<?php } ?>
<?php doAction('index_footer'); ?>
</span>
</p>
</div>
</footer>
</main>
<div class="mask" id="mask">
</div>
<a href="javascript:;" id="gotop" class="waves-effect waves-circle waves-light"><span class="icon icon-lg icon-chevron-up"></span></a>
<div class="global-share" id="globalShare">
<ul class="reset share-icons">
		<li><a class="weibo share-sns" target="_blank" href="http://service.weibo.com/share/share.php?url=<?php echo BLOG_URL; ?>&title=<?php echo $blogname; ?>&pic=<?php echo TEMPLATE_URL; ?>img/face.jpg" data-title="微博"><i class="icon icon-weibo"></i></a></li>
<li class=" waves-effect waves-block"><a class="weixin share-sns wxFab" href="javascript:;" data-title="微信"><i class="icon icon-weixin"></i></a></li>
<li class=" waves-effect waves-block">
<a class="qq share-sns" target="_blank" href="http://connect.qq.com/widget/shareqq/index.html?url= <?php echo BLOG_URL; ?>&title=<?php echo $blogname; ?>&source=<?php echo $site_description; ?>" data-title=" QQ"><i class="icon icon-qq"></i></a></li>
<li class=" waves-effect waves-block"><a class="facebook share-sns" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo BLOG_URL; ?>" data-title=" Facebook"><i class="icon icon-facebook"></i></a></li>
<li class=" waves-effect waves-block"><a class="twitter share-sns" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $blogname; ?>&url=<?php echo BLOG_URL; ?>&via=<?php echo BLOG_URL; ?>" data-title=" Twitter"><i class="icon icon-twitter"></i></a></li>
<li class=" waves-effect waves-block"><a class="google share-sns" target="_blank" href="https://plus.google.com/share?url=<?php echo BLOG_URL; ?>" data-title=" Google+"><i class="icon icon-google-plus"></i></a></li></ul></div><div class="page-modal wx-share" id="wxShare"><a class="close" href="javascript:;"><i class="icon icon-close"></i></a><p>扫一扫，分享到微信</p><img src="https://pan.baidu.com/share/qrcode?w=150&h=150&url=<?php echo BLOG_URL; ?>&.jpg" alt="微信分享二维码">
</div>
<script src="<?php echo TEMPLATE_URL; ?>js/waves.min.js?v=0.7.4"></script>
<?php 
$pattern_url = "/^((?!keyword).)*$/is"; 
$str = $_SERVER["REQUEST_URI"];
if(blog_tool_ishome() || $log_title=="归档"  || $log_title=="友链" || $_SERVER["REQUEST_URI"] == '/t/' || !preg_match($pattern_url, $str)) {
?>
<script>var BLOG={ROOT:"<?php echo $str ?>",SHARE:!0,REWARD:!1};</script>
<?php }else{ ?>
<script>var BLOG={ROOT:"<?php echo $str ?>",SHARE:!0,REWARD:!0};</script>
<?php } ?>
<script src="<?php echo TEMPLATE_URL; ?>js/main.min.js?v=1.7.2"></script>
<template id="search-tpl">
<li class="item">
</li>
</template>
<script src="<?php echo TEMPLATE_URL; ?>js/search.min.js?v=1.7.2" async=""></script>
</body>
</html>