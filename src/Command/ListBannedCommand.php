<?php

namespace BannedTool\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use BannedTool\Banned\Banned;
use Cake\Validation\Validation;

/**
 * List all ip address commands.
 */
class ListBannedCommand extends Command {

    /**
     * The console io
     *
     * @var \Cake\Console\ConsoleIo
     */
    protected $io;

    /**
     * @var \Setup\Banned\Banned
     */
    public $Banned;

    /**
     * @inheritDoc
     */
    public static function defaultName(): string {
        return 'list bans';
    }

    /**
     * Execute Command.
     * @param Arguments $args Args.
     * @param ConsoleIo $io IO Object.
     * @return int|null
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int {
        $this->io = $io;
        $this->Banned = new Banned();
        $ips = $this->Banned->getAllIPAddresses();
        $count = $ips->count();
        $this->io->out('Current banlist:');
        if($count>0){
            foreach($ips as $ip){
                $this->io->out($ip->ip_address);
            }
        }else{
            $this->io->out('n/a');
        }

        return static::CODE_ERROR;
    }

    /**
     * Description for cake help page.
     * @return string
     */
    public static function getDescription(): string {
        return 'List all ip addresses in the banlist';
    }

    /**
     * Build Arguments and Options.
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {

        $parser->setDescription(
            'List all ip addresses in the banlist'
        )
        ->setEpilog(
            'Example Use: `cake list bans`'
        );

        return $parser;
    }

}
