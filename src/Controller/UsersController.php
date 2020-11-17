<?php

namespace App\Controller;

use App\Controller\AppController;
use DataTables\Controller\DataTablesAjaxRequestTrait;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Mailer\MailerAwareTrait;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->Auth->allow(['logout', 'forgot', 'login', 'register']);
        parent::beforeFilter($event);
    }

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('DataTables.DataTables');
        $this->DataTables->createConfig('Users')
            ->databaseColumn('Users.id')
            ->queryOptions([
                'conditions' => [
                    'Users.role' => '2'
                ]
            ])
            ->column('Users.client_name', ['label' => 'Client Name'])
            ->column('Users.email', ['label' => 'Email'])
            ->column('Users.status', ['label' => 'Status'])
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
        if ($this->Auth->user('role') != '1') {
            throw new UnauthorizedException(__('You are not alowed to access this page'));
        }
        if ($this->request->is('api')) {
            $data = $this->paginate($this->Users);
            $this->set(compact('data'));
        } else {
            $this->DataTables->setViewVars('Users');
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($this->Auth->user('role') != '1') {
            throw new UnauthorizedException(__('You are not alowed to access this page'));
        }
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->Auth->user('role') != '1') {
            throw new UnauthorizedException(__('You are not alowed to access this page'));
        }
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($this->Auth->user('role') != '1') {
            throw new UnauthorizedException(__('You are not alowed to access this page'));
        }
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (empty($data['password'])) {
                unset($data['password']);
            }
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if ($this->Auth->user('role') != '1') {
            throw new UnauthorizedException(__('You are not alowed to access this page'));
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $alreadyRegistered = $this->Users->findByIpAddress($this->request->clientIp());
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                if ($user['status'] === true) {
                    $this->Auth->setUser($user);
                    if ($this->request->is('api')) {
                        $this->Api->login($user);
                    }
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error(__('This user not activated, please contact our administrator.'));
                }
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
        $this->set('alreadyRegistered', $alreadyRegistered->count());
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function active($id, $code)
    {
        if ($this->Auth->user('role') != '1') {
            throw new UnauthorizedException(__('You are not alowed to access this page'));
        }
        $this->request->allowMethod(['post']);
        $this->loadModel('Users');
        $users = $this->Users->get($id);
        $users->status = $code;
        if ($this->Users->save($users)) {
            $this->Flash->success(__('The user has been ' . ($code == '1' ? 'Activate' : 'Deactivated') . '.'));
        } else {
            $this->Flash->error(__('The user could not be  ' . ($code == '1' ? 'Activate' : 'Deactivated') . '. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Forgot Password method
     *
     * @return \Cake\Http\Response|null
     */
    use MailerAwareTrait;

    public function forgot()
    {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            if (!empty($email)) {
                $userData = $this->Users->findByEmail($email);
                if ($userData->count()) {
                    $userDetails = $userData->first();
                    $userDetails->token = $this->Users->tokenUpdate($email);
                    $emailObj = $this->getMailer('User');
                    if ($emailObj->send('resetPassword', [$userDetails])) {
                        $this->Flash->success(__('Password reset link has been sent on your email.It will expire in 1 hour'));
                        $this->redirect($this->referer());
                    } else {
                        $this->Flash->error(__('Reset Password could not be sent on your email. Please, try again.'));
                    }
                } else {
                    $this->Flash->error(__('Provided Username not exists.'));
                }
            } else {
                $this->Flash->error(__('Please enter Username.'));
            }
        }
        $this->viewBuilder()->setLayout(false);
    }

    /**
     * Reset Password method
     *
     * @return \Cake\Http\Response|null
     */
    public function reset($encodedId, ...$tokenParam)
    {
        $token = implode('/', $tokenParam);
        $id = base64_decode(base64_decode($encodedId));
        $userDetails = $this->Users->find('all', [
            'conditions' => [
                'id' => $id,
                'token' => $token,
                'token_expire >' => date('Y-m-d h:i:s')
            ]
        ]);
        if (!$userDetails->count()) {
            $this->Flash->error(__('Token expire or not authorized.'));
            return $this->redirect('/');
        }
        if ($this->request->is(['post', 'put'])) {
            $password = $this->request->getData('password');
            if (strlen($password) > 5) {
                $userDetails = $userDetails->first();
                $userDetails->password = $password;
                $userDetails->token = null;
                $userDetails->token_expire = null;
                $this->Users->save($userDetails);
                $this->Flash->success(__('Password change successfull.'));
                $this->redirect('/');
            } else {
                $this->Flash->error(__('Provided password length is less than 6.'));
            }
        }
        $this->set(compact('userDetails'));
        $this->viewBuilder()->setLayout(false);
    }

    public function register()
    {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $alreadyRegistered = $this->Users->findByIpAddress($this->request->clientIp());
        if ($alreadyRegistered->count()) {
            $this->Flash->error(__('This IP is already registered with us, please use another IP.'));
            return $this->redirect('/login');
        }
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $user = $this->Auth->identify();
                $this->Auth->setUser($user);
                $this->Flash->success(__('Thank you for registered with us.'));

                if ($this->request->is('api')) {
                    $this->Api->login($user);
                }
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
}
