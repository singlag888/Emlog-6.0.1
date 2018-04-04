<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
//widget：blogger
function widget_blogger($title){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $sta_cache = Cache::getInstance()->readCache('sta');
    $name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];
    $website = $user_cache[1]['website']; 
    $avatar = empty($user_cache[1]['avatar']) ? BLOG_URL.'avatar/default.jpg' : BLOG_URL. $user_cache[1]['avatar']; 
    ?>
<section class="widget">     
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<div class="info-header"> 
<span class="info-header-img"> <a href="<?php echo BLOG_URL; ?>"> <img src="<?php echo $avatar; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>"> </a> </span>
</div>
<div class="follow-me"> 
<?php echo $name; ?> <a href="<?php echo $website; ?>" target="_blank"> 文章(<?php echo $sta_cache['lognum']; ?>) </a> <a href="<?php echo BLOG_URL; ?>" target="_blank"> 评论(<?php echo $sta_cache['comnum']; ?>) </a>
</div>
</section> 
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
<section class="widget"> 
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <div id="calendar"></div>
        <script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
    </ul>
</section>    
<?php }?>
<?php
//widget：标签
function widget_tag($title){
    global $CACHE;
    $tag_cache = $CACHE->readCache('tags');?>
<section class="widget">     
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <?php foreach($tag_cache as $value): ?>
            <span style="font-size:<?php echo $value['fontsize']; ?>pt; line-height:30px;">
            <a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇文章"><?php echo $value['tagname']; ?></a></span>
        <?php endforeach; ?>
    </ul>
</section>    
<?php }?>
<?php
//widget：分类
function widget_sort($title){
    global $CACHE;
    $sort_cache = $CACHE->readCache('sort'); ?>
    <section class="widget">
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <?php
        foreach($sort_cache as $value):
            if ($value['pid'] != 0) continue;
        ?>
        <li class="category-level-0 category-parent">
        <a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
        <?php if (!empty($value['children'])): ?>
            <ul class="widget-list">
            <?php
            $children = $value['children'];
            foreach ($children as $key):
                $value = $sort_cache[$key];
            ?>
            <li class="category-level-1 category-child category-level-odd">
                <a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
            </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</section>    
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
    global $CACHE; 
    $com_cache = $CACHE->readCache('comment');
    ?>
<section class="widget">    
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <?php
        foreach($com_cache as $value):
        $url = Url::comment($value['gid'], $value['page'], $value['cid']);
        ?>
        <li id="comment"><?php echo $value['name']; ?>
        <br /><a href="<?php echo $url; ?>" data-no-instant><?php echo $value['content']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>    
<?php }?>
<?php
//widget：最新文章
function widget_newlog($title){
    global $CACHE; 
    $newLogs_cache = $CACHE->readCache('newlog');
    ?>
<section class="widget">    
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <?php foreach($newLogs_cache as $value): ?>
        <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>    
<?php }?>
<?php
//widget：热门文章
function widget_hotlog($title){
    $index_hotlognum = Option::get('index_hotlognum');
    $Log_Model = new Log_Model();
    $hotLogs = $Log_Model->getHotLog($index_hotlognum);?>
<section class="widget">    
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <?php foreach($hotLogs as $value): ?>
        <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>    
<?php }?>
<?php
//widget：随机文章
function widget_random_log($title){
	$index_randlognum = Option::get('index_randlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getRandLog($index_randlognum);?>
<section class="widget">	
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
</section>	
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
<section class="widget">
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">
        <input name="keyword" class="search" type="text" />
        </form>
    </ul>
</section>    
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
    global $CACHE; 
    $record_cache = $CACHE->readCache('record');
    ?>
<section class="widget">    
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
    <?php foreach($record_cache as $value): ?>
    <li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
    <?php endforeach; ?>
    </ul>
</section>    
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
<section class="widget">
 <h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <?php echo $content; ?>
    </ul>
</section>    
<?php } ?>
<?php
//widget：链接
function widget_link($title){
    global $CACHE; 
    $link_cache = $CACHE->readCache('link');
    if (!blog_tool_ishome()) return;
    ?>
<section class="widget">    
<h3 class="widget-title"> <?php echo $title; ?> </h3> 
<ul class="widget-list">
        <?php foreach($link_cache as $value): ?>
        <li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>    
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
                <a href="<?php echo BLOG_URL; ?>admin/" data-no-instant>管理</a>
                <a href="<?php echo BLOG_URL; ?>admin/?action=logout" data-no-instant>退出</a>
            <?php 
                continue;
            endif;
            $newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
            $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
            $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current' : 'common';
            ?>
            <?php if (!empty($value['children']) || !empty($value['childnavi'])) :?>
            <?php if (!empty($value['children'])):?>
                <a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>><?php echo $value['naviname']; ?> <b class="caret"></b></a>             <?php foreach ($value['children'] as $row){
            echo '<a href="'.Url::sort($row['sid']).'">'.$row['sortname'].'</a>';
                    }?>
               <?php endif;?>
                <?php if (!empty($value['childnavi'])) :?>
                <a href="<?php echo $value['url']; ?>" <?php echo $newtab;?> class="<?php echo $current_tab?>"><?php echo $value['naviname']; ?> <b class="caret"></b></a>
         <?php foreach ($value['childnavi'] as $row){
                            $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                            echo '<a href="' . $row['url'] . "\" $newtab >" . $row['naviname'].'</a>';
                    }?>
          <?php endif;?>
            </li>
            <?php else:?>
            <a href="<?php echo $value['url']; ?>" class="<?php echo $current_tab?>" <?php echo $newtab;?> <?php if($value['naviname']=="登录"){  ?> data-no-instant <?php } ?>><?php echo $value['naviname']; ?></a>
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
<a class=\"article-tag-list-link waves-effect waves-button\"  href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
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
<a class=\"article-tag-list-link waves-effect waves-button\" href=\"".Url::tag(rawurlencode($value))."\">".htmlspecialchars($value).'</a>';
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
    $des = $user_cache[$uid]['des'];
    $title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
    echo '<a href="'.Url::author($uid)."\" $title>$author</a>";
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
    extract($neighborLog);?>
    <?php if($prevLog || $nextLog){?>
<ul class="post-near"> 
    <?php if($prevLog):?>
   <li> 上一篇:  <a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a></li>
<?php else:?>
   <li>上一篇: 没有咯</li>
	<?php endif;?>
    <?php if($nextLog):?>
         <li>下一篇: <a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a></li>
<?php else:?>
    <li>下一篇: 没有咯</li>
	<?php endif;?>
</ul>
<?php } }?>
<?php
//blog：评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>
    <a name="comments"></a>
    <ol class="comment-list">
    <?php endif; ?>
    <?php
    $isGravatar = Option::get('isgravatar');
    foreach($commentStacks as $cid):
    $comment = $comments[$cid];
    $comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
    ?>
<li itemscope="" itemtype="http://schema.org/UserComments" id="comment-<?php echo $comment['cid']; ?>" class="comment-body comment-parent comment-odd">
 <div class="comment-author" itemprop="creator" itemscope="" itemtype="http://schema.org/Person"> 
<a name="<?php echo $comment['cid']; ?>"></a>
<?php if($isGravatar == 'y'): ?>
<span itemprop="image">
<img class="avatar" src="<?php echo getGravatar($comment['mail']); ?>" alt="WRZ" width="32" height="32">
</span> 
<?php endif; ?>
<cite class="fn" itemprop="name">
<?php echo $comment['poster']; ?> 
</cite> 
</div> 
<div class="comment-meta"> 
<a href="<?php echo $comment['cid']; ?>">
<time itemprop="commentTime" datetime="<?php echo $comment['date']; ?>"> <?php echo $comment['date']; ?> </time></a> 
</div> 
<div class="comment-content" itemprop="commentText"> 
<p> <?php echo $comment['content']; ?> </p> 
</div> 
<div class="comment-reply"> 
<a class="fastreply"  href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"> <i class="fa fa-commenting-o"></i> 回复</a> 
</div> 
<?php blog_comments_children($comments, $comment['children']); ?>
</li>
    <?php endforeach; ?>
</ol>
    <ol class="page-navigator"> 
        <?php echo $commentPageUrl;?>
    </ol>
<?php }?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children){
    $isGravatar = Option::get('isgravatar');
    foreach($children as $child):
    $comment = $comments[$child];
    $comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
    ?>
 <div class="comment-children" itemprop="discusses"> <ol class="comment-list">
<li itemscope="" itemtype="http://schema.org/UserComments" id="comment-<?php echo $comment['cid']; ?>" class="comment-body comment-parent comment-odd">
 <div class="comment-author" itemprop="creator" itemscope="" itemtype="http://schema.org/Person"> 
<a name="<?php echo $comment['cid']; ?>"></a>
<?php if($isGravatar == 'y'): ?>
<span itemprop="image">
<img class="avatar" src="<?php echo getGravatar($comment['mail']); ?>" alt="WRZ" width="32" height="32">
</span> 
<?php endif; ?>
<cite class="fn" itemprop="name">
<?php echo $comment['poster']; ?> 
</cite> 
</div> 
<div class="comment-meta"> 
<a href="<?php echo $comment['cid']; ?>">
<time itemprop="commentTime" datetime="<?php echo $comment['date']; ?>"> <?php echo $comment['date']; ?> </time></a> 
</div> 
<div class="comment-content" itemprop="commentText"> 
<p> <?php echo $comment['content']; ?> </p> 
</div> 
<div class="comment-reply"> 
<a class="fastreply" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"> <i class="fa fa-commenting-o"></i> 回复</a> 
</div> 
</li>
<?php blog_comments_children($comments, $comment['children']);?>
</ol>
</div>
<?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
    if($allow_remark == 'y'): ?>
<div id="comment-place">
<div id="comment-post" class="respond"> 
<div class="cancel-comment-reply cancel-reply" id="cancel-reply" style="display:none"> 
<a id="cancel-comment-reply-link" href="javascript:void(0);" onclick="cancelReply()">取消回复</a> 
</div> 
<h3 id="response">发表评论：<a name="respond"></a> </h3> 
<form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="comment-form" role="form"> 
<?php if(ROLE == ROLE_VISITOR): ?>
<p> 
<input type="text" name="comname" id="author" class="text" value="<?php echo $ckname; ?>"  required="" placeholder="昵称（必填）"> 
</p>
 <p> 
<input type="email" name="commail" id="mail" class="text" value="<?php echo $ckmail; ?>"  required="" placeholder="邮箱（用于展示Gravatar头像 必填） "> 
</p> 
<p> 
<input type="url" name="comurl" id="url" class="text" placeholder="网站（http:// ） " value="<?php echo $ckurl; ?>" > 
</p> 
<?php endif; ?>
<?php doAction('comment_head'); ?>
<?php if(SEND_MAIL == 'Y' || REPLY_MAIL == 'Y')
	{ ?>
<p>      <input value="y" type="checkbox" name="send"> 允许邮件通知</p>
<?php } ?>
<p> 
<textarea rows="8" cols="50" name="comment" id="textarea" class="textarea" required="" placeholder="不吐不快..."></textarea> 
</p> 
<p class="form-item">
<?php echo $verifyCode; ?>
</p>
<p> 
<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
<button type="submit" class="submit">评论</button> 
</p> 
</form> 
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