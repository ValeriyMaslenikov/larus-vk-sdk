<?php

namespace LarusVK\Tests;

use LarusVK\Client;
use LarusVK\Credentials\CredentialsInterface;
use LarusVK\Credentials\StandardCredentials;

/**
 * Class ClientTest
 * @covers
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \Prophecy\Prophet */
    protected $prophet;

    protected function setup()
    {
        $this->prophet = new \Prophecy\Prophet;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testConstructorWithoutParameters()
    {
        $client = new Client();
    }


    public function testConstructorWithContainer()
    {
        /** @var CredentialsInterface $credentials */
        $credentials = $this->prophet->prophesize('\LarusVK\Credentials\CredentialsInterface')->reveal();

        $client = new Client(
            $credentials
        );
    }
}
