<?php
$settings = include 'settings.php';
//global $settings;

//print_r(var_dump($_POST));

/* Здесь проверяется существование переменных */
$sub_id = '';
    $data=true;

if (isset($_POST['name']) && isset($_POST['phone'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
} else {
    $data=false;
}

if (isset($_POST['sub_id'])) {
    $sub_id = $_POST['sub_id'];
}

if ($data) {
    $hash = md5($name.$phone);
    if(isset($_COOKIE['verify']) && $_COOKIE['verify'] == $hash) {
        echo iconv("utf-8", "windows-1251", 'Заказ с введенными данными уже отправлен');
        exit();
    }
    setcookie('verify', $hash, time()+120);

    $country_id = 4; //код Казахстана
    $price = $settings['new_kz_price'];  //цена для Казахстана
    $countryCode = $_POST['country'];
    if($countryCode == 'RU') {
        $country_id = 1; //код России
        $price = $settings['new_ru_price'];  //цена для России
    }

    $body=array(
        'fullName' => $_POST['name'], // Полное имя клиента
        'phone' => $_POST['phone'], // номер телефона
        'price' => $price, // Цена офера на лендинге (если 1 рубль, то 1; если 149, то 149)
        'country' => $country_id, // Номер старны (1 — Россия, 2 — Беларусь, 3 — Украина, 4 — Казахстан)
        'sub_id' => array($sub_id),
        'offerId' => $settings['id_offer'], // offer id в нашей системе
        'partnerId' => $settings['partner_id'], // Номер клинта в системе 
        'access-token' => $settings['tokken_partner'] // Из раздела http://new.m4leads.com/partner/api    

    );

    if ($curl = curl_init())
    {
        $URL = 'http://api.m4leads.com/order/add?';
      curl_setopt($curl, CURLOPT_URL, $URL.http_build_query($body));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($curl);
      curl_close($curl);
    }
}

ini_set('short_open_tag', 'On');
//header('Refresh: 3; URL=index.html');
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <?php if (!empty($settings['pixel'])): ?>
      <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo $settings['pixel'] ?>');
        fbq('track', 'Lead');
      </script>
      <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?php echo $settings['pixel'] ?>&ev=PageView&noscript=1"
      /></noscript>
    <?php endif ?>
    <meta charset="utf-8">
    <title>Спасибо за покупку!</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name='viewport' content='width=device-width'/>
    <meta content="true" name="HandheldFriendly">
    <meta content="width" name="MobileOptimized">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <link href="thanks/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,700,800,900|Open+Sans:400,700" rel="stylesheet">
  </head>
  <body>
      <div class="wrapper">
        <div class="header">
          <div class="inner">
            <p>Спасибо!</p>
            <p>Ваша заявка успешно принята!</p>
          </div>
        </div>

        <section class="fifteen">
          <div class="inner">
            <div class="fifteen__block">
              <p>В течение 15 минут</p>
              <p>Ваш личный менеджер позвонит вам</p>
              <p>для уточнения деталей.</p>
            </div>
          </div>
        </section>


        <img class="down" src="thanks/img/down.png" alt="">
        <section class="conc">
          <div class="inner">
            <div class="conc__block">
              <?php if (!empty($name)): ?>
                <p>Поздравляем <?php echo $name ?>!</p>
              <?php endif ?>
              <p>Вы учавствуете в нашей акции и получаете скидку на курс.</p>
              <p>Подробнее можно узнать у Вашего личного Менеджера.</p>
            </div>
          </div>
        </section>
        <section class="flag">
          <div class="inner">
              <?php if (!empty($country_id)): ?>
                <?php if ($country_id == 1): ?>
                  <img class="fl" src="thanks/img/flag-ru.jpg" alt="">
                <?php else: ?>
                  <img class="fl" src="thanks/img/flag-kz.jpg" alt="">
                <?php endif ?>
              <?php endif ?>
            <span>Мы гарантируем конфиденциальность Ваших данных!</span>
          </div>
        </section>
        <section class="about">
          <div class="inner">
            <p>О нас говорят и пишут:</p>
            <p>
              <img src="thanks/img/first.jpg" alt="">
              <img src="thanks/img/starhit.png" alt="">
              <img src="thanks/img/cosmo.png" alt="">
            </p>
          </div>
        </section>
      </div>
  </body>
</html>