<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GameSessionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GameSessionsTable Test Case
 */
class GameSessionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GameSessionsTable
     */
    protected $GameSessions;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.GameSessions',
        'app.Users',
        'app.Games',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GameSessions') ? [] : ['className' => GameSessionsTable::class];
        $this->GameSessions = $this->getTableLocator()->get('GameSessions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->GameSessions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\GameSessionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\GameSessionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
