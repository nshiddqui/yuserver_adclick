<div class="box">
    <div class="box-header">
        <h3 class="box-title">Links</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <?= $this->DataTables->render('Links') ?>
    </div>
</div>
<?php $this->Html->scriptStart(['block' => 'script']);
echo `var needToLoad = false;
        document.addEventListener("visibilitychange", event => {
            if (document.visibilityState == "visible") {
                $('select[aria-controls="dtLinks"]').change();
            } else {
                needToLoad = true;
            }
        });
        if (needToLoad) {
            $('select[aria-controls="dtLinks"]').change();
        }`;
$this->Html->scriptEnd(); ?>