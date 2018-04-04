<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<button class="mdui-fab mdui-color-theme-accent mdui-fab-fixed mdui-fab-hide scrollToTop mdui-ripple"><i class="mdui-icon material-icons">&#xe316;</i></button>
<footer class="foot mdui-text-center"> 
<?php if($icp){ ?>
 <span><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <br/>
<?php } ?>© 2018 - 2019 </span><span> <a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a> <br/>
Power by <a href="https://crazyus.us/" target="_blank">Emlog</a><br/>
Theme: MDx By <a href="https://flyhigher.top" target="_blank" class="click">AxtonYao</a><br>
<?php if($footer_info){ ?>
<?php echo $footer_info; ?><br/>
<?php } ?>
<?php doAction('index_footer'); ?>
</footer>
</div>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>mdui/js/mdui.min.js?ver=42.35"></script>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/nsc.js?ver=42.35"></script>
<script type="text/javascript" defer="defer" src="<?php echo TEMPLATE_URL; ?>js/search.js?ver=42.35"></script>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/smooth-lazyload.js?ver=42.35"></script>
<?php if(blog_tool_ishome()){?>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/js.js"></script>
<?php }else{ ?>
<script>
$('.mdx-emj-cli').click(function(){
      $('.mdx-emj').slideToggle(200);
 })
 var moreinput = "'更多选项'";
 var mdx_tapToTop = 0;
 mdx_tapToTop = 1;
</script>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/post.js"></script>
<?php } ?>
<div style="position: absolute; z-index: -10000; top: 0px; left: 0px; right: 0px; height: 628px;">
</div>
<div style="clear: both;">
</div>
</body>
</html>