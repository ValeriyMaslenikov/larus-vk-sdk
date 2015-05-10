<?php

namespace LarusVK\Sections;

use LarusVK\LarusClient;
use LarusVK\Sections\Methods\AbstractMethod;
use LarusVK\Sections\Methods\FieldCollection;

/**
 * Class AbstractSection
 * @package LarusVK\Sections
 */
abstract class AbstractSection
{

    const NAME = '';

    /**
     * @var LarusClient
     */
    protected $parent;

    protected $methods = [];

    public function __construct(LarusClient $parent)
    {
        $this->parent = $parent;
    }

    public function executeMethod($method_name, array $data)
    {

        $this->checkMethod($method_name);

        /** @var AbstractMethod $method */
        $method = $this->getMethod($method_name);

        if ($this->parent->getCredentials()->hasAccessToken()) {
            $data[FieldCollection::ACCESS_TOKEN_FIELD] = $this->parent->getCredentials()->getAccessToken();
        }


        return $method->execute(
            FieldCollection::fromArray($data),
            $this->parent->getClient()
        );


    }


    /**
     * Check method existing in $this->methods array
     *
     * @param $method_name
     * @return bool
     */
    public function isMethodExists($method_name)
    {
        return in_array($method_name, $this->methods);
    }

    /**
     * Check method existing, otherwise throws InvalidArgumentException
     *
     * @throws \InvalidArgumentException
     * @param string $method_name
     */
    protected function checkMethod($method_name)
    {
        if ($this->isMethodExists($method_name)) {
            throw new \InvalidArgumentException(
                "Method `{$method_name}` doesn't exist in section `" . $this->getName() . "`"
            );
        }
    }


    /**
     * Return method's object by its name
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     * @param string $method_name
     * @return AbstractMethod
     */
    protected function getMethod($method_name)
    {

        $this->checkMethod($method_name);

        $method = $this->methods[$method_name];

        if (is_string($method)) {

            if (!class_exists($method)) {

                throw new \LogicException(
                    "Method's class `{$method}` doesn't exist"
                );

            } else {

                $class_name = $method;

                $this->methods[$method_name] = new $class_name;

                if (!($this->methods[$method_name] instanceof AbstractMethod)) {
                    throw new \LogicException(
                        "Class {$class_name} must be an instance of AbstractMethod"
                    );
                }

                $result = $this->methods[$method_name];

            }
        } else {
            $result = $method;
        }

        return $result;

    }

    public function __call($name, $arguments)
    {
        return $this->executeMethod(
            $name,
            isset($arguments[0]) ? $arguments[0] : []
        );
    }

    /** @return string Section's name */
    public function getName()
    {
        return static::NAME;
    }

}