<?php



    // You can get a simple private/public key pair using:
    // openssl genrsa 512 >private_key.txt
    // openssl rsa -pubout <private_key.txt >public_key.txt
    
    // IMPORTANT: The key pair below is provided for testing only.
    // For security reasons you must get a new key pair
    // for production use, obviously.
    
    $private_key = file_get_contents('C:\xampp\htdocs\RSA\key\private\781e5e245d69b566979b86e28d23f2c7.pem');
    
    $public_key = <<<EOD
    -----BEGIN PUBLIC KEY-----
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqOrVYCcUz9VhqjVACaXz
    8XpyvU/ZqFN8//obTE7B3CvHB2xEDPwP8O6cLuuxLlqSL/CG/2yKqr8Sa0ibJcAE
    vMUF//lvpld3YvN2pjW0QCdzTh74/5OTuKiepcNugbsemOH8TLCs0LOcXXmTxXdW
    2GjoAyj3AVKrWmQdsm1CbO7P3QmZLX5hm19ZCbi+hzp73vs2e1cL5NkqP2J6Ho8F
    OWRa5kQYlDg9wZ0IKpxIAytm8Yoo1xO9Vaur/FKy6Nja6SSnFZmmsnnCNFAI61sm
    jgPONCnWLHDnlh2pLB1uBRaOrCB/5asS1CR8S6UBRAtsOLFQrBGvigY7XZ8mTM1R
    ZwIDAQAB
    -----END PUBLIC KEY-----
    EOD;
    
    //Manage to make it work at last.

    $crt = file_get_contents('C:\xampp\htdocs\RSA\key\crt\5914bfe3b399a2556ffc730f19166b22.pem');
    echo $crt;

    function signAndEncrypt(string $rawData): string
    {
        $tempDir = __DIR__ . '/tmp';
        $tempfileOriginal = tempnam($tempDir, 'original');
        $tempfileSigned = tempnam($tempDir, 'signed');
        $tempfileEncrypted = tempnam($tempDir, 'signedEncrypted');
    
        file_put_contents($tempfileOriginal, $rawData);
    
        // pick the correct certificate for the recipient
        $recipientsCertificateFile = __DIR__ . '/recipientsCertificate.pem';
        // -----BEGIN CERTIFICATE----- ...-----END CERTIFICATE-----
        $recipientsCertificate = file_get_contents($recipientsCertificateFile);
    
        // Certificate:
        //    Data:
        //        Version: 3 (0x2)...
        $myCertificate = file_get_contents(__DIR__ . '/my.crt');
        $myPrivateKey = openssl_pkey_get_private(
            // -----BEGIN RSA PRIVATE KEY----- ... -----END RSA PRIVATE KEY-----
            file_get_contents(__DIR__ . '/my.prv.key.pem')
        );
    
        openssl_cms_sign(
            input_filename: $tempfileOriginal,
            output_filename: $tempfileSigned,
            certificate: $myCertificate,
            private_key: $myPrivateKey,
            headers: [],
            encoding: OPENSSL_ENCODING_DER,
        );
    
        openssl_cms_encrypt(
            input_filename: $tempfileSigned,
            output_filename: $tempfileEncrypted,
            certificate: $recipientsCertificate,
            headers: [],
            flags: OPENSSL_CMS_BINARY,
            encoding: OPENSSL_ENCODING_DER,
            cipher_algo: OPENSSL_CIPHER_AES_256_CBC
        );
        return file_get_contents($tempfileEncrypted);
    }

    function decryptAndVerify($signedAndEncryptedRawData): string
{
    $tempDir = __DIR__ . '/tmp';
    $originalFile = tempnam($tempDir, 'original');
    $decryptedFile = tempnam($tempDir, 'decrypted');
    $verifiedFile = tempnam($tempDir, 'verified');

    file_put_contents($originalFile, $signedAndEncryptedRawData);
   
    // One file with all possible certificates one after the other
    // -----BEGIN CERTIFICATE----- ...-----END CERTIFICATE-----
    $allPossibleSenderCertificates = __DIR__ . '/untrusted.pem';

    // Certificate:
    //    Data:
    //        Version: 3 (0x2)...
    $myCertificate = file_get_contents(__DIR__ . '/my.crt');
    $myPrivateKey = openssl_pkey_get_private(
    // -----BEGIN RSA PRIVATE KEY----- ... -----END RSA PRIVATE KEY-----
        file_get_contents(__DIR__ . '/my.prv.key.pem')
    );
   
    openssl_cms_decrypt(
        input_filename: $originalFile,
        output_filename: $decryptedFile,
        certificate: $myCertificate,
        private_key: $myPrivateKey,
        encoding: OPENSSL_ENCODING_DER
    );

    openssl_cms_verify(
        input_filename: $decryptedFile,
        flags: OPENSSL_CMS_BINARY,
        ca_info: [],
        untrusted_certificates_filename: $allPossibleSenderCertificates,
        content: $verifiedFile,
        encoding: OPENSSL_ENCODING_DER
    );
    return file_get_contents($verifiedFile);
}
