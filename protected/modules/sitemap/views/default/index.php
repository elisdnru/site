<?php
/* @var $this DController */
/* @var $page Page */
/* @var $items CModel[] */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs=array(
	'Карта сайта',
);

if ($this->is(Access::ROLE_CONTROL))
{
	if ($page->id) if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Редактировать страницу', 'url'=>$this->createUrl('/page/pageAdmin/edit', array('id'=>$page->id)));
	$this->info = 'Карта сайта';
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<?php function sitemap_recursive(&$models, $parent=0) { ?>
	<ul>
		<?php foreach ($models as $model): ?>
			<?php if ($model->parent_id == $parent): ?>
				<li><a rel="nofollow" href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></a>
					<?php sitemap_recursive($models, $model->id); ?>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php } ?>

<?php foreach ($items as $models): ?>
	<?php sitemap_recursive($models); ?>
<?php endforeach; ?>
