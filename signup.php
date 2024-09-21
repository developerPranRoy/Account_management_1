<?php

$name =$_POST['name'];
$email =$_POST['email'];
$password =$_POST['pass'];
$image64 = $_POST ['image'];
$key = $_POST ['key'];

$secEmail =decryptData($email);
$securitypass =decryptData($password);
$securityKey =decryptData($key);

if ($securityKey == 'pranto112233' && strlen($secEmail)>0 && $password>0){
    //========================================
    $connect = mysqli_connect('localhost','root','','mydatabase');
    $sqlSearch = "SELECT * FROM signup_login_table WHERE email Like ' $secEmail ' ";
    $result2 = mysqli_query($connect, $sqlSearch);
    $rows = mysqli_num_rows($result2);

    if ($rows ==0 ){

    
    $decodedImage =base64_decode($image64);
    $fileName =time().'_'.rand(10000,1000000).'.jpg';
    $filePath ='images/'.$fileName;


    if(file_put_contents($filePath,$decodedImage)){
   
    $sql= " INSERT INTO signup_login_table( name ,email, password,image ) VALUES( '$name','$email','$password','$filePath')";
    $result =mysqli_query( $connect,$sql );
    
    if ($result) { echo "Sign up succes";
    }else echo " Sign Up Failed";
   }


    }else {
        echo "Already have email";
    }


}


function decryptData($text ){
    $decode =base64_decode($text);
    $decrypted = openssl_decrypt($decode, 'AES-128-ECB','A\OM3J2:1XO+*=2%',OPENSSL_RAW_DATA);
    return $decrypted;

}




?>
