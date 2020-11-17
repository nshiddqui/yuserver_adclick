<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * ClickEvents Controller
 *
 * @property \App\Model\Table\ClickEventsTable $ClickEvents
 *
 * @method \App\Model\Entity\ClickEvent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClickEventsController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->Auth->allow(['addUserClick']);
        parent::beforeFilter($event);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Links'],
        ];
        $clickEvents = $this->paginate($this->ClickEvents);

        $this->set(compact('clickEvents'));
    }

    /**
     * View method
     *
     * @param string|null $id Click Event id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clickEvent = $this->ClickEvents->get($id, [
            'contain' => ['Users', 'Links'],
        ]);

        $this->set('clickEvent', $clickEvent);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clickEvent = $this->ClickEvents->newEntity();
        if ($this->request->is('post')) {
            $clickEvent = $this->ClickEvents->patchEntity($clickEvent, $this->request->getData());
            if ($this->ClickEvents->save($clickEvent)) {
                $this->Flash->success(__('The click event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The click event could not be saved. Please, try again.'));
        }
        $users = $this->ClickEvents->Users->find('list', ['limit' => 200]);
        $links = $this->ClickEvents->Links->find('list', ['limit' => 200]);
        $this->set(compact('clickEvent', 'users', 'links'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Click Event id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clickEvent = $this->ClickEvents->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clickEvent = $this->ClickEvents->patchEntity($clickEvent, $this->request->getData());
            if ($this->ClickEvents->save($clickEvent)) {
                $this->Flash->success(__('The click event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The click event could not be saved. Please, try again.'));
        }
        $users = $this->ClickEvents->Users->find('list', ['limit' => 200]);
        $links = $this->ClickEvents->Links->find('list', ['limit' => 200]);
        $this->set(compact('clickEvent', 'users', 'links'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Click Event id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clickEvent = $this->ClickEvents->get($id);
        if ($this->ClickEvents->delete($clickEvent)) {
            $this->Flash->success(__('The click event has been deleted.'));
        } else {
            $this->Flash->error(__('The click event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function addUserClick()
    {
        $this->request->allowMethod('api');
        $data = $this->request->getQueryParams();
        foreach (['token', 'link', 'id'] as $variable) {
            if (empty($data[$variable])) {
                $this->Flash->error(__('{0} field is required.', $variable));
                return;
            }
        }
        $id = base64_decode(base64_decode(base64_decode($data['id'])));
        $link = base64_decode(base64_decode(base64_decode($data['link'])));
        $click_events = $this->ClickEvents->find('all', [
            'conditions' => [
                'id' => $id,
                'token' => $data['token'],
                'link_id' => $link,
                'ClickEvents.ip_address IS NULL'
            ]
        ]);
        if ($click_events->count() === 0) {
            $this->Flash->error(__('This adclick is not exists, please use another link.'));
            return;
        }
        $click_events = $this->ClickEvents->patchEntity($click_events->first(), ['ip_address' => $this->request->clientIp()]);
        if ($this->ClickEvents->save($click_events)) {
            $this->Flash->success(__('Adclick has been added.'));
        } else {
            $this->Flash->error(__('Adclick could not be added. Please, try again.'));
        }
    }
}
