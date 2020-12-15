<?php

namespace App\Controller;

use App\Controller\AppController;
use DataTables\Controller\DataTablesAjaxRequestTrait;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Security;

/**
 * Links Controller
 *
 * @property \App\Model\Table\LinksTable $Links
 *
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LinksController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('DataTables.DataTables');
        $auth_user_id = $this->request->getSession()->read('Auth.User.id');
        $this->DataTables->createConfig('Links')
            ->queryOptions([
                'join' => [
                    [
                        'table' => 'click_events',
                        'alias' => 'ClickEvents',
                        'type' => 'left',
                        'conditions' => [
                            'ClickEvents.link_id = Links.id',
                            'ClickEvents.user_id = ' . $auth_user_id
                        ]
                    ]
                ],
                'conditions' => [
                    'ClickEvents.ip_address IS NULL'
                ]
            ])
            ->column('Links.id', ['label' => 'Sr.'])
            ->column('Links.titile', ['label' => 'Title'])
            ->column('Links.website', ['label' => 'Website'])
            ->column('actions', ['label' => 'Actions', 'database' => false]);
    }
    /*
     * User DataTable Ajax Request Trait
     */
    use DataTablesAjaxRequestTrait;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        if ($this->request->is('api')) {
            $data = $this->paginate($this->Links);
            $this->set(compact('data'));
        } else {
            $this->DataTables->setViewVars('Links');
        }
    }

    /**
     * View method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $link = $this->Links->get($id, [
            'contain' => ['ClickEvents'],
        ]);

        $this->set('link', $link);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $link = $this->Links->newEntity();
        if ($this->request->is('post')) {
            $link = $this->Links->patchEntity($link, $this->request->getData());
            if ($this->Links->save($link)) {
                $this->Flash->success(__('The link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The link could not be saved. Please, try again.'));
        }
        $this->set(compact('link'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $link = $this->Links->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $link = $this->Links->patchEntity($link, $this->request->getData());
            if ($this->Links->save($link)) {
                $this->Flash->success(__('The link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The link could not be saved. Please, try again.'));
        }
        $this->set(compact('link'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $link = $this->Links->get($id);
        if ($this->Links->delete($link)) {
            $this->Flash->success(__('The link has been deleted.'));
        } else {
            $this->Flash->error(__('The link could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function start($id)
    {
        $id = base64_decode(base64_decode(base64_decode($id)));
        $link = $this->Links->get($id, [
            'contain' => ['ClickEvents'],
        ]);
        $auth_user_id = $this->Auth->user('id');
        $todaysCount = $this->Links->ClickEvents->find('all', [
            'conditions' => [
                'user_id' => $auth_user_id,
                'DATE(created)' => date('Y-m-d'),
                'ip_address IS NOT NULL'
            ]
        ])->count();
        if ($todaysCount > 20) {
            $this->Flash->error(__('Your todays earn limit is expired.'));
            return $this->redirect($this->referer());
        }
        $token = Security::hash($id);
        $alreadyExists = $this->Links->ClickEvents->find('all', [
            'conditions' => [
                'link_id' => $id,
                'user_id' => $auth_user_id
            ]
        ])->first();
        if ($alreadyExists == null) {
            $click_events = $this->Links->ClickEvents->newEntity();
            $click_events->link_id = $id;
            $click_events->token = $token;
            $click_events->user_id = $auth_user_id;
            $this->Links->ClickEvents->save($click_events);
        } else {
            if (empty($alreadyExists->ip_address)) {
                $click_events = $this->Links->ClickEvents->patchEntity($alreadyExists, ['token' => $token]);
                $this->Links->ClickEvents->save($click_events);
            } else {
                $this->Flash->error(__('This link is already clicked, please use another link.'));
                return $this->redirect($this->referer());
            }
        }
        $link_id = base64_encode(base64_encode(base64_encode($id)));
        $click_event_id = base64_encode(base64_encode(base64_encode($click_events->id)));
        $this->redirect($link->link . "?token={$token}&link={$link_id}&id={$click_event_id}");
    }
}
