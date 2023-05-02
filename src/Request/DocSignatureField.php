<?php

namespace PierreBelin\Universign\Request;

class DocSignatureField extends Base
{
    protected $attributesTypes = [
        'name' => 'string',
        'page' => 'int',
        'x' => 'int',
        'y' => 'int',
        'signerIndex' => 'int',
    ];
}