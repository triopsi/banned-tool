<?php

namespace BannedTool\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use BannedTool\Banned\Banned;
use Cake\Validation\Validation;

/**
 * Remove IP Address from blacklist.
 */
class RemoveBannedCommand extends Command {

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
        return 'rm ban';
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
        $ips = $args->getArgument('ip_addresses');
        if(!empty($ips)){
            $ips = explode(',',$ips);
        }
        foreach($ips as $ip){
            if (!Validation::ip($ip)) {
                $this->io->error($ip . ' is not a valid IP address.');
                $this->abort();
            }
        }
        if($this->Banned->removeIpAddress($ips)){
            $this->io->out('Success');
            return static::CODE_SUCCESS;
        }
        return static::CODE_ERROR;
    }

    /**
     * Description for cake help page.
     * @return string
     */
    public static function getDescription(): string {
        return 'A quick way to ban IP addresses.';
    }

    /**
     * Build Arguments and Options.
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {

        $parser->setDescription(
            'A quick way to ban IP addresses.'
        )
        ->addArgument('ip_addresses', [
            'help' => 'A comma separated list of ip addresses.',
            'required' => true
        ])
        ->setEpilog(
            'Example Use: `cake rm ban <ip_addresses>[,<ipaddresses>]'
        );

        return $parser;
    }

}
