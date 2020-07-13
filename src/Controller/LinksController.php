<?php
declare(strict_types=1);

namespace App\Controller;

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
            $link->views++;
            $this->Links->save($link);
            $targetUrl = $link->url;
        }

        return $this->redirect($link->url);
    }
}
