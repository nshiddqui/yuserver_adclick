<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Link Entity
 *
 * @property int $id
 * @property string $link
 * @property string $website
 * @property string $titile
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $view
 *
 * @property \App\Model\Entity\ClickEvent[] $click_events
 */
class Link extends Entity
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
        'link' => true,
        'website' => true,
        'titile' => true,
        'created' => true,
        'modified' => true,
        'view' => true,
        'click_events' => true,
    ];
}
