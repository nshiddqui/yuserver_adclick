<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Mailer\MailerAwareTrait;


/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->notEmptyString('role');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->maxLength('name', 50)
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __('This email is already exists.')]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 15)
            ->allowEmptyString('ip_address')
            ->add('ip_address', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __('This ip is already exists.')]);

        $validator
            ->boolean('status')
            ->notEmptyString('status');

        $validator
            ->scalar('auth_token')
            ->maxLength('auth_token', 255)
            ->allowEmptyString('auth_token');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->allowEmptyString('token');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['ip_address']));

        return $rules;
    }

    public function tokenUpdate($email)
    {
        $token = \Cake\Utility\Security::hash(date('Y-m-d'));
        $this->updateAll([
            'token' => $token
        ], [
            'email' => $email
        ]);
        return $token;
    }

    public function setAuthToken()
    {
        if ($this->id) {
            $datasourceEntity = $this->get($this->id);
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $datasourceEntity->auth_token = $token;
            if ($this->save($datasourceEntity)) {
                return $token;
            }
        }
        return false;
    }
    public function implementedEvents()
    {
        return [
            'Model.afterSave' => 'onRegistration'
        ];
    }

    use MailerAwareTrait;

    public function onRegistration($event, $entity, $options)
    {
        if ($entity->isNew()) {
            if (!empty($entity->email)) {
                $this->getMailer('User')->send('welcome', [$entity]);
            }
        }
    }

    protected function _insert($entity, $data)
    {
        $ServerRequest = new \Cake\Http\ServerRequest();
        if (!isset($data['ip_address']) || empty($data['ip_address'])) {
            $data['ip_address'] = '192.168.0.1';
            // $data['ip_address'] = $ServerRequest->clientIp();
        }
        return parent::_insert($entity, $data);
    }
}
