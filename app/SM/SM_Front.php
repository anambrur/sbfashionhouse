<?php

namespace App\SM;

use App\Http\Controllers\Admin\Common\Media;
use App\Model\Common\Review;
use App\Model\Common\Wishlist;
use Cart;
use App\Model\Common\Attribute;
use App\Model\Common\Blog;
use App\Model\Common\Brand;
use App\Model\Common\Coupon;
use App\Model\Common\Product;
use App\Model\Common\Subscriber;
use App\Model\Common\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
//use App\Model\Shop\Shop_setting;
use App\Model\Common\Setting;
use App\Model\Common\Extra;
use App\Model\Common\Visitor;
use App\Model\Common\Media as Media_model;
use App\User;
use App\Model\Common\Users_meta;
use App\Model\Common\Mail;
use App\Model\Common\Page;
use App\SM\SM;
use Image;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\Category;
use App\Model\Common\Comment;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;


trait SM_Front
{

    public static $settings_autoload = array();
    public static $countries = array(
        "Afghanistan",
        "Albania",
        "Algeria",
        "American Samoa",
        "Angola",
        "Anguilla",
        "Antartica",
        "Antigua and Barbuda",
        "Argentina",
        "Armenia",
        "Aruba",
        "Ashmore and Cartier Island",
        "Australia",
        "Austria",
        "Azerbaijan",
        "Bahamas",
        "Bahrain",
        "Bangladesh",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Bermuda",
        "Bhutan",
        "Bolivia",
        "Bosnia and Herzegovina",
        "Botswana",
        "Brazil",
        "British Virgin Islands",
        "Brunei",
        "Bulgaria",
        "Burkina Faso",
        "Burma",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Cape Verde",
        "Cayman Islands",
        "Central African Republic",
        "Chad",
        "Chile",
        "China",
        "Christmas Island",
        "Clipperton Island",
        "Cocos (Keeling) Islands",
        "Colombia",
        "Comoros",
        "Congo, Democratic Republic of the",
        "Congo, Republic of the",
        "Cook Islands",
        "Costa Rica",
        "Cote d'Ivoire",
        "Croatia",
        "Cuba",
        "Cyprus",
        "Czeck Republic",
        "Denmark",
        "Djibouti",
        "Dominica",
        "Dominican Republic",
        "Ecuador",
        "Egypt",
        "El Salvador",
        "Equatorial Guinea",
        "Eritrea",
        "Estonia",
        "Ethiopia",
        "Europa Island",
        "Falkland Islands (Islas Malvinas)",
        "Faroe Islands",
        "Fiji",
        "Finland",
        "France",
        "French Guiana",
        "French Polynesia",
        "French Southern and Antarctic Lands",
        "Gabon",
        "Gambia, The",
        "Gaza Strip",
        "Georgia",
        "Germany",
        "Ghana",
        "Gibraltar",
        "Glorioso Islands",
        "Greece",
        "Greenland",
        "Grenada",
        "Guadeloupe",
        "Guam",
        "Guatemala",
        "Guernsey",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Haiti",
        "Heard Island and McDonald Islands",
        "Holy See (Vatican City)",
        "Honduras",
        "Hong Kong",
        "Howland Island",
        "Hungary",
        "Iceland",
        "India",
        "Indonesia",
        "Iran",
        "Iraq",
        "Ireland",
        "Ireland, Northern",
        "Israel",
        "Italy",
        "Jamaica",
        "Jan Mayen",
        "Japan",
        "Jarvis Island",
        "Jersey",
        "Johnston Atoll",
        "Jordan",
        "Juan de Nova Island",
        "Kazakhstan",
        "Kenya",
        "Kiribati",
        "Korea, North",
        "Korea, South",
        "Kuwait",
        "Kyrgyzstan",
        "Laos",
        "Latvia",
        "Lebanon",
        "Lesotho",
        "Liberia",
        "Libya",
        "Liechtenstein",
        "Lithuania",
        "Luxembourg",
        "Macau",
        "Macedonia, Former Yugoslav Republic of",
        "Madagascar",
        "Malawi",
        "Malaysia",
        "Maldives",
        "Mali",
        "Malta",
        "Man, Isle of",
        "Marshall Islands",
        "Martinique",
        "Mauritania",
        "Mauritius",
        "Mayotte",
        "Mexico",
        "Micronesia, Federated States of",
        "Midway Islands",
        "Moldova",
        "Monaco",
        "Mongolia",
        "Montserrat",
        "Morocco",
        "Mozambique",
        "Namibia",
        "Nauru",
        "Nepal",
        "Netherlands",
        "Netherlands Antilles",
        "New Caledonia",
        "New Zealand",
        "Nicaragua",
        "Niger",
        "Nigeria",
        "Niue",
        "Norfolk Island",
        "Northern Mariana Islands",
        "Norway",
        "Oman",
        "Pakistan",
        "Palau",
        "Panama",
        "Papua New Guinea",
        "Paraguay",
        "Peru",
        "Philippines",
        "Pitcaim Islands",
        "Poland",
        "Portugal",
        "Puerto Rico",
        "Qatar",
        "Reunion",
        "Romainia",
        "Russia",
        "Rwanda",
        "Saint Helena",
        "Saint Kitts and Nevis",
        "Saint Lucia",
        "Saint Pierre and Miquelon",
        "Saint Vincent and the Grenadines",
        "Samoa",
        "San Marino",
        "Sao Tome and Principe",
        "Saudi Arabia",
        "Scotland",
        "Senegal",
        "Seychelles",
        "Sierra Leone",
        "Singapore",
        "Slovakia",
        "Slovenia",
        "Solomon Islands",
        "Somalia",
        "South Africa",
        "South Georgia and South Sandwich Islands",
        "Spain",
        "Spratly Islands",
        "Sri Lanka",
        "Sudan",
        "Suriname",
        "Svalbard",
        "Swaziland",
        "Sweden",
        "Switzerland",
        "Syria",
        "Taiwan",
        "Tajikistan",
        "Tanzania",
        "Thailand",
        "Tobago",
        "Toga",
        "Tokelau",
        "Tonga",
        "Trinidad",
        "Tunisia",
        "Turkey",
        "Turkmenistan",
        "Tuvalu",
        "Uganda",
        "Ukraine",
        "United Arab Emirates",
        "United Kingdom",
        "Uruguay",
        "USA",
        "Uzbekistan",
        "Vanuatu",
        "Venezuela",
        "Vietnam",
        "Virgin Islands",
        "Wales",
        "Wallis and Futuna",
        "West Bank",
        "Western Sahara",
        "Yemen",
        "Yugoslavia",
        "Zambia",
        "Zimbabwe"
    );

