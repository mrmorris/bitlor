<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post[]|\Cake\Collection\CollectionInterface $posts
 */
?>
<div class="posts index content">
    <?= $this->Html->link(__('New Post'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Posts') ?></h3>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <p><?= $post->body ?></p>
            <h6>Posted on: <?= h($post->created) ?></h6>
        </div>
    <?php endforeach; ?>

    <?php if (empty($posts->count())): ?>
        <div class="empty-state">
            <p>There are no posts yet</p>
        </div>
    <?php endif; ?>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
</div>
