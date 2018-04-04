<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div>
</div>
</div>
<div class="return-top" style="display: block;"> <a href="javascript:;" class="triangle" title="回顶部" target="_blank"> <i class="triangle-up"></i> </a> 
</div> 
<footer id="footer" role="contentinfo"> 
<?php if($icp){ ?>
 <span><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <br/>
<?php } ?>© 2018 - 2019 </span><span> <a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a> <br/>
Power by <a href="https://crazyus.us/" target="_blank">Emlog</a><br/>
<?php if($footer_info){ ?>
<?php echo $footer_info; ?><br/>
<?php } ?>
<?php doAction('index_footer'); ?>
</footer> 
<script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.js"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/lightbox.min.js"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/main.js"></script> 
<script src="<?php echo TEMPLATE_URL; ?>js/instantclick.js" data-no-instant=""></script> 
<script data-no-instant="">InstantClick.init();</script>   
</body>
</html>