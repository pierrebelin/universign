<?php

namespace PierreBelin\Universign\Response;

class TransactionDocument extends Base
{
    protected $attributesTypes = [
        'documentType' => true,
        'content' => true,
        'name' => true,
        'signatureFields' => true,
        'checkBoxTexts' => true,
        'metaData' => true,
        'displayName' => true,
        'signatureFields' => true,
        'SEPAData' => true,
    ];
}
