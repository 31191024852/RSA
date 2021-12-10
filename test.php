<?php
//   $private_key = file_get_contents('key/private/8c3f19d9a36bab315cea7830f6a2ebf0.pem');
    
//   $public_key = <<<EOD
//   -----BEGIN PUBLIC KEY-----
//   MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxrYgDjuCAIWuDvKKnmCR
//   jQu/v9fiS7CkRc77NiecUMIZVblQlwbCwjj7HUCzNySmjAibF2N+1LcZ30NRDQ0Z
//   kaCj6BUKsX8hw/evJg2lQuTqwBx+w+/Rk/LqW24liV/GBSBumSz+TWQabZtL1mCz
//   o8QUE1qXHIKlOGdr2q5p8/MDKpSUqaWPqm2ylf2Pi9JzJ0aksA2qMpMfca5dP7zz
//   ZrKqvX2KYS46a7+YNUwbel9cRfhN83+wCGeDYwFcsXZRMYxWg62qGgID75exu9he
//   my0HnhtN3ZMr0hogqZBFUTJe254P0oAMLMRtaMncDhk7mL0pySEQ4rzDGUHRGbWi
//   2wIDAQAB
//   -----END PUBLIC KEY-----
//   EOD;
$prk = file_get_contents('key/private/8c3f19d9a36bab315cea7830f6a2ebf0.pem');
$data0 = file_get_contents('input.txt');
function sign($cleartext,$private_key){

  $msg_hash = md5($cleartext);
  openssl_private_encrypt($msg_hash, $sig, $private_key);
  $signed_data = $cleartext . "----SIGNATURE:----" . $sig;
  return $signed_data;
}
$data0bf=sign($data0,$prk);
echo $data0bf;

$data0end = base64_encode($data00);

file_put_contents('output.txt',$data0end);


$plk = file_get_contents('key/public/66854ca5769479268131dd1fd7fc2bf9.pem');
$data = file_get_contents('output.txt');
$data_bf= base64_decode($data);
openssl_public_decrypt($data_bf,$data,$plk);

function verify($data,$public_key){
  
  
  $redata = explode("----SIGNATURE:----", $data);
  openssl_public_decrypt($redata[1], $decrypted_sig, $public_key);
  $data_hash = md5($redata[0]);
  if($decrypted_sig == $data_hash && strlen($data_hash)>0)
      return $plain_data;
  else
      return null;
}

    
?>
