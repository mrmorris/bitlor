<?php
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;

/**
 * Simple slug behavior
 *
 * Creates a random "slug" string based on a given "field", with a "length" limit
 *
 * Class SluggableBehavior
 * @package App\Model\Behavior
 */
class SluggableBehavior extends Behavior
{
    /**
     * config defaults
     * @var array
     */
    protected $_defaultConfig = [
        'field' => 'title',
        'slug' => 'slug',
        'length' => 7
    ];

    /**
     * generate the slug
     * @param EntityInterface $entity
     */
    public function slug(EntityInterface $entity)
    {
        $config = $this->getConfig();
        $value = $entity->get($config['field']);

        // @todo - be more flexible
        // try to find a string that is available but short
        // if string already exists, increase length unless it is truly a dupe url...
        $slug = substr(md5($value), 0, $config['length']);

        $entity->set($config['slug'], $slug);
    }

    /**
     * @param EventInterface $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->slug($entity);
    }
}