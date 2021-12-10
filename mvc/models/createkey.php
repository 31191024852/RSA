<?php
    class createKey
    {
        function createKey($cccd)
        {
            $config = array(
                "digest_alg" => "sha512",
                "private_key_bits" => 2048,
                "private_key_type" => OPENSSL_KEYTYPE_RSA,
            );
            $resource = openssl_pkey_new($config);
            $namepri = md5($cccd);
            // Extract private key from the pair
            openssl_pkey_export_to_file($resource, SSS.'/key/private/'.$namepri.'.pem' );
            // Extract public key from the pair
            $key_details = openssl_pkey_get_details($resource);
            $public_key = $key_details["key"];
            // if(openssl_pkey_export_to_file($public_key, SSS.'./key/public/'.md5($namepri).'.pem' )){
            //     echo "<script> alert('Key không tồn tại. Vui long nhập lại')</script>";
            // }
            file_put_contents(SSS.'./key/public/'.md5($namepri).'.pem', $public_key);
            
            $dn = array(
                "countryName" => "VN",
                "stateOrProvinceName" => "Viet Nam",
                "localityName" => isset($_POST['fullname'])?$_POST['fullname']:'non',
                "organizationName" => isset($_POST['fullname'])?$_POST['fullname']:'non',
                "organizationalUnitName" => isset($_POST['fullname'])?$_POST['fullname']:'non',
                "commonName" => isset($_POST['fullname'])?$_POST['fullname']:'non',
                "emailAddress" => isset($_POST['email'])?$_POST['email']:'non'
            );

            // Generate a certificate signing request
            $csr = openssl_csr_new($dn, $private_key, array('digest_alg' => 'sha512'));
            // Generate a self-signed cert, valid for 365 days
            $x509 = openssl_csr_sign($csr, null, $private_key, $days=365, array('digest_alg' => 'sha512'));
            file_put_contents(SSS.'./key/crt/'.md5(md5($namepri)).'.pem', $x509);
            
            $key['crt'] = md5(md5($namepri));
            $key['publickey'] = md5($namepri);
            $key['privatekey'] = $namepri;
            return $key;
        }
    }
