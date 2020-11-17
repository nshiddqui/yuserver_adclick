<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Link'), ['action' => 'edit', $link->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Link'), ['action' => 'delete', $link->id], ['confirm' => __('Are you sure you want to delete # {0}?', $link->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Links'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Link'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Click Events'), ['controller' => 'ClickEvents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Click Event'), ['controller' => 'ClickEvents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="links view large-9 medium-8 columns content">
    <h3><?= h($link->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($link->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link') ?></th>
            <td><?= $this->Number->format($link->link) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= $this->Number->format($link->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= $this->Number->format($link->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('View') ?></th>
            <td><?= $this->Number->format($link->view) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Click Events') ?></h4>
        <?php if (!empty($link->click_events)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Link Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Ip Address') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($link->click_events as $clickEvents): ?>
            <tr>
                <td><?= h($clickEvents->id) ?></td>
                <td><?= h($clickEvents->user_id) ?></td>
                <td><?= h($clickEvents->link_id) ?></td>
                <td><?= h($clickEvents->created) ?></td>
                <td><?= h($clickEvents->modified) ?></td>
                <td><?= h($clickEvents->ip_address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ClickEvents', 'action' => 'view', $clickEvents->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ClickEvents', 'action' => 'edit', $clickEvents->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ClickEvents', 'action' => 'delete', $clickEvents->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clickEvents->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
