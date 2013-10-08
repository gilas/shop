<?php
/*
 * Created By : Mohammad Razzaghi
 * Email : 1razzaghi@gmail.com
 * Blog : http://bigitblog.ir
 * Social Networks : 
 *          http://facebook.com/1razzaghi
 *          http://twitter.com/1razzaghi
 */

class CommentHelper extends AppHelper {

    public $helpers = array('Html', 'Form');

    private function _haveChild(array $inComment) {
        if ($inComment['children'] != NULL)
            return TRUE;
        return FALSE;
    }

    private function _haveParent(array $inComment) {
        if ($inComment['Comment']['parent_id'] != 0)
            return TRUE;
        return FALSE;
    }

    public function showContentComments(array $comments) {
        foreach ($comments as $comment) {
            ?>
            <blockquote>
                <?php
                if ($comment['Comment']['published']) {
                    ?>
                    <span class="label label-success">منتشر شده</span>
                    <?php
                } else {
                    ?>
                    <span class="label label-important">منتشر نشده</span>
                    <?php
                }
                ?>

                <small>نوشته شده توسط : 
                    <?php echo $comment['Comment']['name'] ?> در 
                    <?php echo Jalali::niceShort($comment['Comment']['created']); ?>
                </small>
                <small>
                    <?php
                    if (!empty($comment['Comment']['website']))
                        echo $this->Html->link('وبسایت', $comment['Comment']['website'], array('target' => '_blank'));
                    else
                        echo 'وبسایت';
                    ?> | 
                    <?php
                    if (!empty($comment['Comment']['email']))
                        echo $this->Html->link('پست الکترونیک', 'mailto:' . $comment['Comment']['email']);
                    else
                        echo 'پست الکترونیک';
                    ?>
                </small>
                <?php echo $comment['Comment']['content'] ?>
                <div style="float: left">
                    <?php
                    if ($comment['Comment']['published'])
                        echo $this->Form->postLink('عدم انتشار', array('action' => 'unpublish_comment', $comment['Comment']['id'], 'admin' => TRUE), array('class' => 'btn btn-warning'));
                    else
                        echo $this->Form->postLink('انتشار', array('action' => 'publish_comment', $comment['Comment']['id'], 'admin' => TRUE), array('class' => 'btn btn-success'));
                    ?> | 
                    <?php echo $this->Html->link('ویرایش', '#', array('class' => 'btn btn-info', 'id' => 'edit', 'comment_id' => $comment['Comment']['id'])); ?> |
                    <?php echo $this->Form->postLink('حذف', array('action' => 'delete', $comment['Comment']['id'], 'admin' => TRUE), array('class' => 'btn btn-danger'), 'آیا از حذف این آیتم مطمئن هستید؟'); ?>
                </div>
                <hr />
                <?php
                if ($this->_haveChild($comment))
                    $this->showContentComments($comment['children']);
                ?>

            </blockquote>

            <?php
        }
    }

    public function showAllComments($comments) {
        foreach ($comments as $comment) {
            ?>
            <div>
                <a name="comment-id-<?php echo $comment['Comment']['id'] ?>"></a>
                <blockquote>
                    <?php
                    if ($comment['Comment']['published']) {
                        ?>
                        <span class="label label-success">منتشر شده</span>
                        <?php
                    } else {
                        ?>
                        <span class="label label-important">منتشر نشده</span>
                        <?php
                    }
                    ?>

                    <small>نوشته شده توسط : 
                        <?php echo $comment['Comment']['name'] ?> در 
                        <?php echo Jalali::niceShort($comment['Comment']['created']); ?>
                    </small>
                    <small>
                        <?php
                        if (!empty($comment['Comment']['website']))
                            echo $this->Html->link('وبسایت', $comment['Comment']['website'], array('target' => '_blank'));
                        else
                            echo 'وبسایت';
                        ?> | 
                        <?php
                        if (!empty($comment['Comment']['email']))
                            echo $this->Html->link('پست الکترونیک', 'mailto:' . $comment['Comment']['email']);
                        else
                            echo 'پست الکترونیک';
                        ?>
                    </small>
                    <div><?php echo $comment['Comment']['content'] ?></div>
                    <div class="comment-details">
                        <small>
                            ارسال شده در : 
                            <?php
                            echo $this->Html->link($comment['Content']['title'], array('controller' => 'Contents', 'action' => 'view', $comment['Content']['id'], 'admin' => FALSE), array('target' => '_blank'));
                            if ($this->_haveParent($comment)) {
                                ?> | در پاسخ به : 
                                <?php
                                echo $this->Html->link($comment['Comment']['parent_name'], '#comment-id-' . $comment['Comment']['parent_id']);
                            }
                            ?>
                        </small>
                        <div style="float: left">
                            <?php
                            if ($comment['Comment']['published'])
                                echo $this->Form->postLink('عدم انتشار', array('action' => 'unpublish_comment', $comment['Comment']['id'], 'admin' => TRUE), array('class' => 'btn btn-warning'));
                            else
                                echo $this->Form->postLink('انتشار', array('action' => 'publish_comment', $comment['Comment']['id'], 'admin' => TRUE), array('class' => 'btn btn-success'));
                            ?> | <a href="#" onclick="window.open('<?php echo $this->Html->url(array('action' => 'editComment', $comment['Comment']['id'], 'admin' => TRUE)) ?>','popup','width=400,height=500,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=50,top=0'); return false" class="btn btn-info">ویرایش</a>
                            <?php
                            //echo $this->Html->link('ویرایش', '#', array('class' => 'btn btn-info', 'id' => 'edit', 'comment_id' => $comment['Comment']['id']));
                            ?> | <a href="#" onclick="window.open('<?php echo $this->Html->url(array('action' => 'replyComment', $comment['Comment']['id'], 'admin' => TRUE)) ?>','popup','width=400,height=400,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=50,top=0'); return false" class="btn btn-primary">پاسخ</a>
                            <?php
                            //echo $this->Html->link('پاسخ', '#', array('onclick' => 'window.open('','popup','width=350,height=350,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=50,top=0'); return false', 'class' => 'btn btn-primary'));
                            ?> | 
                            <?php
                            echo $this->Form->postLink('حذف', array('action' => 'delete', $comment['Comment']['id'], 'admin' => TRUE), array('class' => 'btn btn-danger'), 'آیا از حذف این آیتم مطمئن هستید؟');
                            ?>

                        </div>
                    </div>
                </blockquote>
            </div>
            <hr />
            <?php
        }
    }

}
?>
