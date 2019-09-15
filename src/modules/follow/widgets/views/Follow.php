<p id="followMe" class="follow center"></p>

<script>
/*<![CDATA[*/
jQuery('#followMe').follow({
    assets_url: '<?php echo $assetsUrl; ?>'
})
/*]]>*/
</script>

<div class="subscribe-form">
    <form method="post" action="//elisdn.justclick.ru/subscribe/process/?rid%5B0%5D=blog" target="_blank"  onsubmit="return jc_chkscrfrm(this, false, false, false, false)">
        <div class="row">
            <input type="text" name="lead_name" placeholder="Ваше имя" />
        </div>
        <div class="row">
            <input type="email" name="lead_email" placeholder="Ваш Email" />
        </div>
        <div class="row button">
            <input type="submit" name="submit" value="Подписаться на статьи" />
        </div>
    </form>
</div>
<p class="what-there">Узнавайте о полезных статьях,<br />не пропускайте видеоуроки,<br />получайте бонусы.</p>