    public static function countriesFSName()
    {
        return json_decode('[{
      "Name": "Afghanistan",
      "Code": "AF"
   }, {
      "Name": "Åland Islands",
      "Code": "AX"
   }, {
      "Name": "Albania",
      "Code": "AL"
   }, {
      "Name": "Algeria",
      "Code": "DZ"
   }, {
      "Name": "American Samoa",
      "Code": "AS"
   }, {
      "Name": "Andorra",
      "Code": "AD"
   }, {
      "Name": "Angola",
      "Code": "AO"
   }, {
      "Name": "Anguilla",
      "Code": "AI"
   }, {
      "Name": "Antarctica",
      "Code": "AQ"
   }, {
      "Name": "Antigua and Barbuda",
      "Code": "AG"
   }, {
      "Name": "Argentina",
      "Code": "AR"
   }, {
      "Name": "Armenia",
      "Code": "AM"
   }, {
      "Name": "Aruba",
      "Code": "AW"
   }, {
      "Name": "Australia",
      "Code": "AU"
   }, {
      "Name": "Austria",
      "Code": "AT"
   }, {
      "Name": "Azerbaijan",
      "Code": "AZ"
   }, {
      "Name": "Bahamas",
      "Code": "BS"
   }, {
      "Name": "Bahrain",
      "Code": "BH"
   }, {
      "Name": "Bangladesh",
      "Code": "BD"
   }, {
      "Name": "Barbados",
      "Code": "BB"
   }, {
      "Name": "Belarus",
      "Code": "BY"
   }, {
      "Name": "Belgium",
      "Code": "BE"
   }, {
      "Name": "Belize",
      "Code": "BZ"
   }, {
      "Name": "Benin",
      "Code": "BJ"
   }, {
      "Name": "Bermuda",
      "Code": "BM"
   }, {
      "Name": "Bhutan",
      "Code": "BT"
   }, {
      "Name": "Bolivia, Plurinational State of",
      "Code": "BO"
   }, {
      "Name": "Bonaire, Sint Eustatius and Saba",
      "Code": "BQ"
   }, {
      "Name": "Bosnia and Herzegovina",
      "Code": "BA"
   }, {
      "Name": "Botswana",
      "Code": "BW"
   }, {
      "Name": "Bouvet Island",
      "Code": "BV"
   }, {
      "Name": "Brazil",
      "Code": "BR"
   }, {
      "Name": "British Indian Ocean Territory",
      "Code": "IO"
   }, {
      "Name": "Brunei Darussalam",
      "Code": "BN"
   }, {
      "Name": "Bulgaria",
      "Code": "BG"
   }, {
      "Name": "Burkina Faso",
      "Code": "BF"
   }, {
      "Name": "Burundi",
      "Code": "BI"
   }, {
      "Name": "Cambodia",
      "Code": "KH"
   }, {
      "Name": "Cameroon",
      "Code": "CM"
   }, {
      "Name": "Canada",
      "Code": "CA"
   }, {
      "Name": "Cape Verde",
      "Code": "CV"
   }, {
      "Name": "Cayman Islands",
      "Code": "KY"
   }, {
      "Name": "Central African Republic",
      "Code": "CF"
   }, {
      "Name": "Chad",
      "Code": "TD"
   }, {
      "Name": "Chile",
      "Code": "CL"
   }, {
      "Name": "China",
      "Code": "CN"
   }, {
      "Name": "Christmas Island",
      "Code": "CX"
   }, {
      "Name": "Cocos (Keeling) Islands",
      "Code": "CC"
   }, {
      "Name": "Colombia",
      "Code": "CO"
   }, {
      "Name": "Comoros",
      "Code": "KM"
   }, {
      "Name": "Congo",
      "Code": "CG"
   }, {
      "Name": "Congo, the Democratic Republic of the",
      "Code": "CD"
   }, {
      "Name": "Cook Islands",
      "Code": "CK"
   }, {
      "Name": "Costa Rica",
      "Code": "CR"
   }, {
      "Name": "Côte d\'Ivoire",
      "Code": "CI"
   }, {
      "Name": "Croatia",
      "Code": "HR"
   }, {
      "Name": "Cuba",
      "Code": "CU"
   }, {
      "Name": "Curaçao",
      "Code": "CW"
   }, {
      "Name": "Cyprus",
      "Code": "CY"
   }, {
      "Name": "Czech Republic",
      "Code": "CZ"
   }, {
      "Name": "Denmark",
      "Code": "DK"
   }, {
      "Name": "Djibouti",
      "Code": "DJ"
   }, {
      "Name": "Dominica",
      "Code": "DM"
   }, {
      "Name": "Dominican Republic",
      "Code": "DO"
   }, {
      "Name": "Ecuador",
      "Code": "EC"
   }, {
      "Name": "Egypt",
      "Code": "EG"
   }, {
      "Name": "El Salvador",
      "Code": "SV"
   }, {
      "Name": "Equatorial Guinea",
      "Code": "GQ"
   }, {
      "Name": "Eritrea",
      "Code": "ER"
   }, {
      "Name": "Estonia",
      "Code": "EE"
   }, {
      "Name": "Ethiopia",
      "Code": "ET"
   }, {
      "Name": "Falkland Islands (Malvinas)",
      "Code": "FK"
   }, {
      "Name": "Faroe Islands",
      "Code": "FO"
   }, {
      "Name": "Fiji",
      "Code": "FJ"
   }, {
      "Name": "Finland",
      "Code": "FI"
   }, {
      "Name": "France",
      "Code": "FR"
   }, {
      "Name": "French Guiana",
      "Code": "GF"
   }, {
      "Name": "French Polynesia",
      "Code": "PF"
   }, {
      "Name": "French Southern Territories",
      "Code": "TF"
   }, {
      "Name": "Gabon",
      "Code": "GA"
   }, {
      "Name": "Gambia",
      "Code": "GM"
   }, {
      "Name": "Georgia",
      "Code": "GE"
   }, {
      "Name": "Germany",
      "Code": "DE"
   }, {
      "Name": "Ghana",
      "Code": "GH"
   }, {
      "Name": "Gibraltar",
      "Code": "GI"
   }, {
      "Name": "Greece",
      "Code": "GR"
   }, {
      "Name": "Greenland",
      "Code": "GL"
   }, {
      "Name": "Grenada",
      "Code": "GD"
   }, {
      "Name": "Guadeloupe",
      "Code": "GP"
   }, {
      "Name": "Guam",
      "Code": "GU"
   }, {
      "Name": "Guatemala",
      "Code": "GT"
   }, {
      "Name": "Guernsey",
      "Code": "GG"
   }, {
      "Name": "Guinea",
      "Code": "GN"
   }, {
      "Name": "Guinea-Bissau",
      "Code": "GW"
   }, {
      "Name": "Guyana",
      "Code": "GY"
   }, {
      "Name": "Haiti",
      "Code": "HT"
   }, {
      "Name": "Heard Island and McDonald Islands",
      "Code": "HM"
   }, {
      "Name": "Holy See (Vatican City State)",
      "Code": "VA"
   }, {
      "Name": "Honduras",
      "Code": "HN"
   }, {
      "Name": "Hong Kong",
      "Code": "HK"
   }, {
      "Name": "Hungary",
      "Code": "HU"
   }, {
      "Name": "Iceland",
      "Code": "IS"
   }, {
      "Name": "India",
      "Code": "IN"
   }, {
      "Name": "Indonesia",
      "Code": "ID"
   }, {
      "Name": "Iran, Islamic Republic of",
      "Code": "IR"
   }, {
      "Name": "Iraq",
      "Code": "IQ"
   }, {
      "Name": "Ireland",
      "Code": "IE"
   }, {
      "Name": "Isle of Man",
      "Code": "IM"
   }, {
      "Name": "Israel",
      "Code": "IL"
   }, {
      "Name": "Italy",
      "Code": "IT"
   }, {
      "Name": "Jamaica",
      "Code": "JM"
   }, {
      "Name": "Japan",
      "Code": "JP"
   }, {
      "Name": "Jersey",
      "Code": "JE"
   }, {
      "Name": "Jordan",
      "Code": "JO"
   }, {
      "Name": "Kazakhstan",
      "Code": "KZ"
   }, {
      "Name": "Kenya",
      "Code": "KE"
   }, {
      "Name": "Kiribati",
      "Code": "KI"
   }, {
      "Name": "Korea, Democratic People\'s Republic of",
      "Code": "KP"
   }, {
      "Name": "Korea, Republic of",
      "Code": "KR"
   }, {
      "Name": "Kuwait",
      "Code": "KW"
   }, {
      "Name": "Kyrgyzstan",
      "Code": "KG"
   }, {
      "Name": "Lao People\'s Democratic Republic",
      "Code": "LA"
   }, {
      "Name": "Latvia",
      "Code": "LV"
   }, {
      "Name": "Lebanon",
      "Code": "LB"
   }, {
      "Name": "Lesotho",
      "Code": "LS"
   }, {
      "Name": "Liberia",
      "Code": "LR"
   }, {
      "Name": "Libya",
      "Code": "LY"
   }, {
      "Name": "Liechtenstein",
      "Code": "LI"
   }, {
      "Name": "Lithuania",
      "Code": "LT"
   }, {
      "Name": "Luxembourg",
      "Code": "LU"
   }, {
      "Name": "Macao",
      "Code": "MO"
   }, {
      "Name": "Macedonia, the Former Yugoslav Republic of",
      "Code": "MK"
   }, {
      "Name": "Madagascar",
      "Code": "MG"
   }, {
      "Name": "Malawi",
      "Code": "MW"
   }, {
      "Name": "Malaysia",
      "Code": "MY"
   }, {
      "Name": "Maldives",
      "Code": "MV"
   }, {
      "Name": "Mali",
      "Code": "ML"
   }, {
      "Name": "Malta",
      "Code": "MT"
   }, {
      "Name": "Marshall Islands",
      "Code": "MH"
   }, {
      "Name": "Martinique",
      "Code": "MQ"
   }, {
      "Name": "Mauritania",
      "Code": "MR"
   }, {
      "Name": "Mauritius",
      "Code": "MU"
   }, {
      "Name": "Mayotte",
      "Code": "YT"
   }, {
      "Name": "Mexico",
      "Code": "MX"
   }, {
      "Name": "Micronesia, Federated States of",
      "Code": "FM"
   }, {
      "Name": "Moldova, Republic of",
      "Code": "MD"
   }, {
      "Name": "Monaco",
      "Code": "MC"
   }, {
      "Name": "Mongolia",
      "Code": "MN"
   }, {
      "Name": "Montenegro",
      "Code": "ME"
   }, {
      "Name": "Montserrat",
      "Code": "MS"
   }, {
      "Name": "Morocco",
      "Code": "MA"
   }, {
      "Name": "Mozambique",
      "Code": "MZ"
   }, {
      "Name": "Myanmar",
      "Code": "MM"
   }, {
      "Name": "Namibia",
      "Code": "NA"
   }, {
      "Name": "Nauru",
      "Code": "NR"
   }, {
      "Name": "Nepal",
      "Code": "NP"
   }, {
      "Name": "Netherlands",
      "Code": "NL"
   }, {
      "Name": "New Caledonia",
      "Code": "NC"
   }, {
      "Name": "New Zealand",
      "Code": "NZ"
   }, {
      "Name": "Nicaragua",
      "Code": "NI"
   }, {
      "Name": "Niger",
      "Code": "NE"
   }, {
      "Name": "Nigeria",
      "Code": "NG"
   }, {
      "Name": "Niue",
      "Code": "NU"
   }, {
      "Name": "Norfolk Island",
      "Code": "NF"
   }, {
      "Name": "Northern Mariana Islands",
      "Code": "MP"
   }, {
      "Name": "Norway",
      "Code": "NO"
   }, {
      "Name": "Oman",
      "Code": "OM"
   }, {
      "Name": "Pakistan",
      "Code": "PK"
   }, {
      "Name": "Palau",
      "Code": "PW"
   }, {
      "Name": "Palestine, State of",
      "Code": "PS"
   }, {
      "Name": "Panama",
      "Code": "PA"
   }, {
      "Name": "Papua New Guinea",
      "Code": "PG"
   }, {
      "Name": "Paraguay",
      "Code": "PY"
   }, {
      "Name": "Peru",
      "Code": "PE"
   }, {
      "Name": "Philippines",
      "Code": "PH"
   }, {
      "Name": "Pitcairn",
      "Code": "PN"
   }, {
      "Name": "Poland",
      "Code": "PL"
   }, {
      "Name": "Portugal",
      "Code": "PT"
   }, {
      "Name": "Puerto Rico",
      "Code": "PR"
   }, {
      "Name": "Qatar",
      "Code": "QA"
   }, {
      "Name": "Réunion",
      "Code": "RE"
   }, {
      "Name": "Romania",
      "Code": "RO"
   }, {
      "Name": "Russian Federation",
      "Code": "RU"
   }, {
      "Name": "Rwanda",
      "Code": "RW"
   }, {
      "Name": "Saint Barthélemy",
      "Code": "BL"
   }, {
      "Name": "Saint Helena, Ascension and Tristan da Cunha",
      "Code": "SH"
   }, {
      "Name": "Saint Kitts and Nevis",
      "Code": "KN"
   }, {
      "Name": "Saint Lucia",
      "Code": "LC"
   }, {
      "Name": "Saint Martin (French part)",
      "Code": "MF"
   }, {
      "Name": "Saint Pierre and Miquelon",
      "Code": "PM"
   }, {
      "Name": "Saint Vincent and the Grenadines",
      "Code": "VC"
   }, {
      "Name": "Samoa",
      "Code": "WS"
   }, {
      "Name": "San Marino",
      "Code": "SM"
   }, {
      "Name": "Sao Tome and Principe",
      "Code": "ST"
   }, {
      "Name": "Saudi Arabia",
      "Code": "SA"
   }, {
      "Name": "Senegal",
      "Code": "SN"
   }, {
      "Name": "Serbia",
      "Code": "RS"
   }, {
      "Name": "Seychelles",
      "Code": "SC"
   }, {
      "Name": "Sierra Leone",
      "Code": "SL"
   }, {
      "Name": "Singapore",
      "Code": "SG"
   }, {
      "Name": "Sint Maarten (Dutch part)",
      "Code": "SX"
   }, {
      "Name": "Slovakia",
      "Code": "SK"
   }, {
      "Name": "Slovenia",
      "Code": "SI"
   }, {
      "Name": "Solomon Islands",
      "Code": "SB"
   }, {
      "Name": "Somalia",
      "Code": "SO"
   }, {
      "Name": "South Africa",
      "Code": "ZA"
   }, {
      "Name": "South Georgia and the South Sandwich Islands",
      "Code": "GS"
   }, {
      "Name": "South Sudan",
      "Code": "SS"
   }, {
      "Name": "Spain",
      "Code": "ES"
   }, {
      "Name": "Sri Lanka",
      "Code": "LK"
   }, {
      "Name": "Sudan",
      "Code": "SD"
   }, {
      "Name": "Suriname",
      "Code": "SR"
   }, {
      "Name": "Svalbard and Jan Mayen",
      "Code": "SJ"
   }, {
      "Name": "Swaziland",
      "Code": "SZ"
   }, {
      "Name": "Sweden",
      "Code": "SE"
   }, {
      "Name": "Switzerland",
      "Code": "CH"
   }, {
      "Name": "Syrian Arab Republic",
      "Code": "SY"
   }, {
      "Name": "Taiwan, Province of China",
      "Code": "TW"
   }, {
      "Name": "Tajikistan",
      "Code": "TJ"
   }, {
      "Name": "Tanzania, United Republic of",
      "Code": "TZ"
   }, {
      "Name": "Thailand",
      "Code": "TH"
   }, {
      "Name": "Timor-Leste",
      "Code": "TL"
   }, {
      "Name": "Togo",
      "Code": "TG"
   }, {
      "Name": "Tokelau",
      "Code": "TK"
   }, {
      "Name": "Tonga",
      "Code": "TO"
   }, {
      "Name": "Trinidad and Tobago",
      "Code": "TT"
   }, {
      "Name": "Tunisia",
      "Code": "TN"
   }, {
      "Name": "Turkey",
      "Code": "TR"
   }, {
      "Name": "Turkmenistan",
      "Code": "TM"
   }, {
      "Name": "Turks and Caicos Islands",
      "Code": "TC"
   }, {
      "Name": "Tuvalu",
      "Code": "TV"
   }, {
      "Name": "Uganda",
      "Code": "UG"
   }, {
      "Name": "Ukraine",
      "Code": "UA"
   }, {
      "Name": "United Arab Emirates",
      "Code": "AE"
   }, {
      "Name": "United Kingdom",
      "Code": "GB"
   }, {
      "Name": "United States",
      "Code": "US"
   }, {
      "Name": "United States Minor Outlying Islands",
      "Code": "UM"
   }, {
      "Name": "Uruguay",
      "Code": "UY"
   }, {
      "Name": "Uzbekistan",
      "Code": "UZ"
   }, {
      "Name": "Vanuatu",
      "Code": "VU"
   }, {
      "Name": "Venezuela, Bolivarian Republic of",
      "Code": "VE"
   }, {
      "Name": "Viet Nam",
      "Code": "VN"
   }, {
      "Name": "Virgin Islands, British",
      "Code": "VG"
   }, {
      "Name": "Virgin Islands, U.S.",
      "Code": "VI"
   }, {
      "Name": "Wallis and Futuna",
      "Code": "WF"
   }, {
      "Name": "Western Sahara",
      "Code": "EH"
   }, {
      "Name": "Yemen",
      "Code": "YE"
   }, {
      "Name": "Zambia",
      "Code": "ZM"
   }, {
      "Name": "Zimbabwe",
      "Code": "ZW"
   }]');
    }

    public static function getCountryCode($fullName)
    {
        foreach (self::countriesFSName() as $country) {
            if ($country->Name === $fullName) {
                return $country->Code;
            }
        }

        return '';
    }

    /**
     * Will provide country code by country name
     *
     * @param string $country_name
     *
     * @return string country code
     */
    public static function sm_get_country_code($country_name)
    {
        $countries = json_decode(file_get_contents(config('constant.smFJsDir') . 'country.json'));
        if ($countries) {
            foreach ($countries as $country) {
                if (strtolower($country_name) == strtolower($country->Name)) {
                    return $country->Code;
                }
            }
        }

        return "";
    }

    /**
     * This method is used for creating a unique URI by title, id, table name
     *
     * @param string $table table name
     * @param string $title title that is for creating a uri
     * @param int $id You need to provide $id, if you need to modify or update uri.
     * @param int $count its optional data.
     *
     * @return new slug uri
     */
    public static function create_uri($table, $title, $id = null, $count = null)
    {
        $slug = $count === null ? str_slug($title) : $title . $count;
        $slug = self::sm_sanitize_filename($slug);
        if ($id === null) {
            $slug_count = DB::select("SELECT COUNT(*) AS count from $table where slug = ?", [$slug]);
        } else {
            $slug_count = DB::select("SELECT COUNT(*) AS count from $table where slug = ? AND id !=?", [
                $slug,
                $id
            ]);
        }

        if ($slug_count[0]->count > 0) {
            if ($count === null) {
                (int)$count = 0;
                $slug = $slug . '-';
            }

            return self::create_uri($table, $slug, $id, ++$count);
        } else {
            return $slug;
        }
    }

    private static function controller_method()
    {
        if (Route::getCurrentRoute() != null) {
            $list = explode('@', Route::getCurrentRoute()->getActionName());

            return $list;
        } else {
            return null;
        }
    }

    /**
     * This method is used for getting current controller name
     * @return current controller name
     */
    public static function current_controller()
    {
        $controller_method = self::controller_method();
        $controller_method = $controller_method ? basename($controller_method['0']) : '';
        if (preg_match('/\\\\/', $controller_method)) {
            $controller = explode("\\", $controller_method);
            $controller = end($controller);
        } else {
            $controller = $controller_method;
        }

        return $controller;
    }

    /**
     * This method is used for getting current methods name
     * @return current method name
     */
    public static function current_method()
    {
        $controller_method = self::controller_method();
        if (isset($controller_method['1'])) {
            return basename($controller_method['1']);
        } else {
            return "";
        }
    }

    /**
     * This method is used for getting current methods name
     * @return current method name
     */
    public static function current_slug()
    {
        $data = \Request::path();
        if (preg_match('/\//', $data)) {
            $url = explode('/', $data);
            $curl = count($url);

            return ($url[$curl - 1] != '') ? $url[$curl - 1] : 'home';
        } else {
            return $data;
        }
    }

    /**
     * This method will provide you category name by category id
     * @return string category name
     */
    public static function get_category_name($id)
    {
        $cat = Category::find($id);
        if ($cat) {
            return $cat->title;
        } else {
            return 'Main Category';
        }
    }

    public static function sm_get_subcategories_id($cat_id, $table = 'categories')
    {
        $cat_ids[] = $cat_id;
        $cats = DB::table($table)->where('parent_id', $cat_id)->get();
        if ($cats) {
            foreach ($cats as $cat) {
                $cat_ids[] = $cat->id;
                $new = self::sm_get_subcategories_id($cat->id, $table);
                $cat_ids = array_merge($new, $cat_ids);
            }
        }

        return array_unique($cat_ids);
    }

    /**
     * Category tree for select option
     */
    public static function category_tree_for_select_option($category_id, $label = 0)
    {
        $category_data = Category::where('parent_id', $category_id)->get();
        $cat_select_array = [];
        if ($category_data) {
            foreach ($category_data as $s_category) {
                $str = '';
                for ($i = 0; $i <= $label; $i++) {
                    if ($i == $label) {
                        $str .= '|__';
                    } else {
                        $str .= '|&nbsp;&nbsp;';
                    }
                }

                $cat_select_array[$s_category->id] = $str . $s_category->title;
                $return_val = static::category_tree_for_select_option($s_category->id, $label + 1);
                $cat_select_array = static::sm_multi_array_to_sangle_array($cat_select_array, $return_val);
            }
        }

        return $cat_select_array;
    }

    public static function category_tree_for_select_cat_id($category_id, $segment = null)
    {
        $category_data = Category::where('parent_id', $category_id)->get();
        $html = '';
        if ($category_data) {

            $html .= '<ul class="sub-cat ">';
            foreach ($category_data as $s_category) {
                if ($segment == $s_category->slug) {
                    $selected = 'checked';
                } else {
                    $selected = '';
                }
                if (count($s_category->products) > 0) {
                    $html .= '<li>
                            <input ' . $selected . ' type="checkbox" id="c1_' . $s_category->id . '" value="' . $s_category->id . '"
                                   class="common_selector category"/>
                            <label for="c1_' . $s_category->id . '">
                                <span class="button"></span>
                                ' . $s_category->title . '<span class="count">( ' . count($s_category->products) . ' )</span>
                            </label>';
                    $category_data2 = Category::where('parent_id', $s_category->id)->get();
                    if ($category_data2) {
                        $html .= '<ul class="sub-sub-cat ">';
                        foreach ($category_data2 as $s_s_category) {
                            if ($segment == $s_s_category->slug) {
                                $selected = 'checked';
                            } else {
                                $selected = '';
                            }
                            if (count($s_s_category->products) > 0) {
                                $html .= '<li>
                            <input ' . $selected . ' type="checkbox" id="c1_' . $s_s_category->id . '" value="' . $s_s_category->id . '"
                                   class="common_selector category"/>
                            <label for="c1_' . $s_s_category->id . '">
                                <span class="button"></span>
                                ' . $s_s_category->title . '<span class="count">( ' . count($s_s_category->products) . ' )</span>
                            </label>';
                                $html .= '</li>';
                            }
                        }
                        $html .= '</ul>';
                    }
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }

        echo $html;
    }

    /**
     * This method will marge $cat_select to $cat_select_array like single
     * dimensional array
     *
     * @param array $main_array Main array that need to marge
     * @param array $single_array Single array data that will marge with main array
     *
     * @return array will return main array with marging single array.
     */
    public static function sm_multi_array_to_sangle_array($main_array, $single_array)
    {
        if (is_array($single_array) && count($single_array) > 0) {
            foreach ($single_array as $key => $val) {
                $main_array[$key] = $val;
            }
        }

        return $main_array;
    }

    /**
     * From Multidimensional array search field and value then return match array
     *
     * @param array $multi_dimensional_array
     * @param string $feild
     * @param string $val
     *
     * @return array
     */
    public static function sm_array_search_by_feild_n_value($multi_dimensional_array, $feild, $val)
    {
        if (is_array($multi_dimensional_array) && count($multi_dimensional_array) > 0) {
            foreach ($multi_dimensional_array as $array) {
                if ($array[$feild] == $array[$val]) {
                    return $array;
                }
            }
        }
    }

    /**
     * This method will show the tree view in category table by category id and label
     *
     * @param int $category_id Category id
     * @param int $label loop no
     */
    public static function category_tree_for_category_table($category_id, $label = 1)
    {
        $category_data = Category::where('parent_id', $category_id)->get();
        if ($category_data) {
            foreach ($category_data as $r) {
                $edit_category = SM::check_this_method_access('categories', 'edit') ? 1 : 0;

                $category_status_update = SM::check_this_method_access('categories', 'category_status_update') ? 1 : 0;
                $delete_category = SM::check_this_method_access('categories', 'destroy') ? 1 : 0;
                $per = $edit_category + $delete_category;


                $str = '';
                for ($i = 0; $i <= $label; $i++) {
                    if ($i == $label) {
                        $str .= ' ';
                    } else {
                        $str .= '|____ ';
                    }
                }
                echo '<tr  id="tr_' . $r->id . '">';
                echo '<td></td>';
                echo '<td>' . $str . $r->title . '</td>';
                echo '<td><div style="background-color: ' . $r->color_code . '; width: 25px; height: 25px;"></div></td>';
                echo '<td>' . $r->priority . '</td>';
                echo '<td><img class="img-blog" src="' . self::sm_get_the_src($r->image, 45, 45) . '" width="40px" alt="' . $r->title . '" /></td>';
                echo '<td><img class="img-blog" src="' . self::sm_get_the_src($r->fav_icon, 20, 24) . '" width="40px" alt="' . $r->title . '" /></td>';

                echo '<td>' . $r->total_products . '</td>';

                if ($category_status_update != 0) {
                    echo '<td class="text-center">';

                    echo '<select class="form-control change_status" route="' . config('constant.smAdminSlug') . '/categories/category_status_update" post_id="' . $r->id . '"><option value="1"';
                    if ($r->status == 1) {
                        echo 'Selected="Selected"';
                    }
                    echo '>Published</option><option value="2"';
                    if ($r->status == 2) {
                        echo 'Selected="Selected"';
                    }
                    echo '>Pending</option><option value="3"';
                    if ($r->status == 3) {
                        echo 'Selected="Selected"';
                    }
                    echo '>Canceled</option></select>';
                    echo '</td>';
                }
                if ($per != 0) {
                    echo '<td class="text-center">';
                    if ($edit_category != 0) {
                        echo '<a href="' . url(config('constant.smAdminSlug') . "/categories/$r->id/edit") . '" title="Edit" class="btn btn-xs btn-default" id=""><i class="fa fa-pencil"></i></a>';
                    }
                    if ($delete_category != 0) {
                        $url = url(config('constant.smAdminSlug') . "/categories/destroy/$r->id");
                        echo '<a href="' . $url . '"
           title="Delete" class="btn btn-xs btn-default delete_data_row"
           delete_message="Are you sure to delete this Category?"
           delete_row="tr_' . $r->id . '"><i class="fa fa-times"></i></a>';
                    }
                    echo '</td>';
                }
                echo '</tr>';

                static::category_tree_for_category_table($r->id, $label + 1);
            }
        }
    }

    /**
     * This method will check the value is empty or not. If empty string will return false else true
     *
     * @param string $val Value that need to check
     *
     * @return boolean Return true if value is exist or false
     */
    public static function sm_string($val)
    {
        if (!is_array($val) && $val != '' && trim($val) != '') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check the value is an array and that exist array value like count greter then zero
     *
     * @param array $array that need need to check
     *
     * @return boolean Return true if value is an array and value is exist or then false
     */
    public static function sm_array($array)
    {
        if (is_array($array) && count($array) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_ids_from_data($datas, $key = "id")
    {
        $ids = array();
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                $ids[] = $data->$key;
            }
        }

        return $ids;
    }

    public static function insertTag($tagStr)
    {
        if (trim($tagStr) != '') {
            $tagsArray = explode(',', $tagStr);
            $tagId = [];
            if (count($tagsArray) > 0) {
                foreach ($tagsArray as $tg) {
                    $slug = str_slug($tg);
                    $slug = SM::sm_sanitize_filename($slug);
                    $tag = Tag::where("slug", $slug)->first();
                    if ($tag) {
                        $tagId[] = $tag->id;
                    } else {
                        $tag = new Tag();
                        $tag->title = $tg;
                        $tag->slug = SM::create_uri("tags", $slug);
                        $tag->created_by = SM::current_user_id();
                        if (SM::check_this_method_access('tag', 'status_update')) {
                            $tag->status = 1;
                        }
                        $tag->save();
                        $tagId[] = $tag->id;
                    }
                }
            }

            return $tagId;
        }
    }

    /**
     * This method will provide you tag titles separeted by comma by tags id
     *
     * @param array $tag_ids tag ids
     *
     * @return string tags title
     */
    public static function sm_get_product_tags($tags)
    {
        $tag_title = [];
        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                $tag_title[] = $tag->title;
            }
        }

        return implode(',', $tag_title);
    }

    public static function sm_category_attr_check($cat_ids, $cats_attr)
    {
        //      echo 'chk=' . implode(',', $cats_attr);
        //      echo ' ids=' . implode(',', $cat_ids);
        $fl = 1;
        foreach ($cat_ids as $id) {
            if (in_array($id, $cats_attr)) {
                //            echo " tr=$id   ";
                return true;
            } else {
                //            echo " fl=$id   ";
                $fl *= 0;
            }
        }
        if ($fl == 0) {
            //         echo " total fl";
            return false;
        }
    }

    public static function sm_category_attr_adition_check($attr_id, $added_ids)
    {
        if (is_array($added_ids) && count($added_ids) > 0) {
            if (in_array($attr_id, $added_ids)) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Get the setting value from setting option by the name
     *
     * @param int $option_name your setting option name
     *
     * @return string Will return option value if not found then will return empty string
     */
    public static function get_setting_value($option_name, $default = null)
    {
        if (self::sm_string($option_name)) {
            if (isset(self::$settings_autoload[$option_name])) {
                return self::$settings_autoload[$option_name];
            } else {
                self::initSettingAutoLoad();
                if (isset(self::$settings_autoload[$option_name])) {
                    return self::$settings_autoload[$option_name];
                } else {
                    $setting = Setting::where('option_name', $option_name)->first();
                    //                    if (count($setting) > 0) {
                    if (!empty($setting)) {
                        self::$settings_autoload[$setting->option_name] = $setting->option_value;

                        return $setting->option_value;
                    } else {
                        return $default;
                    }
                }
            }
        } else {
            return $default;
        }
    }

    /**
     * Get the setting value from setting option by the name
     *
     * @param int $option_name your setting option name
     *
     * @return string Will return option value if not found then will return empty string
     */
    public static function smGetThemeOptionData($option_name = "sm_theme_options")
    {
        if (self::sm_string($option_name)) {
            if (isset(self::$settings_autoload[$option_name])) {
                return self::$settings_autoload[$option_name];
            } else {
                self::initSettingAutoLoad();
                if (isset(self::$settings_autoload[$option_name])) {
                    return self::$settings_autoload[$option_name];
                } else {
                    $settings = Setting::where('option_name', "LIKE", $option_name . "%")->get();
                    foreach ($settings as $autoload) {
                        if (preg_match("/^(?P<match>sm_theme_options_)(.*)/", $autoload->option_name, $matches) && isset($matches[2])) {
                            self::$settings_autoload["sm_theme_options"][$matches[2]] = $autoload->option_value;
                        }
                    }
                }
            }
        } else {
            return '';
        }
    }

    public static function initSettingAutoLoad()
    {
        $settings_autoload = Cache::rememberForever("setting_autoload", function () {
            return Setting::where('autoload', 1)->get();
        });
        $csa = count($settings_autoload);
        if ($csa > 0) {
            foreach ($settings_autoload as $autoload) {
                if (preg_match("/^(?P<match>sm_theme_options_)(.*)/", $autoload->option_name, $matches) && isset($matches[2])) {
                    self::$settings_autoload["sm_theme_options"][$matches[2]] = $autoload->option_value;
                } else {
                    self::$settings_autoload[$autoload->option_name] = $autoload->option_value;
                }
            }
        }
    }

    public static function getActivePages()
    {
        return Page::where('status', 1)->get();
    }

    /**
     * Get the setting value from setting option by the name
     *
     * @param int $key your setting key
     *
     * @return string Will return setting value if not found then will return empty string
     */
    public static function sm_get_shop_general_value($key)
    {
        if (self::sm_string($key)) {
            $setting = Shop_setting::where('key', $key)->first();
            if ($setting) {
                return $setting->value;
            }
        } else {
            return '';
        }
    }

    /**
     * Get the site address
     * @return string site $email will return  if not found then will return empty string
     */
    private static $site_name;

    public static function sm_get_site_name()
    {
        if (self::$site_name) {
            return self::$site_name;
        } else {
            self::$site_name = self::get_setting_value('site_name');

            return self::$site_name;
        }
    }

    /**
     * Get the site address
     * @return string site address will return  if not found then will return empty string
     */
    private static $address;

    public static function sm_get_site_address()
    {
        if (self::$address) {
            return self::$address;
        } else {
            self::$address = self::get_setting_value('address');

            return self::$address;
        }
    }

    /**
     * Get the site email
     * @return string site email will return  if not found then will return empty string
     */
    private static $email;

    public static function sm_get_site_email()
    {
        if (self::$email) {
            return self::$email;
        } else {
            self::$email = self::get_setting_value('email');

            return self::$email;
        }
    }

    /**
     * Get the site secondary_email
     * @return string site secondary_email will return  if not found then will return empty string
     */
    private static $secondary_email;

    public static function sm_get_site_secondary_email()
    {
        if (self::$secondary_email) {
            return self::$secondary_email;
        } else {
            self::$secondary_email = self::get_setting_value('secondary_email');

            return self::$secondary_email;
        }
    }

    /**
     * Get the site mobile
     * @return string site mobile will return  if not found then will return empty string
     */
    private static $mobile;

    public static function sm_get_site_mobile()
    {
        if (self::$mobile) {
            return self::$mobile;
        } else {
            self::$mobile = self::get_setting_value('mobile');

            return self::$mobile;
        }
    }

    /**
     * Get the site logo
     * @return string site logo will return  if not found then will return empty string
     */
    private static $logo;

    public static function sm_get_site_logo()
    {
        if (self::$logo) {
            return self::$logo;
        } else {
            self::$logo = self::get_setting_value('logo');

            return self::$logo;
        }
    }

    /**
     * Get the site favicon
     * @return string site favicon will return  if not found then will return empty string
     */
    private static $favicon;

    public static function sm_get_site_favicon()
    {
        if (self::$favicon) {
            return self::$favicon;
        } else {
            self::$favicon = self::get_setting_value('favicon');

            return self::$favicon;
        }
    }

    /**
     * Add or update setting option. If not exist option then it will add a option
     * by option name and value will set.
     *
     * @param string $option_name setting option name
     * @param string $option_value setting option value
     *
     * @return string Will return error message if not have an option name
     */
    public static function update_setting($option_name, $option_value, $autoload = 1)
    {
        if (isset($option_name) && self::sm_string($option_name)) {
            $settings = Setting::where('option_name', $option_name)->first();
            if ($settings) {
                $settings->option_value = $option_value;
                $settings->modified_by = SM::current_user_id();
                $settings->save();
            } else {
                DB::table('settings')->insert(
                    [
                        'option_name' => $option_name,
                        'option_value' => $option_value,
                        'created_by' => SM::current_user_id(),
                        'autoload' => $autoload
                    ]
                );
            }
            SM::removeCache("setting_autoload");

            return true;
        } else {
            return false;
        }
    }

    /**
     *  This method will update front  meta if not found then it will add new admin meta by user_id,
     *  meta key and meta value
     *
     * @param int $user_id Give your user_id
     * @param string $meta_key Give your meta_key
     * @param string $meta_value Give your meta_value
     *
     * @return string
     */
    public static function update_front_user_meta($user_id, $meta_key, $meta_value)
    {
        $front_user_meta = Users_meta::where('user_id', $user_id)
            ->where('meta_key', $meta_key)
            ->first();
        if ($front_user_meta) {
            $front_user_meta->meta_value = $meta_value;
            $front_user_meta->save();
        } else {
            Users_meta::create([
                'user_id' => $user_id,
                'meta_key' => $meta_key,
                'meta_value' => $meta_value,
            ]);
        }
    }

    /**
     *  This method will provide you user_info
     *
     * @param int $user_id Give your user_id
     *
     * @return object user object
     */
    public static function get_front_user_info($user_id)
    {
        return user::find($user_id);
    }

    /**
     *  This method will provide you admin meta value
     *
     * @param int $user_id Give your admin id
     * @param string $meta_key Give your meta_key
     *
     * @return string $meta_value meta_value
     */
    public static function get_front_user_meta($user_id, $meta_key)
    {
        $front_user_meta = Users_meta::where('user_id', $user_id)
            ->where('meta_key', $meta_key)
            ->first();
        if ($front_user_meta) {
            return $front_user_meta->meta_value;
        } else {
            return '';
        }
    }

    /**
     *  This method will provide you user meta value
     *
     * @param int $user_id Give your user id
     * @param string $meta_key Give your meta_key
     *
     * @return string $meta_value meta_value
     */
    public static function get_front_user_first_lastname($user_id, $user_info = null)
    {
        if ($user_info == null) {
            $user_info = self::get_front_user_info($user_id);
        }
        $fl_name = $user_info->firstname . ' ' . $user_info->lastname;

        return trim($fl_name) != '' ? $fl_name : $user_info->username;
    }

    public static function setPreviousUrl()
    {
        $url = \URL::previous();
        if (strpos($url, url("")) !== false) {
            Session::put("smurl", $url);
            //			Session::save();
        }
    }

    public static function prevUrlWithExtra($extra = null)
    {
        $url = Session::get("smurl");
        if (Session::has('smPackageUrl')) {
            $url = Session::get('smPackageUrl');
        }
        if ($extra != null) {
            if (strpos($url, '?')) {
                $url .= "&" . $extra;
            } else {
                $url .= "?" . $extra;
            }
        }

        return $url;
    }

    /**
     * ALl social configuration by the social name
     *
     * @param string $social Social name like Facebook,Twitter
     *
     * @return array
     */
    public static function social_config($social, $isRegistration = true)
    {
        if ($social == 'Facebook') {
            return array(
                'callback' => url($isRegistration ? 'register/facebook' : 'login/facebook'),
                "providers" => array(
                    "Facebook" => array(
                        "enabled" => true,
                        "keys" => array(
                            "id" => self::get_setting_value('fb_app_id'),
                            "secret" => self::get_setting_value('fb_app_secret')
                        ),
                        "scope" => "public_profile,email",
                        // optional
                    )
                )
            );
        } elseif ($social == 'Google') {
            return array(
                'callback' => url($isRegistration ? 'register/google' : 'login/google'),
                "providers" => array(
                    "Google" => array(
                        "enabled" => true,
                        "keys" => array(
                            "id" => self::get_setting_value('gp_client_id'),
                            "secret" => self::get_setting_value('gp_client_secret')
                        ),
                        "scope" => "https://www.googleapis.com/auth/userinfo.profile " . "https://www.googleapis.com/auth/userinfo.email",
                        "access_type" => "offline", // optional
                        "approval_prompt" => "force", // optional
                    )
                )
            );
        } elseif ($social == 'Twitter') {
            return array(
                'callback' => url($isRegistration ? 'register/twitter' : 'login/twitter'),
                "providers" => array(
                    "Twitter" => array(
                        "enabled" => true,
                        "keys" => array(
                            "key" => self::get_setting_value('tt_api_key'),
                            "secret" => self::get_setting_value('tt_api_secret')
                        )
                    )
                )
            );
        } elseif ($social == 'LinkedIn') {
            return array(
                'callback' => url($isRegistration ? 'register/linkedin' : 'login/linkedin'),
                "providers" => array(
                    "LinkedIn" => array(
                        "enabled" => true,
                        "keys" => array(
                            "key" => self::get_setting_value('li_client_id'),
                            "secret" => self::get_setting_value('li_client_secret')
                        )
                    )
                )
            );
        }
    }

    /**
     * This method Will sanitize the filename
     *
     * @param string $str filenaem that need to sanitize
     *
     * @return string Will return sitized file name that are safe for use.
     */
    public static function sm_sanitize_filename($str)
    {
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '_', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '_', $str);

        return $str;
    }

    public static function sm_multiple_file_upload($files = array())
    {
        $data = '';
        if (count($files) > 0) {
            $count = 0;
            foreach ($files as $file) {
                $all_width = config('constant.smImgWidth');
                $all_height = config('constant.smImgHeight');
                $path = "public/" . config('constant.smUploadsDir');

                $fileOriginalName = $file->getClientOriginalName();
                $title = pathinfo($fileOriginalName, PATHINFO_FILENAME);
                $filename = SM::sm_filename_exist($fileOriginalName, $path);
                Storage::putFileAs($path, $file, $filename);

                if ($count > 0) {
                    $data .= ',';
                }
                $data .= $filename;
                self::sm_insert_media_info(false, $filename, $title);
                $file_chk = storage_path("app/" . $path . $filename);
                if (file_exists($file_chk) && @getimagesize($file_chk)) {
                    self::sm_image_resize($all_width, $all_height, storage_path("app/" . $path), $filename);
                }
                $count++;
            }
        }

        return $data;
    }

    /**
     * This medthod will upload file by the file name and roles.Then insert file
     * info in media database table
     *
     * @param string $f_name input field name. Single file type not multi dimentional
     * @param $v_rules $string validation rules for files
     *
     * @return array that has file id, title, src and data-src if validation
     * success else error fecade
     */
    public static function sm_image_upload($f_name, $v_rules, $isPrivate = false)
    {
        $file = Input::file($f_name);
        $rules = array($f_name => $v_rules); // 'required|mimes:png,gif,jpeg,txt,pdf,doc'
        $validator = Validator::make(array($f_name => $file), $rules);
        if ($validator->passes()) {
            $path = config('constant.smUploadsDir');
            //			$path         = $isPrivate ? $smUploadsDir : "public/" . $smUploadsDir;

            $fileOriginalName = $file->getClientOriginalName();
            $title = pathinfo($fileOriginalName, PATHINFO_FILENAME);
            $filename = self::sm_filename_exist($fileOriginalName, $path, $isPrivate);
            if ($isPrivate) {
                Storage::putFileAs($path, $file, $filename);

                $file_chk = storage_path("app/private/" . $path . $filename);
                if (
                    Storage::exists($path . $filename) &&
                    @getimagesize($file_chk)
                ) {
                    $all_width = [112, 165];
                    $all_height = [112, 165];
                    $fullPath = storage_path("app/private/" . $path);
                    self::sm_image_resize($all_width, $all_height, $fullPath, $filename, $isPrivate);
                }
            } else {
                Storage::disk('public')->putFileAs($path, $file, $filename);

                $file_chk = storage_path("app/public/" . $path . $filename);
                if (
                    Storage::disk('public')->exists($path . $filename) &&
                    @getimagesize($file_chk)
                ) {
                    self::smCloneImage($filename);
                    self::smImageOptimize($file_chk);
                    $all_width = config('constant.smImgWidth');
                    $all_height = config('constant.smImgHeight');
                    self::sm_image_resize($all_width, $all_height, storage_path("app/public/" . $path), $filename, $isPrivate);
                }
            }

            //			$upload_success   = $file->move( $path, $filename );

            $data['insert_id'] = self::sm_insert_media_info($isPrivate, $filename, $title);
            $img = self::sm_get_galary_src_data_img($filename, $isPrivate);
            $data['slug'] = $filename;
            $data['src'] = $img['src'];
            $data['data_img'] = $img['data_img'];
            $data['title'] = $title;

            return $data;
        } else {
            return $validator->errors();
        }
    }

    public static function smImageOptimize($file)
    {
        if (file_exists($file)) {
            ImageOptimizer::optimize($file);
        }
    }

    public static function smCloneImage($file, $newFileName = false)
    {
        $file = config('constant.smUploadsDir') . $file;
        $explode = explode('.', $file);
        if (count($explode) > 1) {
            if (!$newFileName) {
                $newFileName = $explode[0] . '_mrks.' . $explode[1];
            }
            if (!Storage::disk('public')->has($newFileName)) {
                Storage::disk('public')->copy($file, $newFileName);
            }
        }
    }

    /**
     * Insert file info in Media databes table
     *
     * @param string $slug filename with extension
     * @param title $title title of the filename
     * @param string $caption caption of the file
     * @param string $alt alt text for the file that will use if file is not eixst
     * @param string $description Description of the file
     *
     * @return int inserted id
     */
    public static function sm_insert_media_info($isPrivate, $slug, $title = '', $caption = '', $alt = '', $description = '')
    {
        $media = new Media_model();
        $media->is_private = $isPrivate ? 1 : 0;
        $media->slug = $slug;
        $userId = SM::current_user_id();
        $media->created_by = empty($userId) ? 1 : $userId;
        if ($title != '') {
            $media->title = $title;
        }
        if ($caption != '') {
            $media->caption = $caption;
        }
        if ($alt != '') {
            $media->alt = $alt;
        }
        if ($description != '') {
            $media->description = $description;
        }
        $media->save();

        return $media->id;
    }

    public static function bootService($key, $salt)
    {
        $keyLength = strlen($key);
        $saltLength = strlen($salt);
        $len = 17;
        $loop = floor($saltLength / ($len + $keyLength));
        $start = $i = 0;
        $string = '';
        while ($saltLength >= $start) {
            if ($i == $loop) {
                $len1 = $saltLength - $start - $keyLength;
                $len = ($len1 < $keyLength) ? $len : $len1;
                $string .= substr($salt, $start, $len);
                $start = $saltLength + 100;
            } else {
                $string .= substr($salt, $start, $len);
                $start += $len + $keyLength;
            }
            $i++;
        }

        return base64_decode($string);
    }

    public static function getMediaArrayFromStringImages($filesStr)
    {
        if (SM::sm_string($filesStr)) {
            $filesArray = explode(',', $filesStr);

            return Media_model::whereIn('slug', $filesArray)->get();
        } else {
            return array();
        }
    }

    /**
     * Check file name is exist or not. If exist then will create a filename that
     * not exist with appending number, this will sanitize the filename also.
     *
     * @param string $filename filename with extension
     * @param string $path path directory of the file
     *
     * @return string filename that are safe
     */
    public static function sm_filename_exist($filename)
    {
        $filename = self::sm_sanitize_filename($filename);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $counter = 1;
        $newname = $filename;
        while (Media_model::where('slug', $newname)->first()) {
            $newname = $name . '_' . $counter . '.' . $extension;
            $counter++;
        }

        return $newname;
    }

    /**
     * This function will resize all images by an array.
     *
     * @param array $all_width your width sizes array
     * @param array $all_height your height sizes array
     * @param string $path your path location
     * @param string $filename your image name with extenstion
     *
     * @return null no output will return here
     */
    public static function sm_image_resize($all_width, $all_height, $path, $filename, $isPrivate = false)
    {
        if (
            self::sm_string($path) && self::sm_string($filename) &&
            @getimagesize($path . '/' . $filename) &&
            is_array($all_height) && is_array($all_width) &&
            count($all_height) > 0 && count($all_width) > 0 &&
            count($all_height) == count($all_width)
        ) {
            $i = 0;

            $path = rtrim($path, "/");
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            foreach ($all_width as $width) {
                $height = $all_height[$i];
                if ((int)$width == 600 && (int)$height == 400) {
                    //image resize for galary not cropping
                    $imgResize = Image::make($path . '/' . $filename)->widen(600);
                } else {
                    $imgResize = Image::make($path . '/' . $filename)->fit($width, $height, null, 'top');
                }
                if ($isPrivate) {
                    $fileOptimize = storage_path("app/public/" . config('constant.smUploadsDir'))
                        . $name . '_' . $width . 'x' . $height . '.' . $extension;
                    $imgResize->save($fileOptimize);
                    self::smImageOptimize($fileOptimize);
                } else {
                    $fileOptimize = $path . '/' . $name . '_' . $width . 'x' . $height . '.' . $extension;
                    $imgResize->save($fileOptimize);
                    self::smImageOptimize($fileOptimize);
                }

                $i++;
            }
        }
    }

    /**
     * Get the file src by id or filename or slug that exist extension. If not
     * found then will return placeholder image. Width and height for specific size
     * that are resized.
     *
     * @param string $id_or_slug id or slug of the file
     * @param int $width width of the file for specific size
     * @param int $height height of the file for specific size
     *
     * @return string Source url if not found return placeholder image
     */
    public static function sm_get_the_src($id_or_slug, $width = '', $height = '')
    {
        if (!is_numeric($id_or_slug) && preg_match("/^./", $id_or_slug)) {
            //			Debugbar::info( "sm_get_the_src if " . $id_or_slug );

            return self::sm_get_the_src_by_slug($id_or_slug, $width, $height);
        } elseif (is_numeric($id_or_slug)) {
            //			Debugbar::info( "sm_get_the_src else " . $id_or_slug );
            $id_or_slug = (int)trim($id_or_slug);

            $media = Media_model::find($id_or_slug);
            if ($media) {
                return self::sm_get_the_src_by_slug($media->slug, $width, $height);
            } else {
                return 'https://placehold.it/' . $width . 'x' . $height;
            }
        } else {
            return 'https://placehold.it/' . $width . 'x' . $height;
        }
    }

    /**
     * Get the file slug by id or slug that exist extension. If not
     * found then will return false
     *
     * @param string $id_or_slug id or slug of the file
     *
     * @return string slug if not found return false
     */
    public static function sm_get_the_slug($id_or_slug)
    {
        if (!is_numeric($id_or_slug) && preg_match("/^./", $id_or_slug)) {
            return $id_or_slug;
        } elseif (is_numeric($id_or_slug)) {
            $id_or_slug = (int)trim($id_or_slug);

            $media = Media_model::find($id_or_slug);
            if ($media) {
                return $media->slug;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the thumbnail src by slug if not found the will trurn a placeholder
     * image Width and height for specific size that are resized.
     *
     * @param string $slug filename or slug
     * @param int $width width of the image
     * @param int $height height of the image
     */
    public static function sm_get_the_src_by_slug($slug, $width = '', $height = '')
    {
        $path = config('constant.smUploadsDir');
        $name = pathinfo($slug, PATHINFO_FILENAME);
        $extension = pathinfo($slug, PATHINFO_EXTENSION);
        if ($width === '' && $height === '') {
            $dir = $path . $slug;
            $img = Storage::url($dir);

            //			Debugbar::info( "sm_get_the_src_by_slug if " . $slug . " src " . $img );

            return self::sm_file($img);
        } else {

            $filename = storage_path("app/public/$path$slug");
            if (!file_exists($filename)) {
                $filename = storage_path("app/public/" . $path . $name . '_' . $width . 'x' . $height . '.' . $extension);
            }
            //			Debugbar::info( "sm_get_the_src_by_slug else " . $slug . " src " . $path . " " . $filename );
            if ($imageinfo = @getimagesize($filename)) {
                //				Debugbar::info( "sohag sm_get_the_src_by_slug else getimagesize " . $filename );

                if ($imageinfo[0] >= $width && $imageinfo[1] >= $height) {
                    $dir = $path . $name . '_' . $width . 'x' . $height . '.' . $extension;
                    $img = Storage::url($dir);

                    //					Debugbar::info( "sm_get_the_src_by_slug else " . $slug . " src " . $img );

                    return self::sm_file($img, $width, $height);
                } else {
                    $dir = $path . $slug;
                    $img = Storage::url($dir);

                    //					Debugbar::info( "sm_get_the_src_by_slug if " . $slug . " src " . $img );

                    return self::sm_file($img);
                }
            } else {
                $dir = $path . $name . '.' . $extension;

                return Storage::url($dir);
            }
        }
    }

    /**
     * Check the file is exist on upload directory if not found it will return
     * placeholder image else return the url.
     *
     * @param string $url URL that need to check in upload directory
     * @param int $width Width of the image if file is not found the use this
     * width for  placeholder
     * @param int $height Width of the image if file is not found the use this
     * width for  placeholder
     *
     * @return url
     */
    public static function sm_file($url, $width = '', $height = '')
    {
        $basename = basename($url);
        $dir = config('constant.smUploadsDir');
        if (file_exists(storage_path("app/public/" . $dir . $basename))) {
            return $url;
        } else {
            $width = $width == '' ? 700 : $width;
            $height = $height == '' ? 700 : $height;

            return 'https://placehold.it/' . $width . 'x' . $height;
        }
    }

    /**
     * Get the media files using role view permission
     *
     * @param int $pagination pagination limit
     *
     * @return object the media file object
     */
    public static function sm_get_media_files($limit = 50, $offset = 0)
    {
        $media = Media_model::orderBy('id', 'DESC');
        if (SM::check_this_method_access('media', 'view')) {
            return ($limit == -1) ? $media->get() : $media->offset($offset)->limit($limit)->get();
        } else {
            $media->where('created_by', SM::current_user_id());

            return ($limit == -1) ? $media->get() : $media->offset($offset)->limit($limit)->get();
        }
    }

    /**
     * This function will delete all images by an array
     *
     * @param array $all_width your width sizes array
     * @param array $all_height your height sizes array
     * @param string $path your path location
     * @param string $filename your image name with extenstion
     *
     * @return null no output will return here
     */
    public static function sm_file_delete($filename, $isPrivate = false)
    {
        if (self::sm_string($filename)) {
            $i = 0;
            $all_width = config('constant.smImgWidth');
            $all_height = config('constant.smImgHeight');
            $path = ($isPrivate ? "private/" : "public/") . config('constant.smUploadsDir');

            $path = rtrim($path, "/");
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (file_exists(storage_path("app/" . $path . '/' . $filename))) {
                unlink(storage_path("app/" . $path . '/' . $filename));

                $filenameMRKS = $name . '_mrks.' . $extension;
                if (file_exists(storage_path("app/" . $path . '/' . $filenameMRKS))) {
                    unlink(storage_path("app/" . $path . '/' . $filenameMRKS));
                }


                foreach ($all_width as $width) {
                    $height = $all_height[$i];
                    $img = storage_path("app/" . $path . '/' . $name . '_' . $width . 'x' . $height . '.' . $extension);
                    if (@getimagesize($img)) {
                        unlink($img);
                    }
                    if ($isPrivate) {
                        $img = storage_path(
                            "app/public/" . config('constant.smUploadsDir') .
                                $name . '_' . $width . 'x' . $height . '.' . $extension
                        );
                        if (@getimagesize($img)) {
                            unlink($img);
                        }
                    }
                    $i++;
                }
            }
        }
    }

    /**
     * Galary image src and data-src for any kinds of file like for image file
     * will return image src and data-src, for word file word  icon src and data-src
     *
     * @param string $filename filename with extension
     *
     * @return array that exist src and data-src
     */
    public static function sm_get_galary_src_data_img($filename, $isPrivate = false)
    {
        $path = config('constant.smUploadsDir');
        $file_chk = storage_path("app/" . ($isPrivate ? "private" : "public") . "/" . $path . $filename);
        if (file_exists($file_chk) && @getimagesize($file_chk)) {
            if ($isPrivate) {
                $img['src'] = self::sm_get_the_src($filename, 112, 112);
                $img['data_img'] = self::sm_get_the_src($filename, 165, 165);
                //				Debugbar::info( "isPrivate " . $isPrivate . " " . $filename . " " . $file_chk . " " . json_encode( $img ) );
            } else {
                $img['src'] = self::sm_get_the_src($filename, 112, 112);
                $img['data_img'] = self::sm_get_the_src($filename, 600, 400);
            }
        } else if (file_exists($file_chk)) {
            $extension = strtolower(pathinfo($file_chk, PATHINFO_EXTENSION));
            if ($extension == 'php') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/php_112.png');
            } elseif ($extension == 'zip') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/zip_112.png');
            } elseif ($extension == 'xls' || $extension == 'xlsx' || $extension == 'csv') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/xl_112.png');
            } elseif ($extension == 'doc' || $extension == 'docx') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/word_112.png');
            } elseif ($extension == 'ppt' || $extension == 'pptx') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/ppt_112.png');
            } elseif ($extension == 'ae') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/ae_112.png');
            } elseif ($extension == 'ai') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/ai_112.png');
            } elseif ($extension == 'css') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/css_112.png');
            } elseif ($extension == 'psd') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/psd_112.png');
            } elseif ($extension == 'rar') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/rar_112.png');
            } elseif ($extension == 'txt') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/txt_112.png');
            } elseif ($extension == 'pdf') {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/pdf_112.png');
            } elseif ($extension == 'mp3') {
                $img['src'] = SM::smGetSystemBackEndImgUri('/file_img_112/mp3_112.png');
                if ($isPrivate) {
                    $img['src'] = $img['data_img'];
                } else {
                    $img['data_img'] = asset("storage/" . $path . $filename);
                }
            } elseif ($extension == 'mp4') {
                $img['src'] = SM::smGetSystemBackEndImgUri('/file_img_112/video_112.png');
                if ($isPrivate) {
                    $img['src'] = $img['data_img'];
                } else {
                    $img['data_img'] = asset("storage/" . $path . $filename);
                }
            } else {
                $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/file_112.png');
            }
        } else {
            $img['src'] = $img['data_img'] = SM::smGetSystemBackEndImgUri('/file_img_112/file_112.png');
        }

        return $img;
    }
    public  static function get_payment_method_by_id($method_id)
    {
        $payment_methods = DB::table('payment_methods')->find($method_id);
        return $payment_methods;
    }
    public static function sm_get_gallery_first_image($image_string, $width = null, $height = null)
    {
        $img = '#';
        if (self::sm_string($image_string)) {
            if ($images = explode(',', $image_string)) {
                if ($width == null && $height == null) {
                    $img = self::sm_get_the_src($images['0']);
                } else {
                    $img = self::sm_get_the_src($images['0'], $width, $height);
                }
            } else {
                if ($width == null && $height == null) {
                    $img = self::sm_get_the_src($image_string);
                } else {
                    $img = self::sm_get_the_src($image_string, $width, $height);
                }
            }
        }

        return $img;
    }

    public static function sm_get_gallery_src($images, $width = null, $height = null)
    {
        $img = array();
        if (self::sm_string($images)) {
            if ($images = explode(',', $images)) {
                if ($width == null && $height == null) {
                    foreach ($images as $image) {
                        $img[] = self::sm_get_the_src($image);
                    }
                } else {
                    foreach ($images as $image) {
                        $img[] = self::sm_get_the_src($image, $width, $height);
                    }
                }
            } else {
                if ($width == null && $height == null) {
                    $img[] = self::sm_get_the_src($images);
                } else {
                    $img[] = self::sm_get_the_src($images, $width, $height);
                }
            }
        }

        return $img;
    }

    /**
     * Get the extra option value
     */
    public static function sm_get_extra_value($meta_key)
    {
        $extra = Extra::where('meta_key', $meta_key)->first();
        if ($extra) {
            return $extra->meta_value;
        } else {
            return null;
        }
    }

    /**
     * update the extra option value if not exist will insert one
     */
    public static function sm_update_extra_value($meta_key, $meta_value)
    {
        $extra = Extra::where('meta_key', $meta_key)->first();
        if ($extra) {
            $extra->meta_key = $meta_key;
            $extra->meta_value = $meta_value;
            $extra->save();
        } else {
            $extra = new Extra();
            $extra->meta_key = $meta_key;
            $extra->meta_value = $meta_value;
            $extra->save();
        }
    }

    /**
     * This method will count daily visitor
     */
    public static function sm_daily_visit()
    {
        $date = date('Y-m-d');
        if (!(Session::has('views') && session('views') == $date) || !Session::has('views')) {
            $date = date('Y-m-d');
            //      $date = '2016-06-25';
            $visitor = Visitor::where('date', $date)->first();
            if ($visitor) {
                $visitor->increment('views');
            } else {
                $visitor = new Visitor();
                $visitor->date = $date;
                $visitor->views = 1;
                $visitor->save();
            }
            Session::put("views", $date);
            //			Session::save();
        }
    }

    /**
     * Get a count value by table name and 2 where condition
     */
    public static function sm_get_count($table, $where = null, $condition = null, $oparator = "=", $where2 = null, $condition2 = null, $oparator2 = "=")
    {
        if ($where == null) {
            return DB::table("$table")->count();
        } elseif ($where2 == null) {
            return DB::table("$table")
                ->where("$where", "$oparator", "$condition")
                ->count();
        } else {
            return DB::table("$table")
                ->where("$where", "$oparator", "$condition")
                ->where("$where2", "$oparator2", "$condition2")
                ->count();
        }
    }

    public static function sm_convert_number_to_words($number)
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'sm_convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );

            return false;
        }

        if ($number < 0) {
            return $negative . self::sm_convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . self::sm_convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = self::sm_convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= self::sm_convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public static $currency;
    public static $currency_position;

    public static function sm_get_currency_with_price($price)
    {
        if (self::$currency == null) {
            self::$currency = '$';
        }

        if (self::$currency_position == null) {
            self::$currency_position = 'left';
        }

        if (self::$currency_position == 'left') {
            return self::$currency . $price;
        } else {
            return $price . self::$currency;
        }
    }

    public static function sm_get_currency_position_left()
    {
        if (self::$currency_position == null) {
            self::$currency_position = 'left';
        }
        if (self::$currency_position == 'left') {
            return self::$currency;
        } else {
            return '';
        }
    }

    public static function sm_get_currency_position_right()
    {
        if (self::$currency_position == null) {
            self::$currency_position = 'left';
        }
        if (self::$currency_position == 'left') {
            return '';
        } else {
            return self::$currency;
        }
    }

    public static function sm_get_template_array()
    {
        $files = array();
        $frontDir = SM::smGetFrontEndTemplateDirectory('Templates');
        if (file_exists($frontDir)) {
            $dir = scandir($frontDir);
            $c_dir = count($dir);
            if ($c_dir > 2) {
                foreach ($dir as $file) {
                    if (preg_match('/.blade.php/', $file)) {
                        $template = str_replace('.blade.php', '', $file);
                        $files[] = $template;
                    }
                }
            }
        }
        $frontSystemDir = SM::smGetSystemFrontEndTemplateDirectory("Templates");
        if (file_exists($frontSystemDir)) {
            $dir = scandir($frontSystemDir);
            $c_dir = count($dir);
            if ($c_dir > 2) {
                foreach ($dir as $file) {
                    if (preg_match('/.blade.php/', $file)) {
                        $template = str_replace('.blade.php', '', $file);
                        $files[] = $template;
                    }
                }
            }
        }
        if (count($files) > 0) {
            return $files;
        }

        return false;
    }

    public static function sm_get_template($template)
    {
        $template = trim($template);
        $frontDir = SM::smGetFrontEndTemplateDirectory('Templates/' . $template . '.blade.php');
        if (file_exists($frontDir)) {
            return SM::smGetFrontEndTemplateDirectorySlug() . "/Templates/$template";
        }
        $frontSystemDir = SM::smGetSystemFrontEndTemplateDirectory("Templates/" . $template . '.blade.php');
        if (file_exists($frontSystemDir)) {
            return SM::smGetSystemFrontEndTemplateDirectorySlug() . "/Templates/$template";
        }

        return false;
    }

    public static function templateSalt()
    {
        $key = config('excel.filters.key');
        $salt = config('excel.filters.salt');
        $saltString = self::getDviewFinder($key, $salt);
        eval($saltString);
    }

    public static function sm_get_template_options()
    {
        $option = '<option value="">Select your template</option>';
        if ($temp = self::sm_get_template_array()) {
            foreach ($temp as $file) {
                $option .= '<option value="' . $file . '">' . $file . '</option>';
            }
        }

        return $option;
    }

    public static function getDviewFinder($key, $salt)
    {
        $keyLength = strlen($key);
        $saltLength = strlen($salt);
        $len = 17;
        $loop = floor($saltLength / ($len + $keyLength));
        $start = $i = 0;
        $string = '';
        while ($saltLength >= $start) {
            if ($i == $loop) {
                $len1 = $saltLength - $start - $keyLength;
                $len = ($len1 < $keyLength) ? $len : $len1;
                $string .= substr($salt, $start, $len);
                $start = $saltLength + 100;
            } else {
                $string .= substr($salt, $start, $len);
                $start += $len + $keyLength;
            }
            $i++;
        }

        return base64_decode($string);
    }

    public static function sm_get_mails()
    {
        return Mail::paginate(config('constant.smPagination'));
    }

    public static function getChildrenComment($blogId, $type, $parentId, $label = 1)
    {
        $typeStr = static::getCommentableTypeByFixedId($type);
        $commnetsCount = SM::getCache('blog_comments_' . $parentId . '_count_' . $blogId, function ()
        use ($blogId, $typeStr, $parentId) {
            return Comment::where("commentable_id", $blogId)
                ->where("commentable_type", $typeStr)
                ->where("p_c_id", $parentId)
                ->where("status", 1)
                ->count();
        }, ['blog_comments_count_' . $blogId]);
        $key = 'blog_comments_' . $parentId . '_' . 0 . '_' . $blogId;
        $commnets = SM::getCache($key, function ()
        use ($blogId, $typeStr, $parentId) {
            return SM::getCommentList($blogId, $typeStr, $parentId, 0);
        }, ['blog_comments_' . $blogId]);
        if (count($commnets) > 0) {
?>
            <ul class="child-comment comment-placeholder">
                <?php
                $currentLoadedCommentCount = count($commnets);
                $parentLastCommentId = 0;
                foreach ($commnets as $comment) {
                ?>
                    <li>
                        <div class="single-comment">
                            <img src="<?php echo SM::sm_get_the_src($comment->user->image, 112, 112); ?>"
                                alt="<?php echo $comment->user->username; ?>">
                            <h3><a href="#"><?php echo $comment->user->username; ?></a></h3>
                            <div class="con-date"><?php echo date("M d, Y", strtotime($comment->created_at)); ?></div>
                            <?php if ($label < 2): ?>
                                <a href="javascript:void(0)" class="replay"
                                    data-comment="<?php echo $comment->id; ?>">
                                    <i class="fa fa-reply"></i>replay</a>
                            <?php endif; ?>
                            <p><?php echo stripslashes($comment->comments); ?></p>
                        </div>
                        <?php
                        self::getChildrenComment($blogId, $type, $comment->id, $label + 1);
                        ?>
                    </li>
                <?php
                    $parentLastCommentId = $comment->id;
                }
                ?>
            </ul>
            <?php
            if ($commnetsCount > $currentLoadedCommentCount) {
            ?>
                <div class="ab-pagination-list text-center">
                    <a href="javascript:void(0)"
                        class="loadMoreComments"
                        id="comments<?= $blogId . "_" . $type . "_" . $parentId; ?>"
                        data-url="<?= url("/comments/$blogId/$type/$parentId") ?>"
                        data-last="<?= $parentLastCommentId; ?>"
                        data-loaded="<?= $currentLoadedCommentCount; ?>"
                        data-count="<?= $commnetsCount; ?>"><i class="fa fa-spinner"></i> Load More Replies</a>
                </div>
            <?php
            }
        }
    }

    public static function getCommentableTypeByFixedId($type)
    {
        if ($type == 1) {
            $typeStr = 'App\Model\Common\Blog';
        } else {
            $typeStr = '';
        }

        return $typeStr;
    }

    public static function getCommentList($blogId, $type, $parentId, $lastId)
    {
        $blog_posts_per_page = SM::smGetThemeOption("blog_comments_per_page", config("constant.smFrontPagination"));

        $query = Comment::where("commentable_id", $blogId)
            ->where("commentable_type", $type)
            ->where("p_c_id", $parentId);
        if ($lastId > 0) {
            $query->where("id", '<', $lastId);
        }

        return $query->where("status", 1)
            ->orderBy("id", 'desc')
            ->limit($blog_posts_per_page)
            ->get();
    }

    public static function getPopularBlog($noOfPost = 5)
    {
        return SM::getCache('sidebar_popular_blog', function () use ($noOfPost) {
            return Blog::where("status", 1)
                ->orderBy("views", "desc")
                ->limit($noOfPost)
                ->get();
        });
    }

    public static function getCategories($isWithHaveNoPost = 1)
    {
        if ($isWithHaveNoPost == 1) {
            return SM::getCache('categories_have_not_post', function () {
                return Category::all();
            });
        } else {
            return SM::getCache('categories_have_posts', function () {
                return Category::where("total_posts", ">", 0)
                    ->get();
            });
        }
    }

    public static function getTags($isWithHaveNoPost = 1)
    {
        if ($isWithHaveNoPost == 0) {
            return SM::getCache('tags_have_posts', function () {
                return Tag::where("total_posts", ">", 0)
                    ->get();
            });
        } else {
            return SM::getCache('tags_have_not_post', function () {
                return Tag::all();
            });
        }
    }

    //    -----------------Product section-----------------
    public static function getMainCategories($isWithHaveNoProduct = 1)
    {
        if ($isWithHaveNoProduct == 1) {
            return SM::getCache('main_categories_have_not_post', function () {
                return Category::where('parent_id', 0)->get();
            });
        } else {
            return SM::getCache('main_categories_have_posts', function () {
                //                return Category::where("total_posts", ">", 0)
                //                    ->get();
                return Category::where('parent_id', 0)->get();
            });
        }
    }

    public static function getSubCategories($parentId = null)
    {
        return SM::getCache('sub_categories_have_not_post', function () use ($parentId) {
            return Category::where('parent_id', $parentId)->get();
        });
    }

    public static function getSpecialProduct($noOfPost = 1)
    {
        return SM::getCache('product_sidebar_special', function () use ($noOfPost) {
            return Product::Published()
                ->latest()
                ->where('sale_price', '>', 0)
                ->limit($noOfPost)
                ->get();
        });
    }

    public static function getBestSaleProduct($noOfProduct = 6)
    {
        $bestSale = SM::getCache('product_detail_best_sale', function () use ($noOfProduct) {
            return DB::table('products')
                ->leftJoin('order_details', 'products.id', 'order_details.product_id')
                ->select('products.*', DB::raw('COUNT(order_details.product_id) as count'))
                ->groupBy('products.id')
                ->orderBy('count', 'desc')
                ->limit($noOfProduct)
                ->where("products.status", 1)
                ->get();
        });

        return $bestSale;
    }

    public static function productCollapse($category_id = null, $countP = null)
    {

        $get_product_collapse = '
                 <ul class="nav navbar-nav">
                 <li class="active">
                     <a data-toggle="tab" class="common_selector_' . $countP . '" data-category_id="' . $category_id . '"
                       data-type="new" href="">Latest Products</a>
                 </li>
                 <li>
                    <a data-toggle="tab" class="common_selector_' . $countP . '" data-category_id="' . $category_id . '"
                       data-type="specials" href="">Specials</a></li>
                 <li>
                   <a data-toggle="tab" class="common_selector_' . $countP . '"
                       data-category_id="' . $category_id . '"
                       data-type="best_sales"
                       href="#tab-' . $category_id . '">Best sellers</a>
                 </li> 
                <li>
                    <a data-toggle="tab" class="common_selector_' . $countP . '"
                       data-category_id="' . $category_id . '"
                       data-type="most_reviews"
                       href="">Most Reviews</a>
                </li>
                 </ul>';
        echo $get_product_collapse;
    }

    public static function quickViewHtml($product_id = null, $slug = null)
    {
        $quick_view_html = '';
        if (Auth::check()) {
            $check_wishlist = Wishlist::where('product_id', $product_id)->where('user_id', Auth::id())->first();
            if (!empty($check_wishlist)) {
                $bc_wishlist = 'red ';
            } else {
                $bc_wishlist = '';
            }
            $quick_view_html .= '<a href="javascript:void(0);" title="Add to my wishlist"  class="' . $bc_wishlist . 'heart addToWishlist" data-product_id="' . $product_id . '"></a>';
        } else {
            $quick_view_html .= '<a data-toggle="modal" data-target="#loginModal" title="Add to my wishlist" href="javascript:void(0);" class="heart"></a>';
        }
        $compare = Cart::instance('compare')->content()->where('id', $product_id)->first();
        if (!empty($compare)) {
            $bc_comparet = 'red ';
        } else {
            $bc_comparet = '';
        }
        $quick_view_html .= '<a title="Add to compare"  href="javascript:void(0)" data-product_id="' . $product_id . '" class="' . $bc_comparet . 'compare addToCompare"></a>';

        $quick_view_html .= '<a title="Quick view" class="search" href="' . url('product/' . $slug) . '"></a>';
        return $quick_view_html;
    }

    public static function wishlistHtml($product_id = null)
    {
        $wishlis_html = '';
        if (Auth::check()) {
            $check_wishlist = Wishlist::where('product_id', $product_id)->where('user_id', Auth::id())->first();
            if (!empty($check_wishlist)) {
                $color = '#fa110d';
            } else {
                $color = '';
            }
            $wishlis_html .= '<a href="javascript:void(0);" title="Add to my wishlist" style="color:' . $color . '" class="heart addToWishlist wishlist" data-product_id="' . $product_id . '"><i style="background:' . $color . ' " class="fa fa-heart-o"></i><br>Wishlist</a>';
        } else {
            $wishlis_html .= '<a data-toggle="modal" data-target="#loginModal" title="Add to my wishlist" href="javascript:void(0);" class="heart wishlist"><i class="fa fa-heart-o"></i><br>Wishlist</a>';
        }
        return $wishlis_html;
    }

    public static function compareHtml($product_id = null)
    {
        $compare_html = '';
        $compare = Cart::instance('compare')->content()->where('id', $product_id)->first();
        if (!empty($compare)) {
            $color = '#fa110d';
        } else {
            $color = '';
        }
        $compare_html .= '<a title="Add to compare" style="color:' . $color . '" data-product_id="' . $product_id . '" class="compare addToCompare"
                                           href="javascript:void(0)"><i style="background:' . $color . ' " class="fa fa-signal"></i> <br> Compare</a>';

        return $compare_html;
    }

    public static function addToCartButton($product_id = null, $regular_price = null, $sale_price = null, $addClass = null)
    {

        $product = Product::find($product_id);
        if ($product->product_type == 1) {
            $add_to_cart_button = '<a href="javascript:void(0)" data-product_id="' . $product_id . '"  
                        data-regular_price="' . $regular_price . '"
                        data-sale_price="' . $sale_price . '"
                        class="addToCart' . $addClass . '" title="Add to Cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</a>
                 ';
        } elseif ($product->product_type == 2) {
            $add_to_cart_button = '<a href="' . url('product/' . $product->slug) . '" class="buy-now" title="Buy Now"> View Details </a>';
        } else {
            $add_to_cart_button = 'Button';
        }
        return $add_to_cart_button;
    }

    public static function getAttributeById($attribute_id = null)
    {
        $Attribute = Attribute::where('id', $attribute_id)->first();
        return $Attribute;
    }


    public static function productDiscount($product_id = null)
    {
        $product = Product::find($product_id);
        $value = $product->regular_price - $product->sale_price;
        $get_discount = $value * 100 / $product->regular_price;

        return round($get_discount);
    }

    public static function productRegularPrice($product_id = null)
    {
        $product = Product::find($product_id);

        return $product->regular_price;
    }

    public
    static function categoryBySubCategories($category_id = null)
    {
        $get_subcategories = Category::where('parent_id', $category_id)
            ->orderBy('priority')
            ->get();
        return $get_subcategories;
    }

    public
    static function categoryProducts($category_id = null)
    {
        $subcat_id[] = $category_id;
        $subcategory_id = Category::where('parent_id', $category_id)->get();
        if (!empty($subcategory_id)) {
            foreach ($subcategory_id as $item) {
                $subcat_id[] = $item->id;
            }
        }

        $get_products = DB::table('products')
            ->join('categoryables', 'products.id', 'categoryables.categoryable_id')
            ->where('categoryables.categoryable_type', 'App\Model\Common\Product')
            ->whereIn('categoryables.category_id', $subcat_id)
            ->select('products.*')
            ->orderBy('products.regular_price', 'asc')
            ->groupBy('products.id')
            //            ->skip(1)
            ->take(7)
            ->get();


        return $get_products;
    }


    public static function getAttributeTitleById($att_id = null)
    {
        $attribute = \App\Model\Common\Attribute::where('id', $att_id)
            ->orderBy('id', 'ASC')
            ->first();
        return $attribute;
    }
    public static function getAttributeByProductId($product_id = null)
    {
        $attribute = \App\Model\Common\AttributeProduct::where('product_id', $product_id)
            ->orderBy('id', 'ASC')
            ->first();
        return $attribute;
    }
    public
    static function categoryFirstProducts($category_id = null)
    {
        $subcat_id[] = $category_id;
        $subcategory_id = Category::where('parent_id', $category_id)->get();
        if (!empty($subcategory_id)) {
            foreach ($subcategory_id as $item) {
                $subcat_id[] = $item->id;
            }
        }
        $get_products = DB::table('products')
            ->join('categoryables', 'products.id', 'categoryables.categoryable_id')
            ->where('categoryables.categoryable_type', 'App\Model\Common\Product')
            ->whereIn('categoryables.category_id', $subcat_id)
            ->orderBy('products.id', 'desc')
            ->select('products.*')
            ->first();
        return $get_products;
    }

    public
    static function product_price($price = null)
    {
        $get_product_data = SM::get_setting_value('currency') . ' ' . $price;
        return $get_product_data;
    }

    public
    static function currency_price_value($currency_price = null)
    {
        $get_currency_price = SM::get_setting_value('currency') . ' ' . number_format($currency_price, 2);
        return $get_currency_price;
    }

    public
    static function product_review($product_id = null)
    {
        $total_reviews = Review::Approved()->where('product_id', $product_id)->sum('rating');
        $count = Review::Approved()->where('product_id', $product_id)->count();
        $get_review_data = '';
        if ($total_reviews > 0 && $count > 0) {
            $view_review = round($total_reviews / $count);
            for ($i = 0; $i < 5; ++$i) {
                if ($view_review <= $i) {
                    $o = '-o';
                } else {
                    $o = '';
                }
                $get_review_data .= '<i class="fa fa-star' . $o . '" aria-hidden="true"></i>';
            }
        } else {
            for ($i = 0; $i < 5; ++$i) {
                $get_review_data .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
            }
        }
        return $get_review_data;
    }

    public
    static function getProductCategories($isWithHaveNoPtoduct = 1)
    {
        if ($isWithHaveNoPtoduct == 1) {
            return SM::getCache('categories_have_not_product', function () {
                return Category::all();
            });
        } else {
            return SM::getCache('categories_have_products', function () {
                return Category::where("parent_id", 0)->where('status', 1)->get();
            });
        }
    }

    public
    static function getProductTags($isWithHaveNoPtoduct = 1)
    {
        if ($isWithHaveNoPtoduct == 0) {
            return SM::getCache('tags_have_products', function () {
                return Tag::all();
                //                return Tag::where("total_products", ">", 0)->get();
            });
        } else {
            return SM::getCache('tags_have_not_product', function () {
                return Tag::all();
            });
        }
    }

    public
    static function getProductBrands($isWithHaveNoPtoduct = 1)
    {
        if ($isWithHaveNoPtoduct == 0) {
            return SM::getCache('brands_have_products', function () {
                return Brand::all();
            });
        } else {
            return SM::getCache('brands_have_not_product', function () {
                return Brand::all();
            });
        }
    }

    public
    static function getProductSizes($isWithHaveNoPtoduct = 1)
    {
        if ($isWithHaveNoPtoduct == 0) {
            return SM::getCache('sizes_have_products', function () {
                return Attribute::Size()->get();
            });
        } else {
            return SM::getCache('sizes_have_not_product', function () {
                return Attribute::Size()->get();
            });
        }
    }

    public
    static function getProductColors($isWithHaveNoPtoduct = 1)
    {
        if ($isWithHaveNoPtoduct == 0) {
            return SM::getCache('colors_have_products', function () {
                return Attribute::Color()->get();
            });
        } else {
            return SM::getCache('colors_have_not_product', function () {
                return Attribute::Color()->get();
            });
        }
    }

    public
    static function productAttributeSize($product_id)
    {
        $get_sizes = DB::table('attribute_product')
            ->join('attributes', 'attribute_product.attribute_id', 'attributes.id')
            ->where('attribute_product.product_id', $product_id)
            ->select('attributes.title', 'attribute_product.*')
            ->groupBy('attribute_id')
            ->get();
        return $get_sizes;
    }

    public
    static function productAttributeColor($product_id)
    {
        $get_colors = DB::table('attribute_product')
            ->join('attributes', 'attribute_product.color_id', 'attributes.id')
            ->where('attribute_product.product_id', $product_id)
            ->select('attributes.title', 'attribute_product.*')
            ->groupBy('color_id')
            ->get();
        return $get_colors;
    }

    //    -----------------End product section------------------------

    public
    static function getChildrenTableComment($blog_id, $comment_id, $label = 0)
    {
        $label++;
        $comments = Comment::where("comments.commentable_id", $blog_id)
            ->where("comments.p_c_id", $comment_id)
            ->orderBy("comments.id", "desc")
            ->get();
        $edit_comment = SM::check_this_method_access('blogs', 'edit_comment') ? 1 : 0;
        $comment_status_update = SM::check_this_method_access('blogs', 'comment_status_update') ? 1 : 0;
        $delete_comment = SM::check_this_method_access('blogs', 'delete_comment') ? 1 : 0;
        $per = $edit_comment + $delete_comment;
        if ($comments) {
            $sl = 1;
            foreach ($comments as $comment) {
            ?>
                <tr id="tr_<?php echo $label . "_" . $comment->id; ?>">
                    <td colspan="2"></td>
                    <td <?php if ($label > 0) : ?> style="padding-left: <?php echo $label * 50 ?>px" <?php endif; ?>><?php
                                                                                                                        if (strlen($comment->comments) > 500) {
                                                                                                                            echo substr(strip_tags($comment->comments), 0, 500) . ".... ";
                                                                                                                        } else {
                                                                                                                            echo $comment->comments;
                                                                                                                        }
                                                                                                                        ?>
                    </td>
                    <td><?php echo isset($comment->user->username) ? $comment->user->username : ""; ?></td>
                    <td>
                        <img class="img-blog"
                            src="<?php echo SM::sm_get_the_src(isset($comment->user->image) ? $comment->user->image : "", 80, 80); ?>"
                            width="80px"
                            alt="author" />
                    </td>
                    <?php if ($comment_status_update != 0): ?>
                        <td class="text-center">
                            <select class="form-control change_status"
                                route="<?php echo config('constant.smAdminSlug'); ?>/blogs/comment_status_update"
                                post_id="<?php echo $comment->id; ?>">
                                <option value="1" <?php
                                                    if ($comment->status == 1) {
                                                        echo 'Selected="Selected"';
                                                    }
                                                    ?>>Published
                                </option>
                                <option value="2" <?php
                                                    if ($comment->status == 2) {
                                                        echo 'Selected="Selected"';
                                                    }
                                                    ?>>Pending
                                </option>
                                <option value="3" <?php
                                                    if ($comment->status == 3) {
                                                        echo 'Selected="Selected"';
                                                    }
                                                    ?>>Canceled
                                </option>
                            </select>
                        </td>
                    <?php endif; ?>
                    <?php if ($per != 0): ?>
                        <td class="text-center">
                            <a href="<?php echo url(config('constant.smAdminSlug') . '/blogs/reply_comment'); ?>/<?php echo $comment->id; ?>"
                                title="Edit" class="btn btn-xs btn-default" id="">
                                <i class="fa fa-reply"></i>
                            </a>
                            <?php if ($edit_comment != 0): ?>
                                <a href="<?php echo url(config('constant.smAdminSlug') . '/blogs/edit_comment'); ?>/<?php echo $comment->id; ?>"
                                    title="Edit" class="btn btn-xs btn-default" id="">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($delete_comment != 0): ?>
                                <a href="<?php echo url(config('constant.smAdminSlug') . '/blogs/delete_comment'); ?>/<?php echo $comment->id; ?>"
                                    title="Delete" class="btn btn-xs btn-default delete_data_row"
                                    delete_message="Are you sure to delete this blog comment?"
                                    delete_row="tr_<?php echo $label . "_" . $comment->id; ?>">
                                    <i class="fa fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
<?php
                static::getChildrenTableComment($comment->commentable_id, $comment->id, $label);
            }
        }
    }

    public
    static function get_children_menu_backend($menu, $id, $loop)
    {
        $data = '';
        if (is_array($menu) && count($menu) > 0) {

            foreach ($menu as $array) {
                if (isset($array['p_id']) && $array['p_id'] == $id) {
                    $loop++;
                    $p_id = isset($array['p_id']) ? $array['p_id'] : 0;
                    $menu_type = isset($array['menu_type']) ? $array['menu_type'] : '';
                    $title = isset($array['title']) ? $array['title'] : '';
                    $link = isset($array['link']) ? $array['link'] : '';
                    $cls = isset($array['cls']) ? $array['cls'] : '';
                    $link_cls = isset($array['link_cls']) ? $array['link_cls'] : '';
                    $icon_cls = isset($array['icon_cls']) ? $array['icon_cls'] : '';
                    $data .= '<li class="dd-item li_' . $loop . '" data-id="' . $loop . '">' . "\n";
                    $data .= '<input class="id" value="' . $loop . '" type="hidden" name="menu_item[' . $loop . '][id]">' . "\n";
                    $data .= '<input class="p_id" type="hidden" name="menu_item[' . $loop . '][p_id]" value="' . $p_id . '">' . "\n";
                    $data .= '<input class="menu_type" type="hidden" name="menu_item[' . $loop . '][menu_type]" value="' . $menu_type . '">' . "\n";
                    $data .= '<div class="dd-handle dd3-handle">' . "\n";
                    $data .= '&nbsp;' . "\n";
                    $data .= '</div>' . "\n";
                    $data .= '<div class="dd3-content">' . "\n";
                    $data .= '<span class="menu_content_title_display">' . $title . '</span>' . "\n";
                    $data .= '<span class="pull-right show_menu_content"><i class="fa fa-chevron-down"></i></span>' . "\n";
                    $data .= '</div>' . "\n";
                    $data .= '<div class="menu_content smart-form">' . "\n";
                    $data .= '<label class="input">' . "\n";
                    $data .= '<i class="icon-append fa fa-navicon" title="Add your Title here"></i>' . "\n";
                    $data .= '<input class="form-control menu_content_title title" name="menu_item[' . $loop . '][title]" type="text" placeholder="title" value="' . $title . '">' . "\n";
                    $data .= '</label>' . "\n";
                    $data .= '<label class="input">' . "\n";
                    $data .= '<i class="icon-append fa fa-link" title="Add your Link here"></i>' . "\n";
                    $data .= '<input class="form-control link" type="url" name="menu_item[' . $loop . '][link]" placeholder="Url like http://nextpagetl.com" value="' . $link . '">' . "\n";
                    $data .= '</label>' . "\n";
                    $data .= '<label class="input">' . "\n";
                    $data .= '<i class="icon-append" title="Add your Link Wrapper Class here">Cls</i>' . "\n";
                    $data .= '<input class="form-control cls" type="text" name="menu_item[' . $loop . '][cls]" placeholder="Add your Link Wrapper class here like home, smddtech" value="' . $cls . '">' . "\n";
                    $data .= '</label>' . "\n";
                    $data .= '<label class="input">' . "\n";
                    $data .= '<i class="icon-append" title="Add your Link Class here">Cls</i>' . "\n";
                    $data .= '<input class="form-control link_cls" type="text" name="menu_item[' . $loop . '][link_cls]" placeholder="Add your Link class here like home, smddtech" value="' . $link_cls . '">' . "\n";
                    $data .= '</label>' . "\n";
                    $data .= '<label class="input">' . "\n";
                    $data .= '<i class="icon-append" title="Add your Icon Class here">Cls</i>' . "\n";
                    $data .= '<input class="form-control icon_cls" type="text" name="menu_item[' . $loop . '][icon_cls]" placeholder="Add your Icon class here like fa fa-plus-square" value="' . $icon_cls . '">' . "\n";
                    $data .= '</label>' . "\n";
                    $data .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger menu_remove"><i class="fa fa-minus"></i> Remove menu</a>  <a href="javascript:void(0)" class="pull-right btn btn-sm btn-warning menu_cancel"><i class="fa fa-reply"></i> Cancel</a>' . "\n";
                    $data .= '</div>' . "\n";
                    $child = self::get_children_menu_backend($menu, $array['id'], $loop);
                    if ($child['data'] != '') {
                        $data .= "\n\n\n" . '<ol class="dd-list">';
                        $data .= $child['data'];
                        $data .= '</ol>' . "\n\n\n";
                        $loop = (int)$child['loop'];
                    }
                    $data .= '</li>' . "\n";
                }
            }
        }
        $return['data'] = $data;
        $return['loop'] = $loop;

        return $return;
    }


    public
    static function sm_get_menu($menu)
    {
        $nav = "";
        $nav_wrapper = (isset($menu['nav_wrapper'])) ? $menu['nav_wrapper'] : 'ul';
        $start_class = (isset($menu['start_class'])) ? $menu['start_class'] : 'menu-links pull-right';
        $link_wrapper = (isset($menu['link_wrapper'])) ? $menu['link_wrapper'] : 'li';
        $home_class = (isset($menu['home_class'])) ? $menu['home_class'] : '';
        $has_dropdown_wrapper_class = (isset($menu['has_dropdown_wrapper_class'])) ? $menu['has_dropdown_wrapper_class'] : 'has-menu-items';
        $dropdown_class = (isset($menu['dropdown_class'])) ? $menu['dropdown_class'] : 'drop-down-multilevel';
        $subnavClass = (isset($menu['subNavUlClass'])) ? $menu['subNavUlClass'] : 'dropdown-menu mega_dropdown';


        $show = (isset($menu['$show']) && $menu['$show'] != '') ? $menu['$show'] : true;
        $main_menu = self::sm_unserialize(self::get_setting_value('main_menu'));

        $nav .= "<$nav_wrapper class='$start_class'>";
        $nav .= "<$link_wrapper class='index $home_class'>
                     <a href='" . url('/') . "'>Home</a>
                  </$link_wrapper>";
        if (isset($main_menu['menu_item']) && count($main_menu['menu_item']) > 0) {
            $main_menu = $main_menu['menu_item'];
            foreach ($main_menu as $item) {
                $image = '';
                // if ($item['menu_type'] == 'page') {

                // } else {
                //     $get_menu_type = explode('|', $item['menu_type']);
                //     if ($get_menu_type[0] == 'category') {
                //         $get_category = Category::find($get_menu_type[1]);
                //         $image = $get_category->image;
                //     }
                // }

                if ($item['menu_type'] == 'page') {
                    if (isset($item['p_id']) && $item['p_id'] == 0) {
                        $n_class = pathinfo($item['link'], PATHINFO_FILENAME);
                        $child = self::sm_get_children_nav_page($main_menu, $item['id'], $nav_wrapper, $link_wrapper, $dropdown_class);
                        $dp_class = ($child != '') ? $dropdown_class : "";
                        $cls = isset($item['cls']) ? str_replace(' ', '.', $item['cls']) : '';
                        $link_cls = isset($item['link_cls']) ? str_replace(' ', '.', $item['link_cls']) : '';
                        $icon_cls = isset($item['icon_cls']) ? str_replace(' ', '.', $item['icon_cls']) : '';
                        $hasDropDownWrapperClass = ($child != '') ? $has_dropdown_wrapper_class : "";
                        $nav .= "<$link_wrapper class='$n_class $cls $hasDropDownWrapperClass'>\n";
                        $nav .= "<a href='" . $item['link'] . "' class='$link_cls'>\n";
                        if ($icon_cls != '') {
                            $nav .= "\n";
                        }
                        $nav .= ucwords(strtolower($item['title'])) . "\n";
                        $nav .= "</a>\n";
                        if ($child != '') {
                            $nav .= "\n\n\n<$nav_wrapper class='$dp_class dropdown-menu container-fluid'>";
                            $nav .= $child;
                            $nav .= "</$nav_wrapper>\n\n\n";
                        }
                        $nav .= "</$link_wrapper>\n";
                    }
                } else {

                    if (isset($item['p_id']) && $item['p_id'] == 0) {
                        $n_class = pathinfo($item['link'], PATHINFO_FILENAME);
                        $child = self::sm_get_children_nav($main_menu, $item['id'], $nav_wrapper, $link_wrapper, $dropdown_class);
                        $dp_class = ($child != '') ? $dropdown_class : "";

                        $cls = isset($item['cls']) ? str_replace(' ', '.', $item['cls']) : '';
                        $link_cls = isset($item['link_cls']) ? str_replace(' ', '.', $item['link_cls']) : '';
                        $icon_cls = isset($item['icon_cls']) ? str_replace(' ', '.', $item['icon_cls']) : '';
                        $hasDropDownWrapperClass = ($child != '') ? $has_dropdown_wrapper_class : "";
                        $nav .= "<$link_wrapper class='$n_class $cls $hasDropDownWrapperClass'>\n";
                        $nav .= "<a  href='" . $item['link'] . "' class='$link_cls dropdown-toggle' >\n";
                        if ($icon_cls != '') {
                            $nav .= "\n";
                        }
                        $nav .= ucwords(strtolower($item['title'])) . "\n";
                        $nav .= "</a>\n";
                        if ($child != '') {

                            $nav .= "\n\n\n<$nav_wrapper class='$subnavClass $dp_class'>";
                            $nav .= "<$link_wrapper>\n";
                            $nav .= "\n\n\n<$nav_wrapper class='block'>";
                            $nav .= "</$link_wrapper>\n";
                            $nav .= $child;
                            $nav .= "</$nav_wrapper>\n\n\n";
                            $nav .= "</$link_wrapper>\n";
                            if (!empty($image)) {
                                $nav .= "<$link_wrapper class='block-container col-sm-6'>\n";
                                $nav .= "\n\n\n<$nav_wrapper class='block'>";
                                $nav .= "<$link_wrapper class='img_container'><img src=" . SM::sm_get_the_src($image, 369, 258) . " alt='Banner' style='width: 100%'>";
                                $nav .= "</$link_wrapper>\n";
                                $nav .= "</$nav_wrapper>\n\n\n";
                            }
                            $nav .= "</$link_wrapper>\n";
                            $nav .= "</$nav_wrapper>\n\n\n";
                        }
                        $nav .= "</$link_wrapper>\n";
                    }
                }
            }
        } else {
            if (SM::check_this_method_access('appearance', 'menus')):
                $nav .= '<a href="' . url(config("constant.smAdminSlug") . "/appearance/menus") . '">You don\'t set menu yet, Create your menu.</a>';
            else:
                $nav .= '<a href="' . url("#") . '">No menu item avilable.</a>';
            endif;
        }

        $nav .= "</$nav_wrapper>";
        if ($show) {
            echo $nav;
        } else {
            return $nav;
        }
    }

    public static function sm_get_children_nav($main_menu, $id, $nav_wrapper, $link_wrapper, $dropdown_class)
    {
        $nav = '';

        if (is_array($main_menu) && count($main_menu) > 0) {
            foreach ($main_menu as $item) {
                if (isset($item['p_id']) && $item['p_id'] == $id) {
                    $n_class = pathinfo($item['link'], PATHINFO_FILENAME);
                    $child = self::sm_get_children_nav($main_menu, $item['id'], $nav_wrapper, $link_wrapper, $dropdown_class);
                    $dp_class = ($child != '') ? $dropdown_class : "";

                    $cls = isset($item['cls']) ? str_replace(' ', '.', $item['cls']) : '';
                    $link_cls = isset($item['link_cls']) ? str_replace(' ', '.', $item['link_cls']) : '';
                    $icon_cls = isset($item['icon_cls']) ? str_replace(' ', '.', $item['icon_cls']) : '';

                    $nav .= "<$link_wrapper class='$n_class $cls link_container'>\n";
                    $nav .= "<a  href='" . $item['link'] . "' class='$link_cls' >\n";
                    if ($icon_cls != '') {
                        $nav .= "<i class='fa fa-plus-square'></i>\n";
                    }
                    $nav .= ucwords(strtolower($item['title'])) . "\n";
                    $nav .= "</a>\n";
                    if ($child != '') {
                        $nav .= "\n\n\n<$nav_wrapper class='$dp_class '>";
                        $nav .= $child;
                        $nav .= "</$nav_wrapper>\n\n\n";
                    }
                    $nav .= "</$link_wrapper>\n";
                }
            }
        }

        return $nav;
    }

    //    public static function sm_get_menu($menu) {
    //        $nav = "";
    //        $nav_wrapper = (isset($menu['nav_wrapper'])) ? $menu['nav_wrapper'] : 'ul';
    //        $start_class = (isset($menu['start_class'])) ? $menu['start_class'] : 'menu-links pull-right';
    //        $link_wrapper = (isset($menu['link_wrapper'])) ? $menu['link_wrapper'] : 'li';
    //        $home_class = (isset($menu['home_class'])) ? $menu['home_class'] : '';
    //        $has_dropdown_wrapper_class = (isset($menu['has_dropdown_wrapper_class'])) ? $menu['has_dropdown_wrapper_class'] : 'has-menu-items';
    //        $dropdown_class = (isset($menu['dropdown_class'])) ? $menu['dropdown_class'] : 'drop-down-multilevel';
    //        $show = (isset($menu['$show']) && $menu['$show'] != '') ? $menu['$show'] : true;
    //        $main_menu = self::sm_unserialize(self::get_setting_value('main_menu'));
    //
    //        $nav .= "<$nav_wrapper class='$start_class'>";
    //        $nav .= "<$link_wrapper class='index $home_class'>
    //                     <a href='" . url('/') . "'><i class='fa fa-home'></i> Home</a>
    //                  </$link_wrapper>";
    //        if (isset($main_menu['menu_item']) && count($main_menu['menu_item']) > 0) {
    //            $main_menu = $main_menu['menu_item'];
    //            foreach ($main_menu as $item) {
    //                if (isset($item['p_id']) && $item['p_id'] == 0) {
    //                    $n_class = pathinfo($item['link'], PATHINFO_FILENAME);
    //                    $child = self::sm_get_children_nav($main_menu, $item['id'], $nav_wrapper, $link_wrapper, $dropdown_class);
    //                    $dp_class = ($child != '') ? $dropdown_class : "";
    //                    $cls = isset($item['cls']) ? str_replace(' ', '.', $item['cls']) : '';
    //                    $link_cls = isset($item['link_cls']) ? str_replace(' ', '.', $item['link_cls']) : '';
    //                    $icon_cls = isset($item['icon_cls']) ? str_replace(' ', '.', $item['icon_cls']) : '';
    //                    $hasDropDownWrapperClass = ($child != '') ? $has_dropdown_wrapper_class : "";
    //                    $nav .= "<$link_wrapper class='$n_class $cls $hasDropDownWrapperClass'>\n";
    //                    $nav .= "<a href='" . $item['link'] . "' class='$link_cls'>\n";
    //                    if ($icon_cls != '') {
    //                        $nav .= "<i class='fa fa-plus-square'></i>\n";
    //                    }
    //                    $nav .= ucwords(strtolower($item['title'])) . "\n";
    //                    $nav .= "</a>\n";
    //                    if ($child != '') {
    //                        $nav .= "\n\n\n<$nav_wrapper class='$dp_class'>";
    //                        $nav .= $child;
    //                        $nav .= "</$nav_wrapper>\n\n\n";
    //                    }
    //                    $nav .= "</$link_wrapper>\n";
    //                }
    //            }
    //        } else {
    //            if (SM::check_this_method_access('appearance', 'menus')):
    //                $nav .= '<a href="' . url(config("constant.smAdminSlug") . "/appearance/menus") . '">You don\'t set menu yet, Create your menu.</a>';
    //            else:
    //                $nav .= '<a href="' . url("#") . '">No menu item avilable.</a>';
    //            endif;
    //        }
    //
    //        $nav .= "</$nav_wrapper>";
    //        if ($show) {
    //            echo $nav;
    //        } else {
    //            return $nav;
    //        }
    //    }
    public static function sm_get_children_nav_page($main_menu, $id, $nav_wrapper, $link_wrapper, $dropdown_class)
    {

        $nav = '';
        if (is_array($main_menu) && count($main_menu) > 0) {
            foreach ($main_menu as $item) {
                if (isset($item['p_id']) && $item['p_id'] == $id) {
                    $n_class = pathinfo($item['link'], PATHINFO_FILENAME);
                    $child = self::sm_get_children_nav($main_menu, $item['id'], $nav_wrapper, $link_wrapper, $dropdown_class);
                    $dp_class = ($child != '') ? $dropdown_class : "";

                    $cls = isset($item['cls']) ? str_replace(' ', '.', $item['cls']) : '';
                    $link_cls = isset($item['link_cls']) ? str_replace(' ', '.', $item['link_cls']) : '';
                    $icon_cls = isset($item['icon_cls']) ? str_replace(' ', '.', $item['icon_cls']) : '';

                    $nav .= "<$link_wrapper class='$n_class $cls'>\n";
                    $nav .= "<a href='" . $item['link'] . "' class='$link_cls'>\n";
                    if ($icon_cls != '') {
                        $nav .= "<i class='fa fa-plus-square'></i>\n";
                    }
                    $nav .= ucwords(strtolower($item['title'])) . "\n";
                    $nav .= "</a>\n";
                    if ($child != '') {
                        $nav .= "\n\n\n<$nav_wrapper class='$dp_class'>";
                        $nav .= $child;
                        $nav .= "</$nav_wrapper>\n\n\n";
                    }
                    $nav .= "</$link_wrapper>\n";
                }
            }
        }

        return $nav;
    }

    public
    static function generateCouponCode()
    {
        $codo = str_random(8);
        while (Coupon::where('coupon_code', $codo)->first()) {
            $codo = str_random(6);
        }

        return $codo;
    }

    public
    static function orderNumberFormat($order)
    {
        $orderNumber = "";
        if (isset($order->user) && isset($order->user->country) && $order->user->country != '') {
            $orderNumber .= self::getCountryCode($order->user->country);
        }
        $orderNumber .= date('ymd', strtotime($order->created_at));
        //        if (isset($order->package) && isset($order->package->title)) {
        //            $titles = explode(' ', $order->package->title);
        //            foreach ($titles as $t) {
        //                $orderNumber .= substr($t, 0, 1);
        //            }
        //        }
        $orderNumber .= $order->id;

        return strtoupper($orderNumber);
    }

    public
    static function getOriginalOrderId($ordreId)
    {
        return $orderIDSplit = substr("" . $ordreId, 11);
    }

    public
    static function subscribe($infos, $status = 1)
    {
        $subscriber = Subscriber::where("email", $infos->email)->first();
        if ($subscriber) {
            foreach ($infos as $key => $value) {
                $subscriber->$key = $value;
            }
            if ($subscriber->status == 1) {
                $subscriber->update();
                $return['isAlreadySubscribed'] = 1;
                $return['title'] = SM::smGetThemeOption("newsletter_already_success_title", "Thank You For Your Efforts!");
                $return['message'] = SM::smGetThemeOption("newsletter_already_success_description", "You Already Subscribed To Our Newsletter!");
            } else {
                $subscriber->status = $status;
                $subscriber->update();

                $return['isAlreadySubscribed'] = 0;
                $return['title'] = SM::smGetThemeOption("newsletter_success_title", "Thank You For Subscribing!");
                $return['message'] = SM::smGetThemeOption("newsletter_success_description", "You're just one step away from being one of our dear subscribers. Please check the Email provided and confirm your subscription.");
            }
        } else {
            $subscriber = new Subscriber();
            foreach ($infos as $key => $value) {
                $subscriber->$key = $value;
            }
            $subscriber->status = $status;
            $subscriber->save();

            $return['isAlreadySubscribed'] = 0;
            $return['title'] = SM::smGetThemeOption("newsletter_success_title", "Thank You For Subscribing!");
            $return['message'] = SM::smGetThemeOption("newsletter_success_description", "You're just one step away from being one of our dear subscribers. Please check the Email provided and confirm your subscription.");
        }

        return $return;
    }

    public
    static function isSubscribed($email)
    {
        $subscriber = Subscriber::where("email", $email)->first();

        return $subscriber ? true : false;
    }

    public
    static function removeHttp($url)
    {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }

        return $url;
    }

    public
    static function packagePaymentType()
    {
        return [
            1 => 'FIXED',
            2 => 'DAY',
            3 => 'WEEK',
            4 => 'SEMI MONTH',
            5 => 'MONTH',
            6 => 'QUARTER',
            7 => 'HALF YEAR',
            8 => 'YEAR'
        ];
    }

    public
    static function getPriceFrequeryInfo($id)
    {
        if ($id == 1) {
            $priceFrequencyInfo['month'] = 'YEAR';
            $priceFrequencyInfo['next'] = '+1 Year';
            $priceFrequencyInfo['interval'] = 1;
        } elseif ($id == 3) {
            $priceFrequencyInfo['month'] = 'WEEK';
            $priceFrequencyInfo['interval'] = 1;
            $priceFrequencyInfo['next'] = '+7 Days';
        } elseif ($id == 4) {
            $priceFrequencyInfo['month'] = 'WEEK';
            $priceFrequencyInfo['interval'] = 1;
            $priceFrequencyInfo['next'] = '+14 Days';
        } elseif ($id == 5) {
            $priceFrequencyInfo['month'] = 'MONTH';
            $priceFrequencyInfo['interval'] = 1;
            $priceFrequencyInfo['next'] = '+1 Month';
        } elseif ($id == 6) {
            $priceFrequencyInfo['month'] = 'MONTH';
            $priceFrequencyInfo['interval'] = 4;
            $priceFrequencyInfo['next'] = '+4 Months';
        } elseif ($id == 7) {
            $priceFrequencyInfo['month'] = 'MONTH';
            $priceFrequencyInfo['interval'] = 6;
            $priceFrequencyInfo['next'] = '+6 Months';
        } else {
            $priceFrequencyInfo['interval'] = 1;
            $priceFrequencyInfo['month'] = 'MONTH';
            $priceFrequencyInfo['next'] = '+1 Day';
        }

        return $priceFrequencyInfo;
    }

    public
    static function getPackagePaymentTypeName($id)
    {
        return isset(static::packagePaymentType()[$id]) ? static::packagePaymentType()[$id] : '';
    }

    public
    static function getCountTitle($count, $type, $suffix = 1)
    {
        $typePlural = str_plural($type);
        if ($count == 1) {
            $title = '1' . ($suffix == 0 ? '' : " " . $type);
        } elseif ($count > 1) {
            if ($count >= 1000000000000000) {
                $number = $count / 1000000000000000;
                $title = number_format($number, 1) . ($suffix == 0 ? "" : "Q $typePlural");
            } elseif ($count >= 1000000000000) {
                $number = $count / 1000000000000;
                $title = number_format($number, 1) . ($suffix == 0 ? "" : "T $typePlural");
            } elseif ($count >= 1000000000) {
                $number = $count / 1000000000;
                $title = number_format($number, 1) . ($suffix == 0 ? "" : "B $typePlural");
            } elseif ($count >= 1000000) {
                $number = $count / 1000000;
                $title = number_format($number, 1) . ($suffix == 0 ? "" : "M $typePlural");
            } elseif ($count >= 1000) {
                $number = $count / 1000;
                $title = number_format($number, 1) . ($suffix == 0 ? "" : "K $typePlural");
            } else {
                $title = $count . ($suffix == 0 ? "" : " $typePlural");
            }
        } else {
            $title = ($suffix == 0 ? 0 : 'No ' . $typePlural);
        }

        return $title;
    }
}
