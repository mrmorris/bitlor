<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

/**
 * Links Controller
 *
 * @property \App\Model\Table\LinksTable $Links
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LinksController extends AppController
{
    /**
     * View method
     *
     * When a user attempts to access a link by its slug, route them to the correct url
     *
     * @param string|null $slug Link slug.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {
        $targetUrl = '/';

        $link = $this->Links->find()
            ->where([
                'slug' => $slug
            ])
            ->order(['created' => 'desc'])
            ->first();

        if (!empty($link)) {
            // @todo this isn't very flexible; not only is it a fragile query, but
            // we could derive this elsewhere
            //$link->views++;
            //$this->Links->save($link);

            // @todo move this into the entity
            $connection = ConnectionManager::get('default');
            $connection
                ->query('UPDATE links SET views = views + 1 WHERE id = ' . $link->id);

            $targetUrl = $link->url;
        }

        return $this->redirect(
            $link->url,
            // temporary redirect
            // why? because we don't want a requester to cache the target address
            // and skip our "bitly" link in the future
            307
        );
    }
}
