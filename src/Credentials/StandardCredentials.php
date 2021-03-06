<?php

namespace LarusVK\Credentials;


class StandardCredentials implements CredentialsInterface
{

    const ACCESS_TOKEN_SIZE = 32;

    const MIN_SECRET_KEY_LENGTH = 6;
    const MAX_SECRET_KEY_LENGTH = 32;

    /** @var  int */
    protected $application_id;
    /** @var  string */
    protected $application_secret_key;
    /** @var  string|null */
    protected $access_token;

    /**
     * @return int
     */
    public function getApplicationId()
    {
        return $this->application_id;
    }

    /**
     * @param $application_id
     * @return $this
     */
    public function setApplicationId($application_id)
    {
        if (!is_integer($application_id) || $application_id <= 0) {

            throw new \InvalidArgumentException(
                "Application ID must be an integer, greater than 0"
            );

        }

        $this->application_id = $application_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationSecretKey()
    {
        return $this->application_secret_key;
    }

    /**
     * @param $application_secret_key
     * @return $this
     */
    public function setApplicationSecretKey($application_secret_key)
    {

        if (
            !is_string($application_secret_key) ||
            strlen($application_secret_key) < self::MIN_SECRET_KEY_LENGTH ||
            strlen($application_secret_key) > self::MAX_SECRET_KEY_LENGTH
        ) {
            throw new \InvalidArgumentException(
                'Application secret key must be a string between ' .
                self::MIN_SECRET_KEY_LENGTH . ' and ' . self::MAX_SECRET_KEY_LENGTH .
                ' characters'
            );
        }

        $this->application_secret_key = $application_secret_key;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param null|string $access_token
     * @return $this
     */
    public function setAccessToken($access_token)
    {
        if (!is_null($access_token)) {

            if (!is_string($access_token) || strlen($access_token) !== self::ACCESS_TOKEN_SIZE) {

                throw new \InvalidArgumentException(
                    "Access token must be string a of " . self::ACCESS_TOKEN_SIZE . " characters"
                );

            }

        }

        $this->access_token = $access_token;

        return $this;
    }

    public function hasAccessToken()
    {
        return !is_null($this->access_token);
    }

    public static function getInstance($application_id, $application_secret_key, $access_token = null)
    {
        $instance = new self();
        $instance
            ->setApplicationId($application_id)
            ->setApplicationSecretKey($application_secret_key)
            ->setAccessToken($access_token);
    }
}