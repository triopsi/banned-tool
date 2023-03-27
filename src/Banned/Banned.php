<?php

namespace BannedTool\Banned;

use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Banned Class.
 */
class Banned {

    use LocatorAwareTrait;

    /**
     * Table Entity.
     *
     * @var \Cake\ORM\Table
     */
    protected $Banned;

    /**
     * Constructor from Class. Load Entity.
     *
     */
    public function __construct() {
        $this->Banned = $this->getTableLocator()->get('BannedTool.Banned');
    }

    /**
     * Check if ip addresse ware banned.
     *
     * @param $ip
     * @return boolean
     */
    public function isBanned( $ip ) {
        return (bool) $this->Banned->find('all')->where(array('ip_address'=>$ip))->count();
    }

    /**
     * Add IP Address in the banlist.
     *
     * @param $newIps
     * @return true
     */
    public function addIpAddress( $newIps = array() ) {
        foreach( $newIps as $ip ) {
           $this->banIpAddress($ip);
        }
        return true;
    }

    /**
     * Ban IP Address.
     *
     * @param $ip
     * @return bool|\Cake\Datasource\EntityInterface
     */
    public function banIpAddress( $ip ) {
        if(!$this->isBanned($ip)){
            $bannedObj = $this->Banned->newEntity(array(
                'ip_address' => $ip
            ));
            return $this->Banned->save($bannedObj);
        }
        return true;
    }

    /**
     * Unban IP address.
     *
     * @param $ips
     * @return true
     */
    public function removeIpAddress( $ips = array() ) {
        foreach($ips as $ip){
            if($this->isBanned($ip)){
                $bannedObj = $this->Banned->find('all')->where(array('ip_address'=>$ip))->first();
                $this->Banned->delete($bannedObj);
            }
        }
        return true;
    }

    /**
     * List all IP Addresses.
     *
     * @return \Cake\Datasource\ResultSetInterface
     */
    public function getAllIPAddresses(){
        return $this->Banned->find('all')->all();
    }

}