<?php
if ($_POST['phone']> '')
{
$name = $_POST['fields'][273045]['value'] ?? $_POST['name'] ?? '';
$phone = $_POST['fields'][264311]['value'] ?? $_POST['phone'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$url = $_SERVER['HTTP_HOST'];

$to = "order.ua.dv@gmail.com";//

$header = "Content-type: text/plain; charset=UTF-8\r\n";
$header .= "From: no-reply@$url\r\n";
$header .= "Reply-To: order.ua.dv@gmail.com\r\n";
$header .= "MIME-Version: 1.0\r\n";

$title = "Заказ ОЗЕМ $url";
$message = "Имя: $name \nТелефон: $phone IP-adress: $ip";

$mail = mail($to, $title, $message, $header);
}
?>
<?php
include('../config.php');
include('../../configdomen.php');

//***************** Страница с завершением заказа ******************
session_start();
 
// формируем массив с товарами в заказе (если товар один - оставляйте только первый элемент массива)
$volumeRaw = $_POST['comment'] ?? '';
$volumeParts = explode('|', $volumeRaw);

$newPrice = (int)($_POST['product_price'] ?? 299);
$oldPrice = (int)($volumeParts[1] ?? 0);
$volume    = $volumeParts[2] ?? '250мл';


$products_list = array(
    0 => array(
        'product_id' => 47,      // ОСТАВЬ один ID, если это один товар
        'price'      => $newPrice,
        'count'      => 1,
    )
);

$products = urlencode(serialize($products_list));
$sender = urlencode(serialize($_SERVER));
// параметры запроса

$volumeRaw = isset($_POST['comment']) ? $_POST['comment'] : '';
$volumeParts = explode('|', $volumeRaw);
$volumeText = isset($volumeParts[2]) ? $volumeParts[2] : 'не вибрано';

$data = array(
    'key'             => '5a45c7795e8f4b68a044a6f03e503b55', //Ваш секретный токен
    'order_id'        => number_format(round(microtime(true)*10),0,'.',''), //идентификатор (код) заказа (*автоматически*)
    'country'         => 'UA',                         // Географическое направление заказа
    'office'          => '1',                          // Офис (id в CRM)
    'products'        => $products,                    // массив с товарами в заказе
    'bayer_name'      => $name,            // покупатель (Ф.И.О)
    'phone'           => $phone,           // телефон
    'email'           => $_REQUEST['email'],           // электронка
    'comment'         => 'ОЗЕМ',    // комментарий
    'delivery'        => $_REQUEST['delivery'],        // способ доставки (id в CRM)
    'delivery_adress' => $_REQUEST['delivery_adress'], // адрес доставки
    'payment'         => '',                           // вариант оплаты (id в CRM)
    'sender'          => $sender,                        
    'utm_source'      => $_SESSION['utms']['utm_source'],  // utm_source
    'utm_medium'      => $_SESSION['utms']['utm_medium'],  // utm_medium
    'utm_term'        => $_SESSION['utms']['utm_term'],    // utm_term
    'utm_content'     => $_SESSION['utms']['utm_content'], // utm_content
    'utm_campaign'    => $_SESSION['utms']['utm_campaign'],// utm_campaign
    'additional_1'    => '',                               // Дополнительное поле 1
    'additional_2'    => '',                               // Дополнительное поле 2
    'additional_3'    => '',                               // Дополнительное поле 3
    'additional_4'    => ''                                // Дополнительное поле 4
);
 
// запрос
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://ssdivision.lp-crm.biz/api/addNewOrder.html');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
$out = curl_exec($curl);
curl_close($curl);
//$out – ответ сервера в формате JSON
?>
<!DOCTYPE html>
<html lang="ru">
    <head>


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '2020567495250648');
fbq('track', 'PageView');
fbq('track', 'Lead');
fbq('track', 'Purchase');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=2020567495250648&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->



        <meta charset="utf-8">
        <title>Поздравляем! Ваш заказ принят!</title><script>fbq('track', 'Lead');</script>
        <style type="text/css">
            html {
  line-height: 1.15; /* 1 */
  -webkit-text-size-adjust: 100%; /* 2 */
}

/* Sections
   ========================================================================== */

/**
 * Remove the margin in all browsers.
 */

body {
  margin: 0;
}

/**
 * Render the `main` element consistently in IE.
 */

main {
  display: block;
}

