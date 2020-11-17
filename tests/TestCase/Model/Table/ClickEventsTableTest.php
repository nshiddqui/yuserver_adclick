<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClickEventsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClickEventsTable Test Case
 */
class ClickEventsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClickEventsTable
     */
    public $ClickEvents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClickEvents',
        'app.Users',
        'app.Links',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ClickEvents') ? [] : ['className' => ClickEventsTable::class];
        $this->ClickEvents = TableRegistry::getTableLocator()->get('ClickEvents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClickEvents);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
