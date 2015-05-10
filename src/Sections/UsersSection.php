<?php

namespace LarusVK\Sections;

/**
 * Class UsersSection
 * @package LarusVK\Sections
 * @method get(array $params)
 */
class UsersSection extends AbstractSection
{

    const NAME = 'users';

    protected $methods = [
        'get' => '\\LarusVK\\Sections\\Methods\\Users\\Get'
    ];

}
