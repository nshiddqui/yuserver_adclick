<?php
$this->Html->scriptStart(['block' => true]);
echo "var totalDays = JSON.parse('" . json_encode(array_keys($total_not_click_groups)) . "');";
echo "var totalNotClicksGroup = JSON.parse('" . json_encode($total_not_click_groups) . "');";
echo "var totalClicksGroup = JSON.parse('" . json_encode($total_click_groups) . "');";
$this->Html->scriptEnd();
?>
<?= $this->Html->component('chart.js/Chart', 'script', ['block' => true]) ?>
<?= $this->Html->script('pages/dashboard', ['block' => true]) ?>
<!-- Info boxes -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Today's Click</span>
                <span class="info-box-number"><?= $this->Number->format($today_clicks) ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Today's Earning</span>
                <span class="info-box-number"><?= $this->Number->currency($today_earns, 'INR') ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->


    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total's Click</span>
                <span class="info-box-number"><?= $this->Number->format($total_clicks) ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total's Earning</span>
                <span class="info-box-number"><?= $this->Number->currency($total_earns, 'INR') ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Monthly Click Report</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <p class="text-center">
                    <strong>Clicking: Current Month</strong>
                </p>

                <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="earningChart" style="height: 180px;"></canvas>
                </div>
                <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.box-body -->
</div>