<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link[]|\Cake\Collection\CollectionInterface $links
 */
?>
<div class="links index content">
    <?= $this->Html->link(__('New Link'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Links') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('views') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($links as $link): ?>
                <tr>
                    <td><?= $this->Number->format($link->id) ?></td>
                    <td><?= h($link->slug) ?></td>
                    <td><?= h($link->url) ?></td>
                    <td><?= $this->Number->format($link->views) ?></td>
                    <td><?= h($link->created) ?></td>
                    <td><?= h($link->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $link->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $link->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $link->id], ['confirm' => __('Are you sure you want to delete # {0}?', $link->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
