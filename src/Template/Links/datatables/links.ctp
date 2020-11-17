<?php

foreach ($results as $result) {
    $this->DataTables->prepareData([
        h($result->id),
        h($result->titile),
        $this->Html->link($result->website, $result->website, ['target' => '_BLANK']),
        $this->Html->link('<i class="fa fa-eye"></i>', '/start/' . base64_encode(base64_encode(base64_encode($result->id))), ['class' => 'btn btn-primary', 'escape' => false, 'target' => '_BLANK'])
    ]);
}
echo $this->DataTables->response();
