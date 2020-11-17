<?php
/**
 * Copyright (c) 2018. Allan Carvalho
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace DataTables\View;

use App\View\AppView;
use Cake\Utility\Inflector;

/**
 * CakePHP DataTablesView
 *
 * @author allan
 */
class DataTablesView extends AppView
{
    public $layout = 'DataTables.datatables';

    public function initialize()
    {
        parent::initialize();
        $this->autoLayout = false;
        $this->setTemplatePath(
            (!empty($this->request->getParam('prefix')) ? Inflector::camelize($this->request->getParam('prefix')) . DS : '') . $this->request->getParam('controller') . DS . 'datatables');
        $this->loadHelper('DataTables.DataTables');
    }
}
