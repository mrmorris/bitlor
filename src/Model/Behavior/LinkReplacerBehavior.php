<?php
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Database\Exception;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Association;
use Cake\ORM\Behavior;
use Cake\ORM\Locator\LocatorAwareTrait;

class LinkReplacerBehavior extends Behavior
{
    use LocatorAwareTrait;

    /**
     * config default
     * @var array
     */
    protected $_defaultConfig = [
        'field' => 'body',
        'shortUrl' => 'skl.sh',
    ];

    /**
     * replaceUrlsWithLinks
     *
     * given an entity, replace any URLs in the body with "Link" references
     * saving Link entities as needed
     *
     * @param EntityInterface $entity
     */
    public function replaceUrlsWithLinks(EntityInterface $entity)
    {
        $config = $this->getConfig();
        $linksTable = $this->getTableLocator()->get('Links');
        $value = strip_tags($entity->get($config['field']));

        // @todo deal with an <a> tag if we handle "editing"...
        preg_match_all(
            "/(http|ftp|https):\/\/([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])?/",
            $value,
            $matches,
            PREG_SET_ORDER
        );

        // for each url...
        foreach ($matches as [$fullUrl, , $domain]) {
            // if it's already shortened
            if ($domain === $config['shortUrl']) {
                // @todo - maybe swap in the "original" url?
                $value = str_replace(
                    $fullUrl,
                    '<a href="https://'
                        . $fullUrl
                        . '"></a>',
                    $value
                );
            } else {
                // check for an existing link record
                $link = $linksTable->find()
                    ->where([
                        'url' => $fullUrl
                    ])
                    ->first();

                // no existing link? let's create one...
                if (empty($link)) {
                    $link = $linksTable->newEmptyEntity();
                    $link->url = $fullUrl;
                    if (!$linksTable->save($link)) {
                        throw new Exception('Link failed to save');
                    }
                }

                // look-ahead checks to prevent
                // - replacing a different url that has the same base, ex: https://site.com and https://site.com/here
                // - replacing a url that was already replaced with the <a> tags
                $value = preg_replace(
                    '/' . '' . preg_quote($fullUrl, '/') . '(?!\/)(?!<\/a>)/',
                    '<a href="https://'
                        . $config['shortUrl']
                        . '/'
                        . $link->slug
                        . '">'
                        . $link->url
                        . '</a>',
                    $value
                );
            }
        }

        $entity->set($config['field'], $value);
    }

    /**
     * @param EventInterface $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->replaceUrlsWithLinks($entity);
    }

//    public function buildMarshalMap($marshaller, $map, $options)
//    {
//        return [
//            'custom_behavior_field' => function ($value, $entity) {
//                // Transform the value as necessary
//                return $value . '123';
//            }
//        ];
//    }
}