/**
 * Correct the font size and margin on `h1` elements within `section` and
 * `article` contexts in Chrome, Firefox, and Safari.
 */

h1 {
  font-size: 2em;
  margin: 0.67em 0;
}

/* Grouping content
   ========================================================================== */

/**
 * 1. Add the correct box sizing in Firefox.
 * 2. Show the overflow in Edge and IE.
 */

hr {
  box-sizing: content-box; /* 1 */
  height: 0; /* 1 */
  overflow: visible; /* 2 */
}

/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */

pre {
  font-family: monospace, monospace; /* 1 */
  font-size: 1em; /* 2 */
}

/* Text-level semantics
   ========================================================================== */

/**
 * Remove the gray background on active links in IE 10.
 */

a {
  background-color: transparent;
}

/**
 * 1. Remove the bottom border in Chrome 57-
 * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
 */

abbr[title] {
  border-bottom: none; /* 1 */
  text-decoration: underline; /* 2 */
  text-decoration: underline dotted; /* 2 */
}

/**
 * Add the correct font weight in Chrome, Edge, and Safari.
 */

b,
strong {
  font-weight: bolder;
}

/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */

code,
kbd,
samp {
  font-family: monospace, monospace; /* 1 */
  font-size: 1em; /* 2 */
}

/**
 * Add the correct font size in all browsers.
 */

small {
  font-size: 80%;
}

/**
 * Prevent `sub` and `sup` elements from affecting the line height in
 * all browsers.
 */

sub,
sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline;
}

sub {
  bottom: -0.25em;
}

sup {
  top: -0.5em;
}

/* Embedded content
   ========================================================================== */

/**
 * Remove the border on images inside links in IE 10.
 */

img {
  border-style: none;
}

/* Forms
   ========================================================================== */

/**
 * 1. Change the font styles in all browsers.
 * 2. Remove the margin in Firefox and Safari.
 */

button,
input,
optgroup,
select,
textarea {
  font-family: inherit; /* 1 */
  font-size: 100%; /* 1 */
  line-height: 1.15; /* 1 */
  margin: 0; /* 2 */
}

/**
 * Show the overflow in IE.
 * 1. Show the overflow in Edge.
 */

button,
input {
  /* 1 */
  overflow: visible;
}

/**
 * Remove the inheritance of text transform in Edge, Firefox, and IE.
 * 1. Remove the inheritance of text transform in Firefox.
 */

button,
select {
  /* 1 */
  text-transform: none;
}

/**
 * Correct the inability to style clickable types in iOS and Safari.
 */

button,
[type="button"],
[type="reset"],
[type="submit"] {
  -webkit-appearance: button;
}

/**
 * Remove the inner border and padding in Firefox.
 */

button::-moz-focus-inner,
[type="button"]::-moz-focus-inner,
[type="reset"]::-moz-focus-inner,
[type="submit"]::-moz-focus-inner {
  border-style: none;
  padding: 0;
}

/**
 * Restore the focus styles unset by the previous rule.
 */

button:-moz-focusring,
[type="button"]:-moz-focusring,
[type="reset"]:-moz-focusring,
[type="submit"]:-moz-focusring {
  outline: 1px dotted ButtonText;
}

/**
 * Correct the padding in Firefox.
 */

fieldset {
  padding: 0.35em 0.75em 0.625em;
}

/**
 * 1. Correct the text wrapping in Edge and IE.
 * 2. Correct the color inheritance from `fieldset` elements in IE.
 * 3. Remove the padding so developers are not caught out when they zero out
 *    `fieldset` elements in all browsers.
 */

legend {
  box-sizing: border-box; /* 1 */
  color: inherit; /* 2 */
  display: table; /* 1 */
  max-width: 100%; /* 1 */
  padding: 0; /* 3 */
  white-space: normal; /* 1 */
}

/**
 * Add the correct vertical alignment in Chrome, Firefox, and Opera.
 */

progress {
  vertical-align: baseline;
}

/**
 * Remove the default vertical scrollbar in IE 10+.
 */

textarea {
  overflow: auto;
}

/**
 * 1. Add the correct box sizing in IE 10.
 * 2. Remove the padding in IE 10.
 */

[type="checkbox"],
[type="radio"] {
  box-sizing: border-box; /* 1 */
  padding: 0; /* 2 */
}

/**
 * Correct the cursor style of increment and decrement buttons in Chrome.
 */

[type="number"]::-webkit-inner-spin-button,
[type="number"]::-webkit-outer-spin-button {
  height: auto;
}

