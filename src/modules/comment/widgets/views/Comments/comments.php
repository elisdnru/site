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

<script>
<?php ob_start() ?>

jQuery(function ($) {
    $(document).on('click', '.ajax_like', function () {
        var t = $(this)
        $.ajax({
            type: 'POST',
            url: $(this).data('url'),
            data: { 'YII_CSRF_TOKEN': getCSRFToken() },
            success: function (data) {
                $('#' + t.data('load')).html(data)
            },
            error: function (XHR) {
                alert(XHR.responseText)
            }
        })

        return false
    });

    function setParentComment (id) {
        var parentField = $('#comment-parent-id')
        if (typeof parentField != 'undefined') {
            parentField.val(id)
        }
    }

    function initComments () {
        $('.comment .reply').each(function () {
            var span = $(this)
            span.replaceWith($('<a/>')
                .addClass('reply')
                .attr('data-id', span.data('id'))
                .attr('href', '#comment-form')
                .html(span.html())
            )
        })

        $('.comment .reply').click(function () {
            var comment = $(this).parent().parent()
            var form = $('#comment-form')

            form.detach()
            form.css('margin-left', parseInt(comment.css('margin-left')) + 20)
            comment.after(form)

            var id = parseInt($(this).data('id'))

            form.find('form').attr('action', '#comment_' + id)

            setParentComment(id)

            return false
        })

        $('.reply-comment').click(function () {
            var form = $('#comment-form')
            form.detach()
            form.css('margin-left', 0)

            $(this).after(form)

            setParentComment(0)

            return false
        })
    }

    initComments()
});

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>
