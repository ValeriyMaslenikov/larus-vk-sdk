<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 30.04.2015
 * Time: 1:06
 */

namespace LarusVK;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use LarusVK\Credentials\CredentialsInterface;
use LarusVK\Credentials\NullCredentials;
use LarusVK\Sections\AbstractSection;
use LarusVK\Sections\UsersSection;

/**
 * Class LarusClient
 * @package LarusVK
 * @property UsersSection users
 */
class LarusClient
{

    protected $sections = [
        'users' => '\\LarusVK\\Sections\\UsersSection'
    ];

    /** @var CredentialsInterface */
    protected $credentials;
    /** @var  ClientInterface */
    protected $client;

    public function __construct(CredentialsInterface $credentials = null, ClientInterface $client = null)
    {

        $this->credentials = is_null($credentials) ?
            new NullCredentials() :
            $credentials;

        $this->client = is_null($client) ?
            new Client() :
            $client;

    }

    public function getClient()
    {
        return $this->client;
    }

    public function setSection($name, $value)
    {
        // TODO Create method implementation
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Return section by its name. If section doesn't exist yet, method will create it
     *
     * @param $name
     * @return AbstractSection
     */
    public function getSection($name)
    {
        if (!array_key_exists($name, $this->sections)) {
            throw new \InvalidArgumentException(
                "Section {$name} doesn't exist"
            );
        }

        $section_value = $this->sections[$name];

        if (is_string($section_value)) {

            if (!class_exists($section_value)) {

                throw new \LogicException(
                    "Class {$section_value} doesn't exist"
                );

            } else {

                $class_name = $section_value;

                $this->sections[$name] = new $class_name($this);

                if (!($this->sections[$name] instanceof AbstractSection)) {
                    throw new \LogicException(
                        "Class {$class_name} must be an instance of AbstractSection"
                    );
                }

                $result = $this->sections[$name];

            }
        } else {
            $result = $section_value;
        }

        return $result;
    }

    /**
     * @see getSection
     * @param $name
     * @return AbstractSection
     */
    function __get($name)
    {
        return $this->getSection($name);
    }


}