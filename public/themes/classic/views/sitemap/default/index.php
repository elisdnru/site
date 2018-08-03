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

<div class="sitemap">

	<?php function sitemap_recursive(&$models, $parent=0) { ?>
		<ul>
			<?php foreach ($models as $model): ?>
				<?php if ($model->parent_id == $parent && $model->url != '/prices' ): ?>
					<li><span data-href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></span>
						<?php sitemap_recursive($models, $model->id); ?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	<?php } ?>

	<!--noindex-->
	<h2>Страницы</h2>
	<?php sitemap_recursive($items['Page']); ?>
	<!--/noindex-->

	<h2>Записи в блоге</h2>
	<ul>
		<?php foreach ($items['BlogPost'] as $model): ?>
			<li><a href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></a></li>
		<?php endforeach; ?>
	</ul>

	<!--noindex-->
	<h2>Портфолио</h2>
	<ul>
		<?php foreach ($items['PortfolioWork'] as $model): ?>
			<li><span data-href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></span></li>
		<?php endforeach; ?>
	</ul>
	<!--/noindex-->

</div>
