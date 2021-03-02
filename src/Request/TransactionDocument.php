<?php

namespace PierreBelin\Universign\Request;
// require_once dirname(__DIR__) . '/Base.php';

abstract class TransactionDocumentType
{
    const PDF = 'pdf';
    const PDF_READ_ONLY = 'pdf-for-presentation';
    const PDF_OPTIONAL = 'pdf-optional';
    const SEPA = 'sepa';
}


class TransactionDocument extends Base
{
    protected $attributesTypes = [
        'documentType'    => 'string',
        'content'         => 'base64',
        'url'             => 'string',
        'name'            => 'string',
        'title'           => 'string',
        'SEPAData' => 'PierreBelin\Universign\Request\SEPAData',
        'signatureFields' => 'array',
    ];

    public function addSignatureField(DocSignatureField  $docSignatureField)
    {
        $this->attributes['signatureFields'][] = $docSignatureField;
        return $this;
    }
}