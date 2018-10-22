<?php
$this->pageTitle = $model->title;
$this->description = $model->description;
$this->keywords = $model->keywords;

$this->breadcrumbs = [];
if ($model->page) {
    $this->breadcrumbs = $model->page->getBreadcrumbs(true);
}
$this->breadcrumbs[] = $model->title;

if ($this->is(Access::ROLE_CONTROL)) {
    $this->admin[] = ['label' => 'Редактировать', 'url' => $this->createUrl('/new/newAdmin/update', ['id' => $model->id])];
    if ($this->moduleAllowed('newsgallery')) {
        $this->admin[] = ['label' => 'Галереи', 'url' => $this->createUrl('/newsgallery/galleryAdmin/index')];
    }
    if ($this->moduleAllowed('newsgallery')) {
        if ($model->gallery) {
            $this->admin[] = ['label' => 'Редактировать галерею', 'url' => $this->createUrl('/newsgallery/galleryAdmin/files', ['id' => $model->gallery_id])];
        }
    }
    if ($this->moduleAllowed('page')) {
        $this->admin[] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/pageAdmin/update', ['id' => $model->page_id])];
    }
    $this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('/new/newAdmin/index')];
    if ($this->moduleAllowed('comment')) {
        $this->admin[] = ['label' => 'Комментарии (' . $model->comments_new_count . ' ' . DNumberHelper::Plural($model->comments_new_count, ['новый', 'новых', 'новых']) . ')', 'url' => $this->createUrl('/new/commentAdmin/index', ['id' => $model->id])];
    }

    $this->info = 'Нажмите «Редактировать» чтобы изменить статью';
} ?>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<?php if (!$model->public) : ?>
    <div class="flash-error">Внимание! Новость скрыта от публикации!</div>
<?php endif; ?>
