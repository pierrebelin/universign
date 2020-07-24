# Universign Service

If you need help to implements this service on your website, feel free to contact me at : contact@pierrebelin.fr

## How to use

You can copy-paste the following code and it will automatically connect you to your universign account.

### Fill constants

```php
$ACCOUNT_USER_MAIL = 'contact@pierrebelin.fr';
$ACCOUNT_USER_PASSWORD = 'xxxxxxxxx';
$UNIVERSIGN_PROFILE = 'default'; // you don't have to change this one, if you want to, read the manual
```

### Get your document

```php
    $document = new TransactionDocument();
    $document
        ->setContent(file_get_contents('path/to/file/file.pdf'))
        ->setName('Document name');
```

### Create signature fields

```php
$signatureField1 = new SignatureField();
$signatureField1->setPage(1)
    ->setX(50)
    ->setY(100);
```

### Create signers

```php
$signer = new TransactionSigner();
$signer
    ->setFirstname('Pierre')
    ->setLastname('Belin')
    ->setEmailAddress('contact@pierrebelin.fr')
    ->setPhoneNum('0606060606')
    ->setSuccessURL('https://www.universign.eu/fr/sign/success/')
    ->setCancelURL('https://www.universign.eu/fr/sign/cancel/')
    ->setFailURL('https://www.universign.eu/fr/sign/failed/')
    ->addSignatureField($signatureField1); // you can add multiples times ->addSignatureField($signatureField2) etc...
```

### Create transaction

```php
$request = new TransactionRequest();
$request
    ->addSigner($signer) // you can add multiples times ->addSignatureField($signer2) etc...
    ->addDocument($document) // you can add multiples times ->addDocument($document2) etc...
    ->setProfile($UNIVERSIGN_PROFILE)
    ->setCustomId(uniqid()) // create your own ID to make easier to get later
    ->setMustContactFirstSigner(false)
    ->setFinalDocSent(true)
    ->setDescription("This is my description")
    ->setCertificateType(TransactionRequestCertificate::CERTIFICATE_SIMPLE)
    ->setLanguage(TransactionRequestLanguage::FRENCH)
    ->setHandwrittenSignature(true)
    ->setChainingMode(TransactionRequestChainingMode::CHAINING_MODE_WEB);
```

### Request transaction

```php
$requester = new Requester($ACCOUNT_USER_MAIL, $ACCOUNT_USER_PASSWORD, false);
$requester->requestTransaction($request);
```

