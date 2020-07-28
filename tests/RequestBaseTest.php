<?php

use PHPUnit\Framework\TestCase;

use PierreBelin\Universign\{
    Request\TransactionDocument
};

class RequestBaseTest extends TestCase 
{
    public function testSetWrongType()
    {
        $this->expectException(UnexpectedValueException::class);

        $document = new TransactionDocument();
        $document->setName(12);
    }

    public function testSetRightType()
    {
        $document = new TransactionDocument();
        $document->setName('Document name');
        $this->assertSame($document->getAttributes()['name'] , 'Document name');    
    }

    public function testSetWrongAttribute()
    {
        $this->expectException(UnexpectedValueException::class);

        $document = new TransactionDocument();
        $document->setNAME('Document name');
    }
}
