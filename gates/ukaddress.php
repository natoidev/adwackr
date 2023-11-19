<?php

function get_str($string, $start, $end) {
  return explode($end, explode($start, $string)[1])[0];
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.fakexy.com/fake-address-generator-uk');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'Host: www.fakexy.com';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Referer: https://www.google.com/';
$headers[] = 'DNT: 1';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-Site: cross-site';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'TE: trailers';
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));
$curl = curl_exec($ch);
curl_close($ch);

$street_1 = get_str($curl, '<td>Street</td>','/n');
$city_1 = get_str($curl, '<td>City/Town</td>','/n');
$state_1 = get_str($curl, '<td>State/Province/Region</td>','/n');
$postal_1 = get_str($curl, '<td>Zip/Postal Code</td>','/n');
$phone_1 = get_str($curl, '<td>Phone Number</td>','/n');
$country_1 = get_str($curl, '<td>Country</td>','/n');
$lat_1 = get_str($curl, '<td>Latitude</td>','/n');
$lon_1 = get_str($curl, '<td>Longitude</td>','/n');


$street_uk = get_str($street_1, '<td>','</td>');
$city_uk = get_str($city_1, '<td>','</td>');
$state_uk = get_str($state_1, '<td>','</td>');
$postal_uk = get_str($postal_1, '<td>','</td>');
$phone_uk = get_str($phone_1, '<td>','</td>');
$country_uk = get_str($country_1, '<td>','</td>');
$lat_uk = get_str($lat_1, '<td>','</td>');
$lon_uk = get_str($lon_1, '<td>','</td>');



$json = array("street" => $street_uk, "city" => $city_uk, "state" => $state_uk, "postal" => $postal_uk, "phone" => $phone_uk, "country" => $country_uk, "Latitude" => $lat_uk, "Longitude" => $lon_uk);

echo json_encode($json);

?>

