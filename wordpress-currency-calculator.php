<?php

/**
 * @package Currency Calculator
 * @version 1.0.0
 */
/*
Plugin Name:  Currency calculator
Plugin URI: https://github.com/PrinceChomu
Description: Calculates currency
Author: Prince Chomunorwa
Version: 1.0.0
Author URI: https://www.linkedin.com/in/prince-chomunorwa-5311aa15a/
*/

if (!defined('ABSPATH')) {
    exit;
}

// function pc_calculate_currency() {
//     // Check if the nonce is valid
//     if ( ! isset( $_POST['pc_calculate_currency_nonce'] ) || ! wp_verify_nonce( $_POST['pc_calculate_currency_nonce'], 'pc_calculate_currency' ) ) {
//       wp_die( 'Unauthorized access' );
//     }
  
//     $to = $POST_['pc_currency_to'];
//     $from = $POST_['pc_currency_from'];
//     $amout = $_POST_['pc_currency_amount'];

//     $curl = curl_init();

//     curl_setopt_array($curl, array(
//       CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=$to&from=$from&amount=$amount",
//       CURLOPT_HTTPHEADER => array(
//         "Content-Type: text/plain",
//         "apikey: B40K1uDEthwSyUQFk8HQyuZpVchoqeyt"
//       ),
//       CURLOPT_RETURNTRANSFER => true,
//       CURLOPT_ENCODING => "",
//       CURLOPT_MAXREDIRS => 10,
//       CURLOPT_TIMEOUT => 0,
//       CURLOPT_FOLLOWLOCATION => true,
//       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//       CURLOPT_CUSTOMREQUEST => "GET"
//     ));

//     $response = curl_exec($curl);

//     curl_close($curl);
//     die(json_encode($response));
// }

// add_action( 'admin_post_pc_calculate_currency', 'pc_calculate_currency' );



