<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClickEvent Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $link_id
 * @property string|null $token
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $ip_address
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Link $link
 */
class ClickEvent extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'link_id' => true,
        'token' => true,
        'created' => true,
        'modified' => true,
        'ip_address' => true,
        'user' => true,
        'link' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
