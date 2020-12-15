<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class DashboardController extends AppController
{
    public function index()
    {
        $this->loadModel('ClickEvents');
        $total_clicks = $this->ClickEvents->find('all', [
            'conditions' => [
                'user_id' => $this->Auth->user('id')
            ]
        ])->count();
        $total_earns = $total_clicks * Configure::read('priceAmount');
        $today_clicks = $this->ClickEvents->find('all', [
            'conditions' => [
                'user_id' => $this->Auth->user('id'),
                'DATE(modified)' => date('Y-m-d')
            ]
        ])->count();
        $today_earns = $today_clicks * Configure::read('priceAmount');
        $this->ClickEvents->setPrimaryKey('day');
        $this->ClickEvents->setDisplayField('total');
        $click_event_groups = $this->ClickEvents->find('list', [
            'fields' => [
                'total' => 'COUNT(ClickEvents.id)',
                'day' => 'DAY(ClickEvents.modified)'
            ],
            'conditions' => [
                'user_id' => $this->Auth->user('id'),
                'MONTH(modified)' => date('m'),
                'YEAR(modified)' => date('Y')
            ],
            'group' => 'day'
        ])->toArray();
        $total_click_groups = [];
        $total_not_click_groups = [];
        for ($startDate = 1; $startDate <= date('d'); $startDate++) {
            if (isset($click_event_groups[$startDate])) {
                $total_click_groups[$startDate] = $click_event_groups[$startDate];
                $total_not_click_groups[$startDate] = 20 - $click_event_groups[$startDate];
            } else {
                $total_click_groups[$startDate] = 0;
                $total_not_click_groups[$startDate] = 20;
            }
        }
        $this->set(compact('total_clicks', 'total_earns', 'today_clicks', 'today_earns', 'total_click_groups', 'total_not_click_groups'));
    }
}
