<?php
/** @var $grades GraduateGrade[] */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title,
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('graduate')) $this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('/graduate/graduateAdmin/index'));
    if ($this->moduleAllowed('graduate')) $this->admin[] = array('label'=>'Импорт выпускников', 'url'=>$this->createUrl('/graduate/graduateAdmin/importList'));
    if ($this->moduleAllowed('graduate')) $this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('/graduate/gradeAdmin/index'));
    if ($this->moduleAllowed('page')) if ($page->id) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/update', array('id'=>$page->id)));

    $this->info = 'Здесь собраны выпускники всех лет';
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<p><?php echo CHtml::link('Медалисты', array('rewards')); ?></p>

<?php if (Yii::app()->request->getParam('page', 1) > 1): ?><noindex><?php endif; ?>
<?php echo $this->decodeWidgets(trim($page->text_purified)); ?>
<?php if (Yii::app()->request->getParam('page', 1) > 1): ?></noindex><?php endif; ?>

<table class="grades diagramm">
    <tr>
        <th style="width:33%;">Год</th>
        <th style="width:34%;">Классы</th>
        <th style="width:33%;">Количество</th>
    </tr>

<?php $prev_year = 0; ?>
<?php $prev_number = 0; ?>
<?php $prev_count = 0; ?>
<?php $count = 0; ?>

<?php foreach ($grades as $i=>$grade): ?>

	<?php if ($grade->year != $prev_year): ?>
		<?php $prev_number = 0; ?>
		<?php $prev_count = $count; ?>
		<?php $count = 0; ?>
		<?php if ($i != 0): ?>
                </td>
                <td><?php echo $prev_count ? $prev_count : '' ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td><?php echo CHtml::link($grade->year, $grade->url); ?></td>
            <td>
    <?php endif; ?>

    <?php if ($grade->number != $prev_number): ?>
	    <?php echo CHtml::encode($grade->number);  ?>
    <?php endif; ?>

    <?php if ($grade->letter): ?>
        <?php echo CHtml::encode(mb_strtolower($grade->letter, Yii::app()->charset));  ?>
    <?php endif; ?>

	<?php $count += $grade->graduates_count; ?>

	<?php $prev_year = $grade->year; ?>
	<?php $prev_number = $grade->number; ?>

<?php endforeach; ?>

        </td>
        <td><?php echo $count ? $count : '' ?></td>
    </tr>
</tr>

</table>