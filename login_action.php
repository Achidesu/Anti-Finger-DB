<?php
session_start();

$url = "https://script.google.com/macros/s/AKfycbwgb3-Aq7OoHGGYP7tkZi2Qo6kAmr7w1Y-xqjq6pb0FucQRsKEgWsXn2FY2jtlAgsF3/exec";
$postData = [
   "action" => "login",
   "username" => $_POST['username'],
   "password" => $_POST['password']
];

$ch = curl_init($url);
curl_setopt_array($ch, [
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_POSTFIELDS => $postData
]);

$result = curl_exec($ch);
$result = json_decode($result, 1);

if($result['status'] == "success"){
   $_SESSION['user'] = $result['data'];
   header("location: dashboard.php");
}else{
   $_SESSION['error'] = $result['message'];
   header("location: index.php");
}
