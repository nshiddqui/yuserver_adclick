<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClickEvent $clickEvent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Click Event'), ['action' => 'edit', $clickEvent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Click Event'), ['action' => 'delete', $clickEvent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clickEvent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Click Events'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Click Event'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Links'), ['controller' => 'Links', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Link'), ['controller' => 'Links', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clickEvents view large-9 medium-8 columns content">
    <h3><?= h($clickEvent->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $clickEvent->has('user') ? $this->Html->link($clickEvent->user->name, ['controller' => 'Users', 'action' => 'view', $clickEvent->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link') ?></th>
            <td><?= $clickEvent->has('link') ? $this->Html->link($clickEvent->link->id, ['controller' => 'Links', 'action' => 'view', $clickEvent->link->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ip Address') ?></th>
            <td><?= h($clickEvent->ip_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clickEvent->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($clickEvent->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($clickEvent->modified) ?></td>
        </tr>
    </table>
</div>
