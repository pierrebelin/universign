<?php

namespace PierreBelin\Universign\Request;
// require_once dirname(__DIR__) . '/Base.php';

class TransactionDocument extends Base
{
    protected $attributesTypes = [
        'documentType'    => 'string',
        'content'         => 'base64',
        'url'             => 'string',
        'name'            => 'string',
        'title'           => 'string',
    ];
}