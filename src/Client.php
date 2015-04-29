<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 30.04.2015
 * Time: 1:06
 */

namespace LarusVK;


use LarusVK\Credentials\CredentialsInterface;

class Client {

    public $credentials;

    public function __construct(CredentialsInterface $credentials){
        $this->credentials = $credentials;
    }


}