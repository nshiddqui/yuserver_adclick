<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClickEvent[]|\Cake\Collection\CollectionInterface $clickEvents
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Click Event'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Links'), ['controller' => 'Links', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Link'), ['controller' => 'Links', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clickEvents index large-9 medium-8 columns content">
    <h3><?= __('Click Events') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('link_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ip_address') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clickEvents as $clickEvent): ?>
            <tr>
                <td><?= $this->Number->format($clickEvent->id) ?></td>
                <td><?= $clickEvent->has('user') ? $this->Html->link($clickEvent->user->name, ['controller' => 'Users', 'action' => 'view', $clickEvent->user->id]) : '' ?></td>
                <td><?= $clickEvent->has('link') ? $this->Html->link($clickEvent->link->id, ['controller' => 'Links', 'action' => 'view', $clickEvent->link->id]) : '' ?></td>
                <td><?= h($clickEvent->created) ?></td>
                <td><?= h($clickEvent->modified) ?></td>
                <td><?= h($clickEvent->ip_address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clickEvent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clickEvent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clickEvent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clickEvent->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
