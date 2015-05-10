<?php

namespace LarusVK\Sections\Methods;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\RequestInterface;

abstract class AbstractMethod
{

    const NAME = '';

    // VK can receive GET and POST, but last can transfer data gt 3kb
    const REQUEST_TYPE = 'POST';

    const API_VERSION = 5.31;

    const HTTP_SCHEME = 'https';

    // TODO Make possibility for testing
    const VK_HOST = 'api.vk.com';

    const DEFAULT_FORMAT = 'json';


    /** @var bool For executing method - access token must be provided */
    protected $is_access_token_required = false;

    /** @var array Fields, which can be passed for every method */
    protected $general_fields = [
        FieldCollection::LANG_FIELD,
        FieldCollection::HTTPS_FIELD,
        FieldCollection::TEST_MODE_FIELD
    ];

    /** @var array Fields, which is specified by method */
    protected $method_fields = [];

    /**
     * Check, if method requires access token
     *
     * @return bool
     */
    public function isAccessTokenRequired()
    {
        return boolval($this->is_access_token_required);
    }

    /**
     * @param array $params
     * @param ClientInterface $client
     */
    public function execute(
        FieldCollection $params,
        ClientInterface $client
    )
    {

        $request = $this->prepareRequest($params, $client);

        $response = $client->send($request);

        $result = $response->json();

        print_r($result);

        if (isset($result['error'])) {
            throw new \RuntimeException($result['error']['error_msg'], $result['error']['error_code']);
        }

        return $result;

    }


    /**
     * @param FieldCollection $params
     * @param ClientInterface $client
     * @return RequestInterface
     */
    public function prepareRequest(
        FieldCollection $params,
        ClientInterface $client
    )
    {

        $this->checkFields($params);

        $request = $client->createRequest(
            static::REQUEST_TYPE,
            null,
            [
                // TODO WARNING, REMOVE THIS LINE AND FIND ANOTHER WAY
                'verify' => false
                // WARNING
            ]
        );

        $request->setHost(
            static::VK_HOST
        );

        $request->setScheme(
            static::HTTP_SCHEME
        );

        $request->setPath(
            '/method/' . $this->getName()
        );

        $request->setQuery(
            $params->getArray()
        );

        $request->setPort(443);

        return $request;
    }

    /**
     * Return an array of allowed params, which can be used in execute method
     *
     * @return array
     */
    public function getAllowedParams()
    {
        return array_merge($this->general_fields, $this->method_fields);
    }

    /**
     * Check correctness of params, otherwise throws InvalidArgumentException
     *
     * @param FieldCollection $fields
     */
    protected function checkFields(FieldCollection $fields)
    {

        $allowed_params = $this->getAllowedParams();

        $incorrect_params = [];

        foreach ($fields as $param_name => $param_value) {

            if (!in_array($param_name, $allowed_params)) {
                $incorrect_params[] = $param_name;
            }

        }

        if (!empty($incorrect_params)) {

            throw new \InvalidArgumentException(
                'Method `' . $this->getName() . '` can\'t take params: `' .
                implode('`, ', array_merge($incorrect_params)) . '`'
            );

        }

        if (
            $this->isAccessTokenRequired() &&
            !isset($fields[FieldCollection::ACCESS_TOKEN_FIELD])
        ) {
            throw new \InvalidArgumentException(
                'Method `' . $this->getName() . '` requires access token'
            );
        }


    }


    /**
     * Convert params to an array and add additional required fields
     *
     * @param FieldCollection $fields
     * @return FieldCollection
     */
    protected function prepareFields(FieldCollection $fields)
    {
        $prepared_params = clone $fields;

        $prepared_params[FieldCollection::API_VERSION_FIELD] = self::API_VERSION;

        return $fields;
    }

    /**
     * Return full method name for request, e.g. `users.get`
     * @return string
     */
    public function getName(){

        return static::NAME;

    }


}