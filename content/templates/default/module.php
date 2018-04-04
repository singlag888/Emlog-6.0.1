<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
//log：blogger
function blogger(){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $name = $user_cache[1]['name'];
    $mail = empty($user_cache[1]['mail']) ? '没填写邮箱' : $user_cache[1]['mail'] ;
     $des = empty($user_cache[1]['des']) ? '该家伙很赖.啥也没写' : $user_cache[1]['des'] ;
    $avatar = empty($user_cache[1]['avatar']) ? BLOG_URL.'avatar/default.jpg' : BLOG_URL. $user_cache[1]['avatar']; 
?>
<div class="brand-wrap" style="background-image:url(<?php echo TEMPLATE_URL; ?>img/brand.jpg)">
<div class="brand">
<a href="/" class="avatar waves-effect waves-circle waves-light"><img src="<?php echo $avatar =preg_replace('/thum-|thum52-/','',$avatar)?>"></a>
<hgroup class="introduce">
<h5 class="nickname"> <?php echo $name; ?> </h5>
<a href="mailto: <?php echo $mail; ?>" title="<?php echo $mail; ?>" class="mail"> <?php echo $des; ?> </a>
</hgroup>
</div>
<?php }?>
<?php
//blog：导航
function blog_navi(){
    global $CACHE; 
    $navi_cache = $CACHE->readCache('navi');
    ?>
            <?php
            foreach($navi_cache as $value):
            if ($value['pid'] != 0) {
                continue;
            }
            if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
            ?>
               <li class="waves-block waves-effect"><a href="<?php echo BLOG_URL; ?>admin/"><i class="icon icon-lg icon-cog"></i> 管理</a></li>
               <li class="waves-block waves-effect"><a href="<?php echo BLOG_URL; ?>admin/?action=logout"><i class="icon icon-lg icon-power-off"></i> 退出</a></li>
            <?php 
                continue;
            endif;
            $newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
            $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
            $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'active' : 'common';
            ?>
            <?php if (!empty($value['children']) || !empty($value['childnavi'])) :?>
            <li class="dropdown">
                <?php if (!empty($value['children'])):?>
                <a href="<?php echo $value['url']; ?>"<?php echo $newtab;?>><?php echo $value['naviname']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php foreach ($value['children'] as $row){
                            echo '<li><a href="'.Url::sort($row['sid']).'">'.$row['sortname'].'</a></li>';
                    }?>
                </ul>
                <?php endif;?>
                <?php if (!empty($value['childnavi'])) :?>
                <a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>><?php echo $value['naviname']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php foreach ($value['childnavi'] as $row){
                            $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                            echo '<li><a href="' . $row['url'] . "\" $newtab >" . $row['naviname'].'</a></li>';
                    }?>
                </ul>
                <?php endif;?>
            </li>
            <?php else:?>
            <li class="waves-block waves-effect"><a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>> <?php if($value['naviname']=="首页"){  ?> <i class="icon icon-lg icon-home"></i> <?php }elseif($value['naviname']=="微语"){  ?> <i class="icon icon-lg icon-coffee"></i> <?php }elseif($value['naviname']=="留言"){  ?> <i class="icon icon-lg icon-comments"></i> <?php }elseif($value['naviname']=="关于"){  ?> <i class="icon icon-lg icon-id-card"></i>   <?php }elseif($value['naviname']=="归档"){  ?> <i class="icon icon-lg icon-calendar"></i> <?php }elseif($value['naviname']=="友链"){  ?> <i class="icon icon-lg icon-link"></i> <?php }elseif($value['naviname']=="相册"){  ?> <i class="icon icon-lg icon-camera"></i> <?php }elseif($value['naviname']=="登录"){  ?> <i class="icon icon-lg icon-lock"></i> <?php }else{  ?> <i class="icon icon-lg icon-book"></i> <?php } ?>  <?php echo $value['naviname']; ?></a></li>
            <?php endif;?>
            <?php endforeach; ?>
<?php }?>
<?php
//blog：置顶
function topflg($top, $sortop='n', $sortid=null){
    if(blog_tool_ishome()) {
       echo $top == 'y' ? "[置顶]" : '';
    } elseif($sortid){
       echo $sortop == 'y' ? "[分类置顶]" : '';
    }
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
    $editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" target="_blank">编辑</a>' : '';
    echo $editflg;
}
?>
<?php
//blog：分类
function blog_sort($blogid){
    global $CACHE; 
    $log_cache_sort = $CACHE->readCache('logsort');
    ?>
    <?php if(!empty($log_cache_sort[$blogid])): ?>
    <a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
    <?php endif;?>
<?php }?>
<?php
//blog：文章标签
function blog_tag($blogid){
    global $CACHE;
    $tag_model = new Tag_Model();

    $log_cache_tags = $CACHE->readCache('logtags');
    if (!empty($log_cache_tags[$blogid])){
        $tag = '';
        foreach ($log_cache_tags[$blogid] as $value){
            $tag .= "	<li class=\"article-tag-list-item\">
<a class=\"article-tag-list-link waves-effect waves-button\"  href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a> </li>';
        }
        echo $tag;
    }
    else
    {
        $tag_ids = $tag_model->getTagIdsFromBlogId($blogid);
        $tag_names = $tag_model->getNamesFromIds($tag_ids);

        if ( ! empty($tag_names))
        {
            $tag = '';

            foreach ($tag_names as $key => $value)
            {
                $tag .= "<li class=\"article-tag-list-item\">
<a class=\"article-tag-list-link waves-effect waves-button\" href=\"".Url::tag(rawurlencode($value))."\">".htmlspecialchars($value).'</a></li>';
            }

            echo $tag;
        }
    }
}
?>
<?php
//blog：文章作者
function blog_author($uid){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $author = $user_cache[$uid]['name'];
    $mail = $user_cache[$uid]['mail'];
    $avatar= getGravatar($mail);
    $des = $user_cache[$uid]['des'];
    $title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
    echo '<a href="'.Url::author($uid)."\" > <img src=\"$avatar\" > $author</a>";
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
    extract($neighborLog);?>
    <?php if($nextLog || $prevLog){?>
<nav class="post-nav flex-row flex-justify-between">
    <?php if($prevLog):?>
<div class="waves-block waves-effect prev">
<a href= "<?php echo Url::log($prevLog['gid']) ?>"  id="post-prev" class="post-nav-link"><div class="tips"><i class="icon icon-angle-left icon-lg icon-pr"></i> Prev</div><h4 class="title"> <?php echo $prevLog['title'];?> </h4></a></div>
<?php else :  ?>
<div class="waves-block waves-effect prev">
<a href= "#"  id="post-prev" class="post-nav-link"><div class="tips"><i class="icon icon-angle-left icon-lg icon-pr"></i> Prev</div><h4 class="title">没有咯</h4></a></div>
    <?php endif;?>
    <?php if($nextLog):?>
<div class="waves-block waves-effect next"><a href="<?php echo Url::log($nextLog['gid']) ?>" id="post-next" class="post-nav-link"><div class="tips">Next <i class="icon icon-angle-right icon-lg icon-pl"></i></div><h4 class="title"> <?php echo $nextLog['title'];?> </h4></a></div>
<?php else : ?>
<div class="waves-block waves-effect next"><a href="#" id="post-next" class="post-nav-link"><div class="tips">Next <i class="icon icon-angle-right icon-lg icon-pl"></i></div><h4 class="title"> 没有咯 </h4></a></div>
    <?php endif;?>
</nav>
    <?php };?>
<?php }?>
<?php
//blog：评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>
    <div class="comment-list">
      <h3 class="comment-count">评论</h3> <a name="comments"></a>
      <?php endif; ?>
      <ul class="comment-list-ul">
    <?php
    $isGravatar = Option::get('isgravatar');
    foreach($commentStacks as $cid):
    $comment = $comments[$cid];
    $comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
    ?>
