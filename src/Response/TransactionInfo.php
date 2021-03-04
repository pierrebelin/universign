<?php

namespace PierreBelin\Universign\Response;

class TransactionInfo extends Base
{
    protected $attributesTypes = [
        'status' => true,
        'signerInfos' => true,
        'currentSigner' => true,
        'creationDate' => true,
        'description' => true,
        'iniatorInfo' => true,
        'eachField' => true,
        'customId' => true,
        'transactionId' => true,
    ];
}
