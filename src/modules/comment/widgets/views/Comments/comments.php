<div id="comments">

    <div class="block-title">Комментарии</div>

    <div id="commentsList">
        <?php $this->render('Comments/_tree', [
            'indent' => 0,
            'comments' => $comments,
            'parent' => 0,
            'user' => $user,
            'authorId' => $authorId,
        ]) ?>
    </div>

    <?php if (count($comments)) :
        ?><p class="reply-comment"><a href="#comment-form">Оставить комментарий</a>
    <?php endif; ?>

    <?php $this->render('Comments/_form', [
        'form' => $form,
        'user' => $user,
    ]); ?>

</div>

<script type="text/javascript">

    jQuery(document).on('click', '.ajax_like', function () {
        var t = jQuery(this);
        $.ajax({
            type: 'POST',
            url: $(this).data('url'),
            data: {'YII_CSRF_TOKEN': getCSRFToken()},
            success: function (data) {
                jQuery('#' + t.data('load')).html(data);
            },
            error: function (XHR) {
                alert(XHR.responseText);
            }
        });

        return false;
    });

    function setParentComment(id) {
        var parentField = jQuery('#comment-parent-id');
        if (typeof parentField != 'undefined') {
            parentField.val(id);
        }
    }

    function initComments() {
        jQuery('.comment .reply').each(function () {
            var span = $(this);
            span.replaceWith(jQuery('<a/>')
                .addClass('reply')
                .attr('data-id', span.data('id'))
                .attr('href', '#comment-form')
                .html(span.html())
            );
        });

        jQuery('.comment .reply').click(function () {
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

        jQuery('.reply-comment').click(function () {
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
