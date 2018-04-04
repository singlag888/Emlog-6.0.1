<?php 
/**
 * 表情
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="smilelink" >
<a onclick="javascript:grin(':happy:')"> <i class="mdui-icon material-icons">&#xe815;</i> </a>
<a onclick="javascript:grin(':smile:')"> <i class="mdui-icon material-icons">&#xe813;</i> </a>
<a onclick="javascript:grin(':angry:')"> <i class="mdui-icon material-icons">&#xe811;</i> </a>
<a onclick="javascript:grin(':evil:')"> <i class="mdui-icon material-icons">&#xe814;</i> </a>
<a onclick="javascript:grin(':neutral:')"> <i class="mdui-icon material-icons">&#xe812;</i> </a>
</div>
<script>
function grin(tag) {
        var myField;
        tag = ' ' + tag + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
            myField = document.getElementById('comment');
        } else {
            return false;
        }
        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = tag;
            myField.focus();
        }
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            var cursorPos = endPos;
            myField.value = myField.value.substring(0, startPos)
                          + tag
                          + myField.value.substring(endPos, myField.value.length);
            cursorPos += tag.length;
            myField.focus();
            myField.selectionStart = cursorPos;
            myField.selectionEnd = cursorPos;
        }
        else {
            myField.value += tag;
            myField.focus();
        }
    }
    </script>