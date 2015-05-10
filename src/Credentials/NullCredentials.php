<?php

namespace LarusVK\Credentials;


class NullCredentials implements CredentialsInterface
{
    /**
     * @return string
     */
    public function getAccessToken()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function hasAccessToken()
    {
        return false;
    }

    /**
     * @return int
     */
    public function getApplicationId()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getApplicationSecretKey()
    {
        return null;
    }

}