<?php

namespace PierreBelin\Universign\Request;
// require_once dirname(__DIR__) . '/Base.php';

class TransactionSigner extends Base
{
    protected $attributesTypes = [
        'firstname' => 'string',
        'lastname' => 'string',
        'organization' => 'string',
        'emailAddress' => 'string',
        'phoneNum' => 'string',
        'birthDate' => 'dateTime', // This format is needed yyyymmddT00:00:00 as string
        'successURL' => 'string',
        'cancelURL' => 'string',
        'failURL' => 'string',
    ];
}
