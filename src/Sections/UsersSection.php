<?php

namespace LarusVK\Sections;

/**
 * Class UsersSection
 * @package LarusVK\Sections
 */
class UsersSection extends AbstractSection
{

    const NAME = 'users';

    protected $methods = [
        'get' => '\\Sections\\Methods\\Users\\Get'
    ];
}
