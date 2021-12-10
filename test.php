<?php
  $private_key = file_get_contents('key/private/8c3f19d9a36bab315cea7830f6a2ebf0.pem');
    
  $public_key = <<<EOD
  -----BEGIN PUBLIC KEY-----
  MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxrYgDjuCAIWuDvKKnmCR
  jQu/v9fiS7CkRc77NiecUMIZVblQlwbCwjj7HUCzNySmjAibF2N+1LcZ30NRDQ0Z
  kaCj6BUKsX8hw/evJg2lQuTqwBx+w+/Rk/LqW24liV/GBSBumSz+TWQabZtL1mCz
  o8QUE1qXHIKlOGdr2q5p8/MDKpSUqaWPqm2ylf2Pi9JzJ0aksA2qMpMfca5dP7zz
  ZrKqvX2KYS46a7+YNUwbel9cRfhN83+wCGeDYwFcsXZRMYxWg62qGgID75exu9he
  my0HnhtN3ZMr0hogqZBFUTJe254P0oAMLMRtaMncDhk7mL0pySEQ4rzDGUHRGbWi
  2wIDAQAB
  -----END PUBLIC KEY-----
  EOD;

   //Manage to make it work at last.

$dn = array(
  "countryName" => "XX",
  "stateOrProvinceName" => "Location",
  "localityName" => "Local",
  "organizationName" => "Sample Organization",
  "organizationalUnitName" => "Organizational Unit",
  "commonName" => "Sample",
  "emailAddress" => "contactus@email.com"
);


// Generate a certificate signing request
$csr = openssl_csr_new($dn, $private_key, array('digest_alg' => 'sha512'));

// Generate a self-signed cert, valid for 365 days
$x509 = openssl_csr_sign($csr, null, $private_key, $days=365, array('digest_alg' => 'sha512'));

// Save your private key, CSR and self-signed cert for later use
openssl_csr_export($csr, $csrout) and var_dump($csrout); // .csr
openssl_x509_export($x509, $certout) and var_dump($certout); // .crt.pem
openssl_pkey_export($private_key, $pkeyout, "user_defined_password") and var_dump($pkeyout); // .key.pem


if(openssl_cms_sign( "input.txt", "test.txt" , $x509 , $private_key, null , 0 , 0 , null)){
  echo "SIGNED SUCCESSFULLY! Sample.p7m created... \r\n";
}
else
{
  echo "SIGNED FAILED!\r\n";
}

    
?>
