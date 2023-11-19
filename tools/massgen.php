<?php


if (preg_match('/^\/mgen (\d+) (\d+)$/', $message, $matches)) {

    $bin = $matches[1];
    $amount = min(intval($matches[2]), 1000); 


    $cardDetails = [];

    for ($i = 0; $i < $amount; $i++) {
        $cardNumber = generateCardNumber($bin);
        $expiration = generateExpirationDate();
        $cvv = generateCVV();
        $cardDetails[] = "$cardNumber|$expiration|$cvv";
    }

$filename = 'shadow_massgen.txt';
    file_put_contents($filename, implode("\n", $cardDetails));

    sendDocument($chatId, $filename, $message_id);

    unlink($filename);
}

function generateCardNumber($bin) {
    $remainder = 15 - strlen($bin);
    $number = $bin;
    for ($i = 0; $i < $remainder; $i++) {
        $number .= rand(0, 9);
    }
    // Append Luhn checksum digit
    $number .= luhnCheckSum($number);
    return $number;
}

function luhnCheckSum($number) {
    $sum = 0;
    $reverseDigits = strrev($number);

    for ($i = 0; $i < strlen($reverseDigits); $i++) {
        $n = intval($reverseDigits[$i]);
        if ($i % 2 == 0) {
            $n *= 2;
            if ($n > 9) {
                $n -= 9;
            }
        }
        $sum += $n;
    }

    return (10 - ($sum % 10)) % 10;
}


function generateExpirationDate() {
    $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
    $year = date('y') + rand(0, 8); // Current year (last 2 digits) + up to 5 years in the future
    return "$month|$year";
}

function generateCVV() {
    return rand(100, 999);
}

function sendDocument($chatId, $filename, $replyToMessageId) {
    $url = $GLOBALS['website'] . "/sendDocument";
    $post_fields = [
        'chat_id' => $chatId,
        'document' => new CURLFile(realpath($filename)),
        'reply_to_message_id' => $replyToMessageId
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type:multipart/form-data"
    ]);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
?>
