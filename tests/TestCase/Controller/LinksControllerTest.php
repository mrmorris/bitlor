<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\LinksController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\LinksController Test Case
 *
 * @uses \App\Controller\LinksController
 */
class LinksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Links',
    ];

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
