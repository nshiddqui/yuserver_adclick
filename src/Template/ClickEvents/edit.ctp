<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClickEvent $clickEvent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clickEvent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clickEvent->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Click Events'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Links'), ['controller' => 'Links', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Link'), ['controller' => 'Links', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clickEvents form large-9 medium-8 columns content">
    <?= $this->Form->create($clickEvent) ?>
    <fieldset>
        <legend><?= __('Edit Click Event') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('link_id', ['options' => $links]);
            echo $this->Form->control('ip_address');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
