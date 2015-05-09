<?php

namespace LarusVK\Sections\Methods\Users;

use LarusVK\Sections\Methods\AbstractMethod;

class Get extends AbstractMethod
{

    const IDS_FIELD = 'user_ids';
    const FIELDS_FIELD = 'fields';
    const NAME_CASE_FIELD = 'name_case';

    const NAME = 'users.get';

    protected $method_fields = [
        self::IDS_FIELD,
        self::FIELDS_FIELD,
        self::NAME_CASE_FIELD
    ];

}