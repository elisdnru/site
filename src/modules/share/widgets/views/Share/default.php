<script>
(function () {
    if (window.pluso) if (typeof window.pluso.start == "function") return;
    if (window.ifpluso === undefined) {
        window.ifpluso = 1;
        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
        s.type = 'text/javascript';
        s.async = true;
        s.src = ('//share.pluso.ru/pluso-like.js');
        var h = d[g]('body')[0];
        h.appendChild(s);
    }
})();
</script>
<div class="pluso" style="margin-left: -4px"
     data-background="transparent"
     data-options="big,round,line,horizontal,nocounter,theme=04"
     data-services="vkontakte,twitter,facebook,google,odnoklassniki,evernote,email"
     data-url="<?php echo Yii::app()->request->getHostInfo() . '/' . Yii::app()->request->getPathInfo(); ?>"
></div>
