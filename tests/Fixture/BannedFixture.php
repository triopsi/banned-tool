<?php
declare(strict_types=1);

namespace BannedTool\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BannedFixture
 */
class BannedFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'banned';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'ip_address' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-03-23 08:59:30',
                'modified' => '2023-03-23 08:59:30',
            ],
        ];
        parent::init();
    }
}
