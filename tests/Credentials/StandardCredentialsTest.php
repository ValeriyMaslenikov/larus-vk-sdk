<?php

namespace LarusVK\Credentials;

/**
 * Class StandardCredentialsTest
 * @package LarusVK\Credentials
 */
class StandardCredentialsTest extends \PHPUnit_Framework_TestCase
{

    const RIGHT_APPLICATION_ID = 10;

    /** @var StandardCredentials */
    protected $standard_credentials_object;

    protected function setUp()
    {
        $this->standard_credentials_object = new StandardCredentials();
    }

    /**
     * @dataProvider providerInvalidArgumentExceptionSetApplicationId
     * @expectedException \InvalidArgumentException
     * @param $application_id
     */
    public function testInvalidArgumentExceptionSetApplicationId($application_id)
    {
        $this->standard_credentials_object->setApplicationId($application_id);
    }

    public function providerInvalidArgumentExceptionSetApplicationId()
    {
        return [
            [null],
            [false],
            [0],
            [-1],
            ['qwerty'],
            [new \stdClass()]
        ];
    }

    public function testSetApplicationId()
    {

        $this->assertEquals(
            $this->standard_credentials_object,
            $this->standard_credentials_object->setApplicationId(
                self::RIGHT_APPLICATION_ID
            )
        );
    }

    /**
     * @depends testSetApplicationId
     */
    public function testGetApplicationId()
    {
        $this->standard_credentials_object->setApplicationId(
            self::RIGHT_APPLICATION_ID
        );

        $this->assertEquals(
            $this->standard_credentials_object->getApplicationId(),
            self::RIGHT_APPLICATION_ID
        );
    }

    /**
     * @dataProvider providerInvalidArgumentExceptionSetAccessToken
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentExceptionSetAccessToken($access_token)
    {
        $this->standard_credentials_object->setAccessToken($access_token);
    }

    public function providerInvalidArgumentExceptionSetAccessToken()
    {
        return [
            [false],
            [$this->genRandomString(StandardCredentials::ACCESS_TOKEN_SIZE - 1)],
            [$this->genRandomString(StandardCredentials::ACCESS_TOKEN_SIZE + 1)]
        ];
    }

    public function testSetAccessTokenNull()
    {
        $this->assertSame(
            $this->standard_credentials_object,
            $this->standard_credentials_object->setAccessToken(
                null
            )
        );
    }


    public function testSetAccessToken()
    {
        $this->assertSame(
            $this->standard_credentials_object,
            $this->standard_credentials_object->setAccessToken(
                $this->genRandomString(StandardCredentials::ACCESS_TOKEN_SIZE)
            )
        );
    }

    /**
     * @depends testSetAccessToken
     */
    public function testGetAccessToken()
    {
        $access_token = $this->genRandomString(StandardCredentials::ACCESS_TOKEN_SIZE);

        $this->standard_credentials_object->setAccessToken(
            $access_token
        );

        $this->assertSame(
            $access_token,
            $this->standard_credentials_object->getAccessToken()
        );
    }

    public function testHasAccessToken()
    {
        $this->assertFalse(
            $this->standard_credentials_object->hasAccessToken()
        );

        $this->standard_credentials_object->setAccessToken(
            $this->genRandomString(StandardCredentials::ACCESS_TOKEN_SIZE)
        );

        $this->assertTrue(
            $this->standard_credentials_object->hasAccessToken()
        );
    }

    /**
     * @param string $secret_key
     * @dataProvider providerInvalidArgumentExceptionSetApplicationSecretKey
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentExceptionSetApplicationSecretKey($secret_key)
    {
        $this->standard_credentials_object->setApplicationSecretKey($secret_key);
    }

    public function providerInvalidArgumentExceptionSetApplicationSecretKey()
    {
        return [
            [false],
            [null],
            [$this->genRandomString(StandardCredentials::MIN_SECRET_KEY_LENGTH - 1)],
            [$this->genRandomString(StandardCredentials::MAX_SECRET_KEY_LENGTH + 1)]
        ];
    }

    public function testSetApplicationSecretKey()
    {
        $application_secret_key = $this->genRandomApplicationSecretKey();

        $this->assertSame(
            $this->standard_credentials_object,
            $this->standard_credentials_object->setApplicationSecretKey(
                $application_secret_key
            )
        );
    }

    /**
     * @depends testSetApplicationSecretKey
     */
    public function testGetApplicationSecretKey()
    {
        $application_secret_key = $this->genRandomApplicationSecretKey();

        $this->standard_credentials_object->setApplicationSecretKey(
            $application_secret_key
        );

        $this->assertSame(
            $application_secret_key,
            $this->standard_credentials_object->getApplicationSecretKey()
        );
    }

    public function genRandomApplicationSecretKey()
    {
        return $this->genRandomString(
            rand(StandardCredentials::MIN_SECRET_KEY_LENGTH, StandardCredentials::MAX_SECRET_KEY_LENGTH)
        );
    }

    /**
     * @param $length
     * @return string
     */
    public function genRandomString($length)
    {
        return openssl_random_pseudo_bytes($length);
    }


}
