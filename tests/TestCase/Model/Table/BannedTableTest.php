<?php
declare(strict_types=1);

namespace BannedTool\Test\TestCase\Model\Table;

use BannedTool\Model\Table\BannedTable;
use Cake\TestSuite\TestCase;

/**
 * BannedTool\Model\Table\BannedTable Test Case
 */
class BannedTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \BannedTool\Model\Table\BannedTable
     */
    protected $Banned;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.BannedTool.Banned',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Banned') ? [] : ['className' => BannedTable::class];
        $this->Banned = $this->getTableLocator()->get('Banned', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Banned);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \BannedTool\Model\Table\BannedTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
