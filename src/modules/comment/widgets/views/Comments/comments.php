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

(function () {
    document.addEventListener('click', function (event) {
        if (!event.target.matches('.ajax_like')) {
            return;
        }

        event.preventDefault();

        var data = new FormData();
        data.set('YII_CSRF_TOKEN', getCSRFToken());
        axios({
            method: 'post',
            url: event.target.dataset.url,
            data: data,
            config: { headers: {
                'Content-Type': 'multipart/form-data'
            }}
        })
            .then(function (response) {
                document.querySelector('#' + event.target.dataset.load).innerHTML = response.data
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    function setParentComment (id) {
        var parentField = document.querySelector('#comment-parent-id')
        if (typeof parentField != 'undefined') {
            parentField.value = id
        }
    }

    function initComments () {
        var form = document.querySelector('#comment-form')

        var replySpans = document.querySelectorAll('.comment .reply');

        [].forEach.call(replySpans, function (span) {
            var a = document.createElement('a')
            a.classList.add('reply')
            a.dataset.id = span.dataset.id
            a.href = '#comment-form'
            a.innerText = span.innerText
            span.parentNode.replaceChild(a, span)
        })

        var replyLinks = document.querySelectorAll('.comment .reply');
        [].forEach.call(replyLinks, function (link) {
            link.addEventListener('click', function () {
                var comment = link.parentNode.parentNode

                form.parentElement.removeChild(form)
                form.style['margin-left'] = (parseInt(comment.style['margin-left']) + 20) + 'px'
                comment.after(form)

                var id = parseInt(this.dataset.id)

                form.querySelector('form').setAttribute('action', '#comment_' + id)

                setParentComment(id)

                return false
            })
        })

        var replyToAll = document.querySelector('.reply-comment');
        if (replyToAll) {
            replyToAll.addEventListener('click', function () {
                form.parentElement.removeChild(form)
                form.style['margin-left'] = 0
                this.after(form)
                setParentComment(0)
                return false
            })
        }
    }

    initComments()
})();

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>
