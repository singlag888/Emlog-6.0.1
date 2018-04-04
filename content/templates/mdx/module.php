<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
//首页推荐使用分类顶置
function istop(){
	$DB = Database::getInstance();
	$sql=$DB->query("select * from emlog_blog where  hide='n' AND type='blog' AND sortop='y' order by date DESC limit 0,5");
	while($value = $DB->fetch_array($sql)){
?>
<a href="<?php echo Url::log($value['gid']);?>" rel="bookmark" title="<?php echo $value['title'];?>">
<li class="mdui-card mdui-color-theme LazyLoadSamePost mdui-hoverable" data-original="<?php echo $value['thumbs'];?>" style="background-image: url(<?php echo $value['thumbs'];?>);"><span class="mdx-same-posts-img"> <?php echo $value['title'];?> </span><i class="mdui-icon material-icons" title="前往阅读"> &#xe5c8; </i>
<div class="mdx-sp-fill">
<div>
</div>
</div>
</li>
</a>
<?php }  
 }  ?>
<?php
//内页感兴趣的文章
function random_log(){
$DB = Database::getInstance();
global $CACHE;
$sta_cache = $CACHE->readCache('sta');
$lognum = $sta_cache['lognum'];
 $start = $lognum > $num ? mt_rand(0, $lognum - $num): 0;
 $sql = $DB->query("SELECT * FROM " . DB_PREFIX . "blog WHERE hide='n' and checked='y' and type='blog' LIMIT $start, 5");
while($value = $DB->fetch_array($sql)){ ?>
<a href="<?php echo Url::log($value['gid']); ?>" rel="bookmark" title="<?php echo $value['title']; ?>">
<li class="mdui-card mdui-color-theme LazyLoadSamePost" data-original="<?php echo $value['thumbs'];?>" style="background-image: url(<?php echo $value['thumbs'];?>);"><span class="mdx-same-posts-img"> <?php echo $value['title']; ?> </span><i class="mdui-icon material-icons" title="前往阅读"> &#xe5c8; </i>
<div class="mdx-sp-fill">
<div>
</div>
</div>
</li>
</a>
<?php }
} ?>
<?php 
//emoji
function com_emoji($str) {
$data = array(
array(
'img' => '<i class="mdui-icon material-icons">&#xe815;</i>',
'title'=>'happy'
),
array(
'img' => '<i class="mdui-icon material-icons">&#xe813;</i>', 
'title'=>'smile'
),
array(
'img' => '<i class="mdui-icon material-icons">&#xe811;</i>', 
'title'=>'angry'
),
array(
'img' => '<i class="mdui-icon material-icons">&#xe814;</i>', 
'title'=>'evil'
),
array(
'img' => '<i class="mdui-icon material-icons">&#xe812;</i>', 
'title'=>'neutral'
),
);
foreach($data as $key=>$value) {
$str = str_replace(':'.$value['title'].':',$value['img'],$str);
}
return $str;
}
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
<div class="side-info-more">
<a href="/" class="avatar waves-effect waves-circle waves-light"><img src="<?php echo $avatar =preg_replace('/thum-|thum52-/','',$avatar)?>"></a>
<hgroup class="introduce">
<p class="nickname"> <?php echo $name; ?> </p>
<a href="mailto: <?php echo $mail; ?>" title="<?php echo $mail; ?>" class="mail"> <?php echo $des; ?> </a>
</hgroup>
</div>
<?php }?>
<?php
function sortLinks(){
	$db = Database::getInstance();
	global $CACHE;
	$sortlink_cache = $CACHE->readCache('sortlink');
foreach($sortlink_cache as $value){
$out .= '<h5 style="padding-top:10px;padding-bottom:10px">'.$sortlink_cache[$value['linksort_id']]['linksort_name'].'</h5> <div class="link-box">
';
$links = $db->query ("SELECT * FROM ".DB_PREFIX."link WHERE linksortid='$value[linksort_id]' AND hide='n' order by id DESC");
while ($row = $db->fetch_array($links)){
$sitepic = empty($row['sitepic']) ? BLOG_URL.'avatar/default.jpg' :$row['sitepic'];
$out .='<a href="'.$row['siteurl'].'" target="_blank" class="no-underline"><div class="thumb"><img width="200" height="200" src="'.$sitepic.'" alt="'.$row['description'].'"></div><div class="content"><div class="title"><span id="menu_index_6" name="menu_index_6"></span><h3> '.$row['sitename'].' </h3></div></div></a>';}
$out .='</div>';
}
echo $out;
}
?>
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
               <li class="menu-item menu-item-type-taxonomy menu-item-object-category mdui-list-item mdui-ripple"><a href="<?php echo BLOG_URL; ?>admin/"><i class="mdui-icon material-icons"> &#xe8b8; </i> 管理</a></li>
               <li class="menu-item menu-item-type-taxonomy menu-item-object-category mdui-list-item mdui-ripple"><a href="<?php echo BLOG_URL; ?>admin/?action=logout"><i class="mdui-icon material-icons"> &#xe8c6; </i> 退出</a></li>
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
            <?php else: ?>
            <li class="menu-item menu-item-type-taxonomy menu-item-object-category mdui-list-item mdui-ripple">
            <a href="<?php echo $value['url']; ?>" <?php echo $newtab;?> />
            <?php if($value['naviname']=="首页"){  ?>
             <i class="mdui-icon material-icons"> &#xe88a; </i> 
             <?php }elseif($value['naviname']=="微语"){  ?>  
             <i class="mdui-icon material-icons"> &#xe541; </i>  <?php }elseif($value['naviname']=="留言"){  ?>  
             <i class="mdui-icon material-icons"> &#xe0b7; </i>  
             <?php }elseif($value['naviname']=="关于"){  ?> <i class="mdui-icon material-icons"> &#xe0ba; </i>  
             <?php }elseif($value['naviname']=="归档"){  ?>  <i class="mdui-icon material-icons"> &#xe916; </i>  
             <?php }elseif($value['naviname']=="相册"){  ?>  <i class="mdui-icon material-icons"> &#xe3b0; </i> 
             <?php }elseif($value['naviname']=="友链"){  ?> <i class="mdui-icon material-icons"> &#xe250; </i>   
             <?php }elseif($value['naviname']=="登录"){  ?> <i class="mdui-icon material-icons"> &#xe897; </i> 
             <?php }else{  ?> 
             <i class="mdui-icon material-icons"> &#xe865; </i> 
             <?php } ?>  <?php echo $value['naviname']; ?></a>
            </li>
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
            $tag .= "
