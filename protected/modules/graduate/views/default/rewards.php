<?php
/** @var DController $this */
/** @var integer $year */
/** @var Page $page */
/** @var GraduateGraduate[] $graduates */

$this->pageTitle =  $page->pagetitle . ' медалисты';
$this->description = $page->description . ' медалисты';
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
    $page->title => $this->createUrl('index'),
    'Медалисты'
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('graduate')) $this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('/graduate/gradeAdmin/index'));
    if ($this->moduleAllowed('graduate')) $this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('/graduate/graduateAdmin/index'));

    $this->info = 'Выпускники года';
}
?>

<h1><a href="<?php echo $this->createUrl('index'); ?>">Выпускники</a> &rarr; Медалисты</h1>

<div class="graduates_rewards">

<?php $prev_year = 0; ?>

<div class="item">

<?php foreach ($graduates as $i=>$graduate): ?>

        <?php if ($graduate->grade->year != $prev_year): ?>
            <?php if ($i > 0): ?>
                </ul>
            </div>
            <div class="item">
            <?php endif; ?>
                <h2><?php echo $graduate->grade->year; ?></h2>
                <ul>
        <?php endif; ?>

            <li<?php if ($graduate->reward): ?> class="reward reward_<?php echo $graduate->getRewardAlias(); ?>" title="<?php echo $graduate->getRewardName(); ?> медаль"<?php endif; ?>>
                <?php if ($graduate->url): ?>
                    <span><?php echo CHtml::link(CHtml::encode($graduate->getFullName(), $graduate->url)); ?></span>
                <?php else: ?>
                    <span><?php echo CHtml::encode($graduate->getFullName()); ?></span>
                <?php endif; ?>
            </li>

    <?php $prev_year = $graduate->grade->year; ?>

<?php endforeach; ?>
</ul>
</div>

</div>
