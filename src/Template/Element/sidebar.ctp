<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <?= $this->Html->image('user.png', ['class' => 'img-circle', 'alt' => 'User Image']) ?>
        </div>
        <div class="pull-left info">
            <p><?= @$authUser['name'] ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><?= $this->Html->link('<i class="fa fa-dashboard"></i><span>Dashboard</span>', '/dashboard', ['escape' => false]) ?></li>
        <li><?= $this->Html->link('<i class="fa fa-money"></i><span>Start Earning</span>', '/links', ['escape' => false]) ?></li>
    </ul>
</section>