<a href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
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
                $tag .= "
<a href=\"".Url::tag(rawurlencode($value))."\">".htmlspecialchars($value).'</a></li>';
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
<div class="page-footer-nav mdui-color-theme">
		<div class="mdui-container">
			<div class="mdui-row">
			 <?php if($prevLog):?>
				<a href="<?php echo Url::log($prevLog['gid']) ?>" class="mdui-ripple mdui-color-theme mdui-col-xs-2 mdui-col-sm-6 page-footer-nav-left">
				<div class="page-footer-nav-text">
					<i class="mdui-icon material-icons"> &#xe5c4; </i><span class="page-footer-nav-direction mdui-hidden-xs-down">上一篇</span>
					<div class="page-footer-nav-chapter mdui-hidden-xs-down">
						<?php echo $prevLog['title'];?>
					</div>
				</div>
				</a>
				<?php endif;?>
				<?php if($nextLog):?>
				<a href="<?php echo Url::log($nextLog['gid']) ?>" class="mdui-ripple mdui-color-theme mdui-col-xs-10 mdui-col-sm-6 page-footer-nav-right">
				<div class="page-footer-nav-text">
					<i class="mdui-icon material-icons"> &#xe5c8;</i><span class="page-footer-nav-direction">下一篇</span>
		<div class="page-footer-nav-chapter">
			<?php echo $prevLog['title'];?>
					</div>
				</div>
				</a>
				<?php endif;?>
			</div>
		</div>
	</div>
<?php };?>    
<?php }?>
<?php
//blog：评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>
<a name="comments"></a>
      <?php endif; ?>
<ul class="mdui-list ajax-comments">
    <?php
    $isGravatar = Option::get('isgravatar');
    foreach($commentStacks as $cid):
    $comment = $comments[$cid];
    $comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
    ?>
