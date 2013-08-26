<?php
/** @var DController $this */
/** @var integer $year */
/** @var Page $page */
/** @var GraduateGrade[] $grades */

$this->pageTitle =  $page->pagetitle . ' ' . $year;
$this->description = $page->description . ' ' . $year;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('index'),
    $year . ' год'
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('graduate')) $this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('/graduate/gradeAdmin/index'));
    if ($this->moduleAllowed('graduate')) $this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('/graduate/graduateAdmin/index'));

    $this->info = 'Выпускники года';
}
?>

<h1><a href="<?php echo $this->createUrl('index'); ?>">Выпускники</a> &rarr; <?php echo CHtml::encode($year); ?> год</h1>

<div class="graduates">

<?php foreach ($grades as $grade): ?>

    <div class="item">
        <?php if ((int)$grade->number): ?>
            <h2><?php echo $grade->number; ?> &laquo;<?php echo $grade->letter; ?>&raquo; класс</h2>
        <?php endif; ?>

        <?php if ($grade->teacher): ?>
            <dl>
                <dt>Классный руководитель:</dt>
                <dd><?php echo CHtml::encode($grade->teacher); ?></dd>
            </dl>
        <?php endif; ?>

        <ol>
        <?php foreach ($grade->graduates as $graduate): ?>
            <li<?php if ($graduate->reward): ?> class="reward reward_<?php echo $graduate->getRewardAlias(); ?>" title="<?php echo $graduate->getRewardName(); ?> медаль"<?php endif; ?>>
                <?php if ($graduate->url): ?>
                    <span><?php echo CHtml::link(CHtml::encode($graduate->getFullName(), $graduate->url)); ?></span>
                <?php else: ?>
                    <span><?php echo CHtml::encode($graduate->getFullName()); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ol>
    </div>

<?php endforeach; ?>

</div>
