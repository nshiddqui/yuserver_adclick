<?php
$this->assign('bodyClass', 'login-page');
?>
<div class="login-box">
    <div class="login-logo">
        <?= $this->Html->link('<b>Adclick</b>YUSERVER', '/', ['escape' => false]) ?>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?= $this->Flash->render() ?>
        <?= $this->Form->create() ?>
        <div class="form-group has-feedback">
            <?= $this->Form->control('email', ['placeholder' => 'Email', 'label' => false]) ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $this->Form->control('password', ['placeholder' => 'Password', 'label' => false,]) ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label><?= $this->Form->checkbox('remeber_me', ['hiddenField' => false]) ?> Remember Me</label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= $this->Form->button('Sign In', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
            <!-- /.col -->
        </div>
        <?= $this->Form->end() ?>
        <?php if ($alreadyRegistered === 0) { ?>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="javascript:void(0)" class="btn btn-block btn-social btn-facebook btn-flat" disabled><i class="fa fa-facebook"></i> Sign in using
                    Facebook</a>
                <a href="javascript:void(0)" class="btn btn-block btn-social btn-google btn-flat" disabled><i class="fa fa-google-plus"></i> Sign in using
                    Google+</a>
            </div>
        <?php } ?>
        <hr>
        <!-- /.social-auth-links -->
        <?= $this->Html->link('I forgot my password', 'javascript:void(0)', ['disabled' => true]) ?><br>
        <?php if ($alreadyRegistered === 0) { ?>
            <?= $this->Html->link('Register a new membership', '/register', ['class' => 'text-center']) ?>
        <?php } ?>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->