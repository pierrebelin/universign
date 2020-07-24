<?php

namespace PierreBelin\Universign;

use PierreBelin\Universign\Request\TransactionRequest;
use PierreBelin\Universign\Response\TransactionResponse;
use PierreBelin\Universign\Response\TransactionDocument;

require_once dirname(__DIR__) . '/lib/xmlrpc/xmlrpc.inc';
require_once dirname(__DIR__) . '/lib/xmlrpc/xmlrpcs.inc';
require_once dirname(__DIR__) . '/lib/xmlrpc/xmlrpc_wrappers.inc';

class Requester
{
    private $userMail;
    private $userPassword;
    private $isTest;

    function __construct($userMail, $userPassword,$isTest)
    {
        $this->userMail = $userMail;
        $this->userPassword = $userPassword;
        $this->isTest = $isTest;
    }

    /** 
     * Send documents + signers to Universign and return the URL + the ID of the document
     * 
     * @param   \PierreBelin\Universign\Request\TransactionRequest $transactionRequest
     * @return  \PierreBelin\Universign\Response\TransactionResponse
     */
    public function requestTransaction(TransactionRequest $transactionRequest)
    {
        $client = $this->getClient();
        $request = new \xmlrpcmsg('requester.requestTransaction', [$transactionRequest->buildRpcValues()]);
        $response = &$client->send($request);

        if (!$response->faultCode()) {
            return new TransactionResponse($response);
        } 
        //error
        print 'An error occurred: ';
        print 'Code: ' . $response->faultCode(). " Reason: '" . $response->faultString();
    }
    
    public function getDocumentsByCustomId($customId)
    {
        $client = $this->getClient();
        $request = new \xmlrpcmsg('requester.getDocumentsByCustomId', [new \xmlrpcval($customId, 'string')]);
        $response = &$client->send($request);

        var_dump($response); die;

        if (!$response->faultCode()) {
            
            // foreach ($values as $key => $value) {
            //     $data[] = new TransactionDocument($value);
            // }

            return new TransactionResponse($response);
        } 
        //error
        print 'An error occurred: ';
        print 'Code: ' . $response->faultCode(). " Reason: '" . $response->faultString();
    }

    public function getDocuments($transactionId)
    {
        $client = $this->getClient();
        $request = new \xmlrpcmsg('requester.getDocuments', [new \xmlrpcval($transactionId, 'string')]);
        $response = &$client->send($request);

        var_dump($response); die;

        if (!$response->faultCode()) {
            
            // foreach ($values as $key => $value) {
            //     $data[] = new TransactionDocument($value);
            // }

            return new TransactionResponse($response);
        } 
        //error
        print 'An error occurred: ';
        print 'Code: ' . $response->faultCode(). " Reason: '" . $response->faultString();
    }

    private function getURLRequest() 
    {
        if($this->isTest) {
            return 'https://' . $this->userMail . ':'. $this->userPassword  . '@ws.test.universign.eu/sign/rpc/';
        }
        return 'https://' . $this->userMail . ':'. $this->userPassword  . '@ws.universign.eu/sign/rpc/';
    }
    
    private function getClient() {
        $client = new \xmlrpc_client($this->getURLRequest());
        $client->setSSLVerifyHost(1);
        $client->setSSLVerifyPeer(1);
        $client->setDebug(0);
        return $client;
    }
}