<li class="mdui-list-item" id="li-comment-<?php echo $comment['cid']; ?>">
<a name="<?php echo $comment['cid']; ?>"></a>
<?php if($isGravatar == 'y'): ?>
<div class="mdui-list-item-avatar">
<img width="80" height="80" class="avatar avatar-80 photo LazyLoadPost" src="<?php echo getGravatar($comment['mail']); ?>">
</div>
<?php endif; ?>
<div class="mdui-list-item-content outbu" id="comment-<?php echo $comment['cid']; ?>">
<div class="mdui-list-item-title">
<?php echo $comment['poster']; ?>
</div>
<div class="mdui-list-item-text mdui-typo">
<p class="mdui-typo">
<?php echo com_emoji($comment['content']); ?>
</p>
</div>
<span class="mdx-reply-time"> <?php echo $comment['date']; ?></span>
<a rel="nofollow" class="comment-reply-link mdui-btn"   href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)" style="opacity: 0;"> <span>回复</span> </a>
</div>
<li class="mdui-divider-inset mdui-m-y-0"></li><li>
<?php blog_comments_children($comments, $comment['children']); ?>
<?php endforeach; ?>
</ul>
<?php if($commentPageUrl){ ?>
<nav id="comments-navi">
<?php echo $commentPageUrl;?>
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
<ul class="children">
<li class="mdui-list-item" id="li-comment-<?php echo $comment['cid']; ?>">
<?php if($isGravatar == 'y'): ?>
<div class="mdui-list-item-avatar">
<img width="80" height="80" class="avatar avatar-80 photo LazyLoadPost" src="<?php echo getGravatar($comment['mail']); ?>">
</div>
<?php endif; ?>
<div class="mdui-list-item-content outbu" id="comment-<?php echo $comment['cid']; ?>">
<div class="mdui-list-item-title">
<?php echo $comment['poster']; ?>
</div>
<div class="mdui-list-item-text mdui-typo">
<p class="mdui-typo">
<?php echo com_emoji($comment['content']); ?>
</p>
</div>
<span class="mdx-reply-time"> <?php echo $comment['date']; ?></span>
<?php if($comment['level'] < 4): ?>
<a rel="nofollow" class="comment-reply-link mdui-btn"   href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)" style="opacity: 0;"> <span>回复</span> </a>
<?php endif; ?>
</div>
</li>
<li class="mdui-divider-inset mdui-m-y-0"></li>
<li></li>
</ul>    
 <?php blog_comments_children($comments, $comment['children']);?>
<?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
    if($allow_remark == 'y'): ?>
    <div id="comment-place"> <div class="comment-post" id="comment-post">
 <div id="respond" class="comment-respond">
 <h3 id="reply-title" class="comment-reply-title">发表评论 <small class="cancel-reply" id="cancel-reply" style="display:none"><a rel="nofollow" id="cancel-comment-reply-link" href="javascript:void(0);" onclick="cancelReply()">取消回复</a></small></h3>
<a name="respond"></a>
 <form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform"><div class="mdui-textfield mdui-textfield-floating-label mdx-emj-inp">
<i class="mdui-icon material-icons"> &#xe0d8; </i><label class="mdui-textfield-label">说点什么...</label>
<textarea class="mdui-textfield-input" name="comment"  id="comment"></textarea>
</div>
<i class="mdui-icon material-icons mdx-emj-cli"> &#xe420; </i>
<div class="mdx-emj">
<?php require_once(View::getView('smile'));?>
</div>
<?php doAction('comment_head'); ?>		
<?php if(ROLE == ROLE_VISITOR): ?>
<div class="mdui-textfield mdui-textfield-floating-label disfir disfirleft" style="display:none">
<i class="mdui-icon material-icons"> &#xe853; </i><label class="mdui-textfield-label">昵称</label><input class="mdui-textfield-input" type="text" id="author" name="comname" value="<?php echo $ckname; ?>" required="">
</div>
<div class="mdui-textfield mdui-textfield-floating-label disfir disfirright" style="display:none">
<i class="mdui-icon material-icons"> &#xe0be; </i><label class="mdui-textfield-label">邮箱</label><input class="mdui-textfield-input" type="email" id="email" name="commail" value="<?php echo $ckmail; ?>" required="">
</div>
<div class="mdui-textfield mdui-textfield-floating-label commurl" style="display:none">
<i class="mdui-icon material-icons"> &#xe250; </i><label class="mdui-textfield-label">网站（如果有）http(s)://</label>
<input class="mdui-textfield-input" type="url" id="url" name="comurl" value="<?php echo $ckurl; ?>">
</div>
 <?php endif; ?>
<p class="form-submit">
<?php echo $verifyCode; ?>
<?php if(SEND_MAIL == 'Y' || REPLY_MAIL == 'Y')
	{ ?>
      <input value="y" type="checkbox" name="send">  允许邮件通知
 <?php } ?>
<input name="submit" type="submit" id="submit" class="submit" value="发射">
<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
</p>
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


