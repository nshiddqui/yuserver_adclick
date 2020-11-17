<?php
$this->assign('bodyClass', 'register-page');
?>
<div class="register-box">
    <div class="register-logo">
        <?= $this->Html->link('<b>Adclick</b>YUSERVER', '/', ['escape' => false]) ?>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->create($user) ?>
        <div class="form-group has-feedback">
            <?= $this->Form->control('name', ['placeholder' => 'Full name', 'label' => false]) ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $this->Form->control('email', ['placeholder' => 'Email', 'label' => false]) ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $this->Form->control('password', ['placeholder' => 'Password', 'label' => false]) ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label><?= $this->Form->checkbox('remeber_me', ['hiddenField' => false, 'required' => true]) ?> I agree to the <?= $this->Html->link('terms', 'javascript:void(0)') ?></label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div>
            <!-- /.col -->
        </div>
        <?= $this->Form->end() ?>
        <hr>
        <?= $this->Html->link('I already have a membership', '/login', ['class' => 'text-center']) ?>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->