<?php

namespace PierreBelin\Universign\Request;
// require_once dirname(__DIR__) . '/Base.php';

class SignatureField extends Base
{
    protected $attributesTypes = [
        'name' => 'string',
        'page' => 'int',
        'x' => 'int',
        'y' => 'int'
    ];
}