<li id="comment-<?php echo $comment['cid']; ?>" class="comment">
<a name="<?php echo $comment['cid']; ?>"></a>
<?php if($isGravatar == 'y'): ?>
 <div class="comment-avatar">
<img class="lazy avatar" height="40" width="40" src="<?php echo getGravatar($comment['mail']); ?>">
 </div>
 <?php endif; ?>
           <div class="comment-body">
            <div class="comment-author">
            <?php echo $comment['poster']; ?>
            </div>
            <div class="comment-content">
              <p> <?php echo $comment['content']; ?> </p>            
            </div>
            <div class="comment-meta clearfix">
              <span class="comment-date"> <?php echo $comment['date']; ?> </span>
              <a class="comment-reply right"  href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"> <span>回复</span> </a>
            </div>
          </div>
        <?php blog_comments_children($comments, $comment['children']); ?>
		</li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php if($commentPageUrl){ ?>
 <nav id="page-nav">
 <div class="inner">
<?php echo $commentPageUrl;?>
</div>
  </nav>
<?php } ?>
<?php }?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children){
    $isGravatar = Option::get('isgravatar');
    foreach($children as $child):
    $comment = $comments[$child];
    $comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
    ?>
 <div class="comment-children">
  <ul>
    <li id="comment-<?php echo $comment['cid']; ?>" class="comment">
<?php if($isGravatar == 'y'): ?>
 <div class="comment-avatar">
<img class="lazy avatar" height="40" width="40" src="<?php echo getGravatar($comment['mail']); ?>">
 </div>
 <?php endif; ?>
   <div class="comment-body">
    <div class="comment-author">
      <span> <?php echo $comment['poster']; ?> </span>
     </div>
     <div class="comment-content">
     <p> <?php echo $comment['content']; ?> </p>
      </div>
     <div class="comment-meta clearfix">
     <span class="comment-date"> <?php echo $comment['date']; ?> </span>
     <?php if($comment['level'] < 4): ?><a  class="comment-reply right" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"> <span>回复</span> </a><?php endif; ?>
                      </div>
                    </div>
                    <?php blog_comments_children($comments, $comment['children']);?>
                     </li>
                </ul>                 
                </div>
	<?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
    if($allow_remark == 'y'): ?>
       <div id="comment-place">
    <div class="comment-post" id="comment-post">
<a name="respond"></a>
        <div class="comment-reply right selected cancel-reply" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()">取消回复</a></div>
  <div class="comments">
      <form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" class="comment-form">
      <?php if(ROLE == ROLE_VISITOR): ?>
      <div class="form-user clearfix ">
        <div class="form-item form-input">
          <input type="text" name="comname" title="昵称" class="text authorName" placeholder="昵称*" value="<?php echo $ckname; ?>" required="">
        </div>
        <div class="form-item form-input">
          <input type="text" name="commail" title="邮箱" class="text authorEmail" placeholder="邮箱*" value="<?php echo $ckmail; ?>" required="">
        </div>
        <div class="form-item form-input">
          <input type="text" name="comurl" title="网站" class="text authorUrl" placeholder="网站" value="<?php echo $ckurl; ?>">
        </div>
      </div>
      <?php else : ?>
      <div class="form-item form-welcome">
       <a href="./admin/?action=logout" class="form-edit">退出 »</a>
      </div>
      <?php endif; ?>
      <?php doAction('comment_head'); ?>
      <div class="form-item">
        <textarea class="form-textarea content" name="comment" rows="2" title="评论内容" placeholder="评论内容"></textarea>
      </div>       
      <div class="form-item clearfix">
       <?php echo $verifyCode; ?>
       <?php if(SEND_MAIL == 'Y' || REPLY_MAIL == 'Y')
	{ ?>
      <input value="y" type="checkbox" name="send">  允许邮件通知
      <?php } ?>
   <button class="btn btn-primary right" type="submit">发布评论</button>
      </div>
<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
    </form>
</div>
</div>
</div>
    <?php endif; ?>
<?php }?>
<?php
//blog-tool:判断是否是首页
function blog_tool_ishome(){
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){
        return true;
    } else {
        return FALSE;
    }
}
?>
<?php 
//解决页面标题重复
function page_tit($page) {
 if ($page>=2){ 
 echo ' _第'.$page.'页'; 
 }
 }
 ?>
