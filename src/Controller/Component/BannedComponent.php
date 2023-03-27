<?php

namespace BannedTool\Controller\Component;

use Cake\Controller\Component;
use BannedTool\Banned\Banned;

/**
 * The Banned Component.
 */
class BannedComponent extends Component {

    /**
     * Controller Class.
     *
     * @var \Cake\Controller\Controller
     */
    protected $controller;

    /**
     * Class Object.
     *
     * @var \BannedTool\Banned\Banned
     */
    protected $Banned;

    /**
     * Initial Contructor of Component.
     *
     * @param array $config
     */
    public function initialize(array $config): void {
        parent::initialize($config);
        $this->controller = $this->getController();
        $this->Banned = new Banned();
    }

    /**
     * Check if ip address banned.
     *
     * @param $ip IP Address.
     * @return boolean
     */
    public function isBanned( $ip ) {
        return $this->Banned->isBanned($ip);
    }

    /**
     * Add Ban.
     *
     * @param $ips A comma separated list of ip addresses.
     * @return boolean
     */
    public function addBan( $ips ) {
        $ips = explode(',',$ips);
        return $this->Banned->addIpAddress($ips);
    }

    /**
     * Remove Ban.
     *
     * @param $ips A comma separated list of ip addresses.
     * @return boolean
     */
    public function rmBan( $ips ) {
        $ips = explode(',',$ips);
        return $this->Banned->removeIpAddress($ips);
    }

    /**
     * Get all IP Addresses.
     *
     * @return \Cake\Datasource\ResultSetInterface
     */
    public function getAllBannedIpAddreses() {
        return $this->Banned->getAllIPAddresses();
    }

}
