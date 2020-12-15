<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Utility\Hash;

class ApiComponent extends Component
{

    protected $Controller = null;

    public function initialize(array $config)
    {
        parent::initialize($config);
        // turn off debug mode
        //        Configure::write('debug', 0);

        /**
         * Get current controller
         */
        $this->Controller = $this->_registry->getController();

        $this->Controller->Auth->__set('sessionKey', false);

        if ($this->Controller->request->getParam('action') != 'login') {
            //            // use token authentication
            $this->Controller->Auth->setConfig('authenticate', [
                'Token' => [
                    'fields' => ['token' => 'auth_token'],
                ]
            ]);
        }

        if (!$this->Session) {
            $this->Session = $this->Controller->request->getSession();
        }
        // default to json response
        $this->Controller->RequestHandler->renderAs($this->Controller, 'json');
    }

    function beforeRender(Event $event)
    {

        // handle exceptions
        if (isset($this->Controller->viewVars['error'])) {
            $this->Controller->setException($this->Controller->viewVars['error']);
        }

        // set response status
        if (isset($this->Controller->viewVars['status'])) {
            if ($this->Controller->viewVars['status'] > 100 && $this->Controller->viewVars['status'] < 1100) {
                $this->Controller->response->statusCode($this->Controller->viewVars['status']);
            }
        }

        if ($Flash = $this->Session->read('Flash')) {
            $message = [];
            foreach ($Flash['flash'] as $flash_message) {
                $message_name = explode('/', $flash_message['element'])[1];
                if (isset($message[$message_name])) {
                    $message[$message_name] .= '\n' . $flash_message['message'];
                } else {
                    $message[$message_name] = $flash_message['message'];
                }
            }
            $this->Controller->set($message);
            $this->Session->delete('Flash');
        }

        $this->setMetaData();

        $this->setCorsHeaders();

        // serialize for json output if not already done
        if (!isset($this->Controller->viewVars['_serialize'])) {
            $this->Controller->set('_serialize', array_keys($this->Controller->viewVars));
        }

        $this->removeUnwantedviewVars();
    }

    function beforeRedirect(Event $event, $url, $status = null, $exit = true)
    {
        $this->Controller->enableAutoRender();
        return false;
    }

    public function login($data, $return = false)
    {
        $this->Controller->Users->id = $data['id'];

        if ($token = $this->Controller->Users->setAuthToken()) {
            $data['auth_token'] = $token;
            if ($return) {
                return $data;
            }
            $this->Controller->set([
                'client_name' => $data['client_name'],
                'email' => $data['email'],
                'auth_token' => $data['auth_token']
            ]);
        }
        return [];
    }

    public function removeUnwantedviewVars()
    {
    }

    public function setMetaData()
    {
        if (isset($this->Controller->Paginator)) {
            $meta = Hash::extract($this->Controller->Paginator->getPagingParams(), '{*}')[0];
            if (isset($this->Controller->viewVars['meta'])) {
                $meta = array_merge($this->Controller->viewVars['meta'], $meta);
            }
            $this->Controller->set(compact('meta'));
        }
    }
    private function setCorsHeaders()
    {
        $this->Controller->response->header('Access-Control-Allow-Origin', '*');
    }
}