/**
 * 1. Correct the odd appearance in Chrome and Safari.
 * 2. Correct the outline style in Safari.
 */

[type="search"] {
  -webkit-appearance: textfield; /* 1 */
  outline-offset: -2px; /* 2 */
}

/**
 * Remove the inner padding in Chrome and Safari on macOS.
 */

[type="search"]::-webkit-search-decoration {
  -webkit-appearance: none;
}

/**
 * 1. Correct the inability to style clickable types in iOS and Safari.
 * 2. Change font properties to `inherit` in Safari.
 */

::-webkit-file-upload-button {
  -webkit-appearance: button; /* 1 */
  font: inherit; /* 2 */
}

/* Interactive
   ========================================================================== */

/*
 * Add the correct display in Edge, IE 10+, and Firefox.
 */

details {
  display: block;
}

/*
 * Add the correct display in all browsers.
 */

summary {
  display: list-item;
}

/* Misc
   ========================================================================== */

/**
 * Add the correct display in IE 10+.
 */

template {
  display: none;
}

/**
 * Add the correct display in IE 10.
 */

[hidden] {
  display: none;
}
li {
  list-style-type: none; /* Убираем маркеры */
}
a {
  text-decoration: none;
}

          * {
    font-size: 20px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
body {
    background-color: rgb(238, 241, 243);
}
.wrapper {
    padding: 20px 15px 0;
}
.thank_header {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 0;
    line-height: 1;
    margin-bottom: 10px;
}
.thank__h1 {
    color: rgb(10, 161, 80);
    font-size: 40px;
    text-align: center;
    margin: 10px 0;
}
.thank__text {
    margin: 10px 0;
    text-align: center;
    line-height: 1.5;
}
._error {
    font-size: 17px;
    line-height: 1.5;
}
.thank__img {
    width: 50%;
}
.thank__block {
}

.thank__button {
    background: rgba(10, 161, 80, 0.822);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px 36px;
    min-height: 48px;
    letter-spacing: 0.2px;
    color: rgb(255, 255, 255);
    font-weight: 700;
    line-height: 150%;
    text-align: center;
}
.thank__button:hover {
    background: rgb(10, 161, 80);
    border-radius: 20px;
}
.offer {
    line-height: 1.5;
    color: #fff;
    text-transform: uppercase;
    padding: 20px 15px;
    background: rgb(1, 206, 97);
    margin: 0 -20px;
    text-align: center;
}
.offer__heder-text {
    font-weight: bold;
}
.offer__text {
}
.container_main {
    width: 100%;
}
.container__block {
    background-color: #fff;
    margin: 50px auto;
    width: 92%;
    display: flex;
    max-width: 900px;
    flex-wrap: wrap;
    align-items: flex-start;
    justify-content: center;
}
.container__block-img {
    width: 45%;
    padding: 10px;
    min-width: 250px;
}
.container__img {
    width: 100%;
}
.container__block-text {
    padding: 10px;
    width: 45%;
}
.main-text {
    font-weight: normal;
    font-size: 28px;
    line-height: 1.2;
}
.img_stars {
    margin: 10px 0;
}
.prise {
}
.small {
    text-decoration: line-through;
    color: rgb(112, 112, 112);
    font-size: 20px;
}
.big {
    margin-left: 10px;
    font-size: 27px;
    font-weight: bold;
}
.thername-text {
    line-height: 1.5;
    font-size: 16px;
}
.thank__block {
    max-width: 200px;
    margin: 0 auto;
}
.thank__button {
}
@media (max-width: 600px) {
    * {
        font-size: 16px;
    }
    .wrapper {
        padding: 10px;
    }
    .thank__h1 {
        font-size: 30px;
    }
    .container__block-img {
        width: 90%;
    }
    .container__block-text {
        width: 90%;
    }
    .thank__text {
        font-size: 16px;
        margin: 7px 0;
    }
    ._error {
        font-size: 13px;
    }
    .offer {
        font-size: 16px;
    }
    .main-text {
        margin: 0;
    }
    .thank__img {
        width: 100%;
    }
    .thank__block {
        padding: 10px 0;
        margin: 0 auto;
    }
}

        </style> 

		
    </head>
    <body>

    <div class="wrapper">
        <header class="thank_header">
            <h1 class="thank__h1">Дякуємо, Ваше замовлення прийнято!</h1>
            <div class="thank__text">Наш консультант найближчим часом зв’яжеться з Вами для підтвердження замовлення</div>
            <div class="thank__text">
                Графік роботи нашого магазину: понеділок-п'ятниця з 9.00 до 19.00, субота-неділя з 10.00 до 17.00. Якщо замовлення було здійснено в неробочий час - ми зв'яжемося з вами наступного дня.
            </div>
            <img src="thankyou-divider.png" class="thank__img"></img>
            <div class="thank__text _error">
                Перевірте правильність данних (ім'я, номер). Якщо Ви зробили помилку - поверніться на сторінку оформлення замовлення та надішліть форму повторно.
            </div>
            <div class="thank__block">
                <a href="javascript: history.back(-1);" class="thank__button">Повернутися</a>
            </div>
        </header>
        <div class="offer thank_header">
            <div class="offer__heder-text">У нас є унікальна пропозиція для нових клієнтів!</div>
            <div class="offer__text"> Ви можете додати ці товари до свого замовлення з додатковою знижкою:</div>
        </div>
        <div class="container">
            <div class="container_main">
                <div class="container__block">
                    <div class="container__block-img">
                        <img src="upsale1.gif" alt="" class="container__img">
                    </div>

                    <div class="container__block-text">
                        <h2 class="main-text">TREEKILL — ГЕРБІЦИД ДЛЯ ВИДАЛЕННЯ ДЕРЕВ</h2>
                        <img src="thankyou-rating.png" alt="" class="img_stars">
                        <div class="prise">
                            <span class="small">599 грн.</span>
                            <span class="big">249 грн.</span>
                        </div>
                        <p class="thername-text">Це високоефективний гербіцид, розроблений для видалення небажаних дерев, пеньків та їх паростків. Формула проникає в тканини та кореневу систему, зупиняє ріст і запобігає повторному проростанню. Ідеально для очищення саду, присадибної ділянки або промислових територій. Застосовується на пеньках після зрізу, дикорослих деревах, кущах і чагарниках.</p>
                        <div class="thank__block">
                            <a href="САЙТ" class="thank__button">Запитай у менеджера</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="container_main">
                <div class="container__block">
                    <div class="container__block-img">
                        <img src="upsale2.gif" alt="" class="container__img">
                    </div>

                    <div class="container__block-text">
                        <h2 class="main-text">ДЛЯ КАРТОПЛІ ДОБРИВО - МАКСИМАЛЬНИЙ ВРОЖАЙ</h2>
                        <img src="thankyou-rating.png" alt="" class="img_stars">
                        <div class="prise">
                            <span class="small">599 грн.</span>
                            <span class="big">249 грн.</span>
                        </div>
                        <p class="thername-text">Збільшує врожайність картоплі понад 30%, формуючи більше великих і якісних бульб завдяки активному росту, сильній кореневій системі та кращому засвоєнню поживних речовин. Потужний ріст і надійний захист вашого врожаю Мікродобриво активізує розвиток кореневої системи, прискорює ріст рослин та допомагає сформувати великі, здорові бульби. Завдяки комплексу мікроелементів у хелатній формі рослина швидко засвоює всі необхідні поживні речовини. Зміцнює імунітет, знижує ризик хвороб та допомагає картоплі легко переносити стреси, посуху і перепади температур.</p>
                        <div class="thank__block">
                            <a href="#" class="thank__button">Запитай у менеджера</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="container_main">
                <div class="container__block">
                    <div class="container__block-img">
                        <img src="upsale3.gif" alt="" class="container__img">
                    </div>

                    <div class="container__block-text">
                        <h2 class="main-text">ВІД БУР'ЯНУ ГЕБРІЦИД - 250 мл</h2>
                        <img src="thankyou-rating.png" alt="" class="img_stars">
                        <div class="prise">
                            <span class="small">549 грн.</span>
                            <span class="big">249 грн.</span>
                        </div>
                        <p class="thername-text">Бур’ян «душить» розсаду і краде твої гроші? Це високоефективний гербіцид ВІД БУР'ЯНУ, розроблений для видалення бур'яну усіх типів та їх паростків. Формула проникає в тканини та кореневу систему, зупиняє ріст і запобігає повторному проростанню. Ідеально для очищення саду, присадибної ділянки або промислових територій. Застосовується на пеньках після зрізу, дикорослих деревах, кущах і чагарниках.</p>
                            <a href="#" class="thank__button">Запитай у менеджера</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
 </body>
</html>