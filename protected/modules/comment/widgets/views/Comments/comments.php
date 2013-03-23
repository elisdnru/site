<section id="comments">

    <h4>Комментарии</h4>

    <div id="commentsList">

        <?php function treeComments ($indent, $comments, $parent, $user, $authorId, $widget){ ?>
            <?php if (isset($comments[$parent])): ?>
            <?php foreach ($comments[$parent] as $comment): ?>

                <?php $widget->render('Comments/_comment', array(
                    'indent'=>$indent,
                    'comment'=>$comment,
                    'authorId'=>$authorId,
                    'user'=>$user,
                )); ?>

                <?php if ($indent < 100 && isset($comments[$comment->id]) && $comments[$comment->id]): ?>
                     <?php treeComments ($indent+1, $comments, $comment->id, $user, $authorId, $widget); ?>
                <?php endif; ?>

            <?php endforeach; ?>
            <?php endif; ?>
        <?php } ?>

        <?php treeComments (0, $comments, 0, $user, $authorId, $this); ?>

    </div>

    <?php if (count($comments)): ?><p class="reply-comment"><a rel="nofollow" href="#comment-form">Оставить комментарий</a></p><?php endif; ?>

    <?php $this->render('Comments/_form', array(
        'form'=>$form,
        'user'=>$user,
    )); ?>

</section>

<script type="text/javascript">

    function setParentComment(id)
    {
        var parentField = jQuery('#comment-parent-id');
        if (typeof parentField != 'undefined'){
            parentField.val(id);
        }
    }

    function initComments()
    {
        jQuery('.comment .reply').click(function()
        {
            var comment = jQuery(this).parent().parent();
            var form = jQuery('#comment-form');

            form.detach();
            form.css('margin-left', parseInt(comment.css('margin-left')) + 20);
            comment.after(form);

            var id = parseInt(jQuery(this).data('id'));

            form.find('form').attr('action', '#comment_' + id);

            setParentComment(id);


            return false;
        });

        jQuery('.reply-comment').click(function()
        {
            var form = jQuery('#comment-form');
            form.detach();
            form.css('margin-left', 0);

            jQuery(this).after(form);

            setParentComment(0);

            return false;
        });
    }

    initComments();

</script>
