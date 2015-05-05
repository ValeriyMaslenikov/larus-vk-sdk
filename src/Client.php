<?php
/**
 * Created by PhpStorm.
 * User: Valeriy
 * Date: 30.04.2015
 * Time: 1:06
 */

namespace LarusVK;


use GuzzleHttp\ClientInterface;
use LarusVK\Credentials\CredentialsInterface;
use LarusVK\Sections\AbstractSection;

class Client
{

    const DEFAULT_CLIENT = '\GuzzleHttp\Client';

    protected $sections = [
        'user' => 'LarusVK\\Sections\\UserSection'
    ];

    /** @var CredentialsInterface  */
    protected $credentials;
    /** @var  ClientInterface */
    protected $client;

    public function __construct(CredentialsInterface $credentials, ClientInterface $client = NULL)
    {
        $this->credentials = $credentials;
        $this->setClient($client);
    }

    public function setClient(ClientInterface $client = NULL)
    {
        if(is_null($client)) {
            $class =  self::DEFAULT_CLIENT;
            $this->client = new $class;
        } else {
            $this->client = $client;
        }

        return $this;
    }

    public function setSection($name, $value)
    {
        // TODO Create method implementation
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

                $this->sections[$name] = new $class_name;

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

}