//Shortcode to display the membership value
add_shortcode('prince-calculate-currency', 'prince_calculate_currency');
function prince_calculate_currency($atts){
echo '

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
        }
        ::selection{
        color: #fff;
        background: #9200b0;
        }
        .wrapper{
        width: 370px;
        padding: 30px;
        border-radius: 7px;
        background: #fff;
        box-shadow: 7px 7px 20px rgba(0, 0, 0, 0.05);
        }
        .wrapper header{
        font-size: 28px;
        font-weight: 500;
        text-align: center;
        }
        .wrapper form{
        margin: 40px 0 20px 0;
        }
        form :where(input, select, button){
        width: 100%;
        outline: none;
        border-radius: 5px;
        border: none;
        }
        form p{
        font-size: 18px;
        margin-bottom: 5px;
        }
        form input{
        height: 50px;
        font-size: 17px;
        padding: 0 15px;
        border: 1px solid #999;
        }
        form input:focus{
        padding: 0 14px;
        border: 2px solid #675AFE;
        }
        form .drop-list{
        display: flex;
        margin-top: 20px;
        align-items: center;
        justify-content: space-between;
        }
        .drop-list .select-box{
        display: flex;
        width: 115px;
        height: 45px;
        align-items: center;
        border-radius: 5px;
        justify-content: center;
        border: 1px solid #999;
        }
        .select-box img{
        max-width: 21px;
        }
        .select-box select{
        width: auto;
        font-size: 16px;
        background: none;
        margin: 0 -5px 0 5px;
        }
        .select-box select::-webkit-scrollbar{
        width: 8px;
        }
        .select-box select::-webkit-scrollbar-track{
        background: #fff;
        }
        .select-box select::-webkit-scrollbar-thumb{
        background: #888;
        border-radius: 8px;
        border-right: 2px solid #ffffff;
        }
        .drop-list .icon{
        cursor: pointer;
        margin-top: 30px;
        font-size: 22px;
        }
        form .exchange-rate{
        font-size: 17px;
        margin: 20px 0 30px;
        }
        form button{
        height: 52px;
        color: #fff;
        font-size: 17px;
        cursor: pointer;
        background: #9200b0;
        transition: 0.3s ease;
        }
        form button:hover{
        background: #b501da;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>    
    <div class="wrapper">
      <header>Currency Converter</header>
      <form action="'. esc_url( admin_url('admin-post.php') ) .'">
      '. wp_nonce_field( 'pc_calculate_currency', 'pc_calculate_currency_nonce' ) .'
        <div class="amount">
          <p>Enter Amount</p>
          <input type="text" value="1" name="pc_currency_amount" id="pc_currency_amount">
        </div>
        <div class="drop-list">
          <div class="from">
            <p>From</p>
            <div class="select-box">
              <img src="https://flagcdn.com/48x36/us.png" alt="flag">
              <select name="pc_currency_from" class="pc_currency_country" id="pc_currency_from"> <!-- Options tag are inserted from JavaScript --> </select>
            </div>
          </div>
          <div class="icon"><i class="fas fa-exchange-alt"></i></div>
          <div class="to">
            <p>To</p>
            <div class="select-box">
              <img src="https://flagcdn.com/48x36/in.png" alt="flag">
              <select name="pc_currency_to" id="pc_currency_to" class="pc_currency_country"> <!-- Options tag are inserted from JavaScript --> </select>
            </div>
          </div>
        </div>
        <div id="pc_exchange_rate">Getting exchange rate...</div>
        <button id="pc_currency_btn">Get Exchange Rate</button>
      </form>
    </div>




    <script>
    
        let country_list = {
            "AED" : "AE",
            "AFN" : "AF",
            "XCD" : "AG",
            "ALL" : "AL",
            "AMD" : "AM",
            "ANG" : "AN",
            "AOA" : "AO",
            "AQD" : "AQ",
            "ARS" : "AR",
            "AUD" : "AU",
            "AZN" : "AZ",
            "BAM" : "BA",
            "BBD" : "BB",
            "BDT" : "BD",
            "XOF" : "BE",
            "BGN" : "BG",
            "BHD" : "BH",
            "BIF" : "BI",
            "BMD" : "BM",
            "BND" : "BN",
            "BOB" : "BO",
            "BRL" : "BR",
            "BSD" : "BS",
            "NOK" : "BV",
            "BWP" : "BW",
            "BYR" : "BY",
            "BZD" : "BZ",
            "CAD" : "CA",
            "CDF" : "CD",
            "XAF" : "CF",
            "CHF" : "CH",
            "CLP" : "CL",
            "CNY" : "CN",
            "COP" : "CO",
            "CRC" : "CR",
            "CUP" : "CU",
            "CVE" : "CV",
            "CYP" : "CY",
            "CZK" : "CZ",
            "DJF" : "DJ",
            "DKK" : "DK",
            "DOP" : "DO",
            "DZD" : "DZ",
            "ECS" : "EC",
            "EEK" : "EE",
            "EGP" : "EG",
            "ETB" : "ET",
            "EUR" : "FR",
            "FJD" : "FJ",
            "FKP" : "FK",
            "GBP" : "GB",
            "GEL" : "GE",
            "GGP" : "GG",
            "GHS" : "GH",
            "GIP" : "GI",
            "GMD" : "GM",
            "GNF" : "GN",
            "GTQ" : "GT",
            "GYD" : "GY",
            "HKD" : "HK",
            "HNL" : "HN",
            "HRK" : "HR",
            "HTG" : "HT",
            "HUF" : "HU",
            "IDR" : "ID",
            "ILS" : "IL",
            "INR" : "IN",
            "IQD" : "IQ",
            "IRR" : "IR",
            "ISK" : "IS",
            "JMD" : "JM",
            "JOD" : "JO",
            "JPY" : "JP",
            "KES" : "KE",
            "KGS" : "KG",
            "KHR" : "KH",
            "KMF" : "KM",
            "KPW" : "KP",
            "KRW" : "KR",
            "KWD" : "KW",
            "KYD" : "KY",
            "KZT" : "KZ",
            "LAK" : "LA",
            "LBP" : "LB",
            "LKR" : "LK",
            "LRD" : "LR",
            "LSL" : "LS",
            "LTL" : "LT",
            "LVL" : "LV",
            "LYD" : "LY",
            "MAD" : "MA",
            "MDL" : "MD",
            "MGA" : "MG",
            "MKD" : "MK",
            "MMK" : "MM",
            "MNT" : "MN",
            "MOP" : "MO",
            "MRO" : "MR",
            "MTL" : "MT",
            "MUR" : "MU",
            "MVR" : "MV",
            "MWK" : "MW",
            "MXN" : "MX",
            "MYR" : "MY",
            "MZN" : "MZ",
            "NAD" : "NA",
            "XPF" : "NC",
            "NGN" : "NG",
            "NIO" : "NI",
            "NPR" : "NP",
            "NZD" : "NZ",
            "OMR" : "OM",
            "PAB" : "PA",
            "PEN" : "PE",
            "PGK" : "PG",
            "PHP" : "PH",
            "PKR" : "PK",
            "PLN" : "PL",
            "PYG" : "PY",
            "QAR" : "QA",
            "RON" : "RO",
            "RSD" : "RS",
            "RUB" : "RU",
            "RWF" : "RW",
            "SAR" : "SA",
            "SBD" : "SB",
            "SCR" : "SC",
            "SDG" : "SD",
            "SEK" : "SE",
            "SGD" : "SG",
            "SKK" : "SK",
            "SLL" : "SL",
            "SOS" : "SO",
            "SRD" : "SR",
            "STD" : "ST",
            "SVC" : "SV",
            "SYP" : "SY",
            "SZL" : "SZ",
            "THB" : "TH",
            "TJS" : "TJ",
            "TMT" : "TM",
            "TND" : "TN",
            "TOP" : "TO",
            "TRY" : "TR",
            "TTD" : "TT",
            "TWD" : "TW",
            "TZS" : "TZ",
            "UAH" : "UA",
            "UGX" : "UG",
            "USD" : "US",
            "UYU" : "UY",
            "UZS" : "UZ",
            "VEF" : "VE",
            "VND" : "VN",
            "VUV" : "VU",
            "YER" : "YE",
            "ZAR" : "ZA",
            "ZMK" : "ZM",
            "ZWD" : "ZW"
        }

        const dropList = document.querySelectorAll(".pc_currency_country"),
        fromCurrency = document.querySelector("#pc_currency_from"),
        toCurrency = document.querySelector("#pc_currency_to"),
        getButton = document.querySelector("#pc_currency_btn");
        for (let i = 0; i < dropList.length; i++) {
            for(let currency_code in country_list){
                // selecting USD by default as FROM currency and INR as TO currency
                let selected = i == 0 ? currency_code == "USD" ? "selected" : "" : currency_code == "INR" ? "selected" : "";
                // creating option tag with passing currency code as a text and value
                let optionTag = `<option value="${currency_code}" ${selected}>${currency_code}</option>`;
                // inserting options tag inside select tag
                dropList[i].insertAdjacentHTML("beforeend", optionTag);
            }
            dropList[i].addEventListener("change", e =>{
                loadFlag(e.target); // calling loadFlag with passing target element as an argument
            });
        }
        function loadFlag(element){
            for(let code in country_list){
                if(code == element.value){ // if currency code of country list is equal to option value
                    let imgTag = element.parentElement.querySelector("img"); // selecting img tag of particular drop list
                    // passing country code of a selected currency code in a img url
                    imgTag.src = `https://flagcdn.com/48x36/${country_list[code].toLowerCase()}.png`;
                }
            }
        }
        window.addEventListener("load", ()=>{
            getExchangeRate();
        });
        getButton.addEventListener("click", e =>{
            e.preventDefault(); //preventing form from submitting
            getExchangeRate();
        });
        const exchangeIcon = document.querySelector("form .icon");
        exchangeIcon.addEventListener("click", ()=>{
            let tempCode = fromCurrency.value; // temporary currency code of FROM drop list
            fromCurrency.value = toCurrency.value; // passing TO currency code to FROM currency code
            toCurrency.value = tempCode; // passing temporary currency code to TO currency code
            loadFlag(fromCurrency); // calling loadFlag with passing select element (fromCurrency) of FROM
            loadFlag(toCurrency); // calling loadFlag with passing select element (toCurrency) of TO
            getExchangeRate(); // calling getExchangeRate
        })
        function getExchangeRate(){
            const amount = document.querySelector("#pc_currency_amount");
            const exchangeRateTxt = document.querySelector("#pc_exchange_rate");
            let amountVal = amount.value;
            // if user dont enter any value or enter 0 then well put 1 value by default in the input field
            if(amountVal == "" || amountVal == "0"){
                amount.value = "1";
                amountVal = 1;
            }
            exchangeRateTxt.innerText = "Getting exchange rate...";
            let url = `https://v6.exchangerate-api.com/v6/API-KEY/latest/${fromCurrency.value}`;
            // fetching api response and returning it with parsing into js obj and in another then method receiving that obj
            fetch(url).then(response => response.json()).then(result =>{
                let exchangeRate = result.conversion_rates[toCurrency.value]; // getting user selected TO currency rate
                let totalExRate = (amountVal * exchangeRate).toFixed(2); // multiplying user entered value with selected TO currency rate
                exchangeRateTxt.innerText = `${amountVal} ${fromCurrency.value} = ${totalExRate} ${toCurrency.value}`;
            }).catch(() =>{ // if user is offline or any other error occured while fetching data then catch function will run
                exchangeRateTxt.innerText = "Something went wrong";
            });
        }
    
    </script>
';

}