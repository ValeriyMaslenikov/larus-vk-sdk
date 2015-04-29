<?php

namespace LarusVK\Credentials;

interface CredentialsInterface {

    /**
     * @return string
     */
    public function getAccessToken();

    /**
     * @return bool
     */
    public function hasAccessToken();

    /**
     * @return int
     */
    public function getApplicationId();

    /**
     * @return string
     */
    public function getApplicationSecretKey();
}