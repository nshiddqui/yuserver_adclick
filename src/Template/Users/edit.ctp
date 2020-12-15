<?= $this->Form->create($user) ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Profile</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('email', ['readonly' => true]);
        echo $this->Form->control('password', ['value' => '', 'required' => false]);
        $this->Form->button(__('Update'))
        ?>
    </div>
</div>
<?= $this->Form->button(__('Submit')) ?>