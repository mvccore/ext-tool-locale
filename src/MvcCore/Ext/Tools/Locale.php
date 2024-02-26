<?php

/**
 * MvcCore
 *
 * This source file is subject to the BSD 3 License
 * For the full copyright and license information, please view
 * the LICENSE.md file that are distributed with this source code.
 *
 * @copyright	Copyright (c) 2016 Tom Flidr (https://github.com/mvccore)
 * @license		https://mvccore.github.io/docs/mvccore/5.0.0/LICENSE.md
 */

namespace MvcCore\Ext\Tools;

/**
 * Responsibility - properly set and get system locale settings by PHP ` setlocale();` across any system platform.
 * - Set system locale settings by given category, lang code, territory code, encoding (and euro sign).
 * - Get system locale settings by given category parsed into `\stdClass` object with all info above.
 * @see http://php.net/manual/en/function.setlocale.php
 * @see https://msdn.microsoft.com/en-us/library/x99tb11d.aspx
 * @see https://msdn.microsoft.com/en-us/library/cc233982.aspx
 * @see https://docs.moodle.org/dev/Table_of_locales
 * @see https://stackoverflow.com/questions/3191664/list-of-all-locales-and-their-short-codes
 */
class Locale {

	/**
	 * MvcCore - version:
	 * Comparison by PHP function `version_compare();`.
	 * @see http://php.net/manual/en/function.version-compare.php
	 */
	const VERSION = '5.2.0';

	/**
	 * All possible language codes and names supported on windows platforms.
	 * @var string[]
	 */
	protected static $langs = [
		'aa'	=> 'Afar',
		'af'	=> 'Afrikaans',
		'agq'	=> 'Aghem',
		'ak'	=> 'Akan',
		'am'	=> 'Amharic',
		'ar'	=> 'Arabic',
		'arn'	=> 'Mapudungun',
		'as'	=> 'Assamese',
		'asa'	=> 'Asu',
		'ast'	=> 'Asturian',
		'ba'	=> 'Bashkir',
		'bas'	=> 'Basaa',
		'be'	=> 'Belarusian',
		'bem'	=> 'Bemba',
		'bez'	=> 'Bena',
		'bg'	=> 'Bulgarian',
		'bn'	=> 'Bangla',
		'bo'	=> 'Tibetan',
		'br'	=> 'Breton',
		'brx'	=> 'Bodo',
		'byn'	=> 'Blin',
		'ca'	=> 'Catalan',
		'cd'	=> 'Chechen',
		'cgg'	=> 'Chiga',
		'co'	=> 'Corsican',
		'cs'	=> 'Czech',
		'cu'	=> 'Church Slavic',
		'cy'	=> 'Welsh',
		'da'	=> 'Danish',
		'dav'	=> 'Taita',
		'de'	=> 'German',
		'dje'	=> 'Zarma',
		'dsb'	=> 'Lower Sorbian',
		'dua'	=> 'Duala',
		'dv'	=> 'Divehi',
		'dyo'	=> 'Jola-Fonyi',
		'dz'	=> 'Dzongkha',
		'ebu'	=> 'Embu',
		'ee'	=> 'Ewe',
		'el'	=> 'Greek',
		'en'	=> 'English',
		'eo'	=> 'Esperanto',
		'es'	=> 'Spanish',
		'et'	=> 'Estonian',
		'eu'	=> 'Basque',
		'ewo'	=> 'Ewondo',
		'fa'	=> 'Persian',
		'ff'	=> 'Fulah',
		'fi'	=> 'Finnish',
		'fil'	=> 'Filipino',
		'fo'	=> 'Faroese',
		'fr'	=> 'French',
		'fur'	=> 'Friulian',
		'fy'	=> 'Frisian',
		'ga'	=> 'Irish',
		'gd'	=> 'Scottish Gaelic',
		'gl'	=> 'Galician',
		'gn'	=> 'Guarani',
		'gsw'	=> 'Alsatian',
		'gu'	=> 'Gujarati',
		'guz'	=> 'Gusii',
		'gv'	=> 'Manx',
		'haw'	=> 'Hawaiian',
		'he'	=> 'Hebrew',
		'hi'	=> 'Hindi',
		'hr'	=> 'Croatian',
		'hsb'	=> 'Upper Sorbian',
		'hu'	=> 'Hungarian',
		'hy'	=> 'Armenian',
		'ia'	=> 'Interlingua',
		'id'	=> 'Indonesian',
		'ig'	=> 'Igbo',
		'ii'	=> 'Yi',
		'is'	=> 'Icelandic',
		'it'	=> 'Italian',
		'ja'	=> 'Japanese',
		'jgo'	=> 'Ngomba',
		'jmc'	=> 'Machame',
		'ka'	=> 'Georgian',
		'kab'	=> 'Kabyle',
		'kam'	=> 'Kamba',
		'kde'	=> 'Makonde',
		'kea'	=> 'Kabuverdianu',
		'khq'	=> 'Koyra Chiini',
		'ki'	=> 'Kikuyu',
		'kk'	=> 'Kazakh',
		'kkj'	=> 'Kako',
		'kl'	=> 'Greenlandic',
		'kln'	=> 'Kalenjin',
		'km'	=> 'Khmer',
		'kn'	=> 'Kannada',
		'ko'	=> 'Korean',
		'kok'	=> 'Konkani',
		'ksb'	=> 'Shambala',
		'ksf'	=> 'Bafia',
		'ksh'	=> 'Ripuarian',
		'ku'	=> 'Central Kurdish',
		'kw'	=> 'Cornish',
		'ky'	=> 'Kyrgyz',
		'lag'	=> 'Langi',
		'lb'	=> 'Luxembourgish',
		'lg'	=> 'Ganda',
		'lkt'	=> 'Lakota',
		'ln'	=> 'Lingala',
		'lo'	=> 'Lao',
		'lrc'	=> 'Northern Luri',
		'lt'	=> 'Lithuanian',
		'lu'	=> 'Luba-Katanga',
		'luo'	=> 'Luo',
		'luy'	=> 'Luyia',
		'lv'	=> 'Latvian',
		'mas'	=> 'Masai',
		'mer'	=> 'Meru',
		'mfe'	=> 'Morisyen',
		'mg'	=> 'Malagasy',
		'mgh'	=> 'Makhuwa-Meetto',
		'mgo'	=> 'Meta\'',
		'mi'	=> 'Maori',
		'ml'	=> 'Malayalam',
		'moh'	=> 'Mohawk',
		'mr'	=> 'Marathi',
		'ms'	=> 'Malay',
		'mt'	=> 'Maltese',
		'mua'	=> 'Mundang',
		'my'	=> 'Burmese',
		'mzn'	=> 'Mazanderani',
		'naq'	=> 'Nama',
		'nb'	=> 'Norwegian Bokmål',
		'nd'	=> 'North Ndebele',
		'nds'	=> 'Low German',
		'ne'	=> 'Nepali',
		'nl'	=> 'Dutch',
		'nmg'	=> 'Kwasio',
		'nn'	=> 'Norwegian (Nynorsk)',
		'nnh'	=> 'Ngiemboon',
		'no'	=> 'Norwegian (Bokmal)',
		'nqo'	=> 'N\'ko',
		'nr'	=> 'South Ndebele',
		'nso'	=> 'Sesotho sa Leboa',
		'nus'	=> 'Nuer',
		'nyn'	=> 'Nyankole',
		'oc'	=> 'Occitan',
		'om'	=> 'Oromo',
		'or'	=> 'Odia',
		'pa'	=> 'Punjabi',
		'pl'	=> 'Polish',
		'prg'	=> 'Prussian',
		'prs'	=> 'Dari',
		'ps'	=> 'Pashto',
		'pt'	=> 'Portuguese',
		'qut'	=> 'K\'iche',
		'quz'	=> 'Quechua',
		'rm'	=> 'Romansh',
		'rn'	=> 'Rundi',
		'ro'	=> 'Romanian',
		'rof'	=> 'Rombo',
		'ru'	=> 'Russian',
		'rw'	=> 'Kinyarwanda',
		'rwk'	=> 'Rwa',
		'sa'	=> 'Sanskrit',
		'sah'	=> 'Sakha',
		'saq'	=> 'Samburu',
		'sbp'	=> 'Sangu',
		'se'	=> 'Sami (Northern)',
		'seh'	=> 'Sena',
		'ses'	=> 'Koyraboro Senni',
		'sg'	=> 'Sango',
		'si'	=> 'Sinhala',
		'sk'	=> 'Slovak',
		'sl'	=> 'Slovenian',
		'sma'	=> 'Sami (Southern)',
		'smj'	=> 'Sami (Lule)',
		'smn'	=> 'Sami (Inari)',
		'sms'	=> 'Sami (Skolt)',
		'so'	=> 'Somali',
		'sq'	=> 'Albanian',
		'ss'	=> 'Swati',
		'ssy'	=> 'Saho',
		'st'	=> 'Southern Sotho',
		'sv'	=> 'Swedish',
		'sw'	=> 'Kiswahili',
		'swc'	=> 'Congo Swahili',
		'syr'	=> 'Syriac',
		'ta'	=> 'Tamil',
		'te'	=> 'Telugu',
		'teo'	=> 'Teso',
		'th'	=> 'Thai',
		'ti'	=> 'Tigrinya',
		'tig'	=> 'Tigre',
		'tk'	=> 'Turkmen',
		'tn'	=> 'Setswana',
		'to'	=> 'Tongan',
		'tr'	=> 'Turkish',
		'ts'	=> 'Tsonga',
		'tt'	=> 'Tatar',
		'twq'	=> 'Tasawaq',
		'ug'	=> 'Uyghur',
		'uk'	=> 'Ukrainian',
		'ur'	=> 'Urdu',
		've'	=> 'Venda',
		'vi'	=> 'Vietnamese',
		'vo'	=> 'Volapük',
		'vun'	=> 'Vunjo',
		'wae'	=> 'Walser',
		'wal'	=> 'Wolaytta',
		'wo'	=> 'Wolof',
		'xh'	=> 'Xhosa',
		'xog'	=> 'Soga',
		'yav'	=> 'Yangben',
		'yo'	=> 'Yoruba',
		'zgh'	=> 'Standard Moroccan Tamazight',
		'zh'	=> 'Chinese (Simplified)',
		'zu'	=> 'Zulu',
	];

	/**
	 * All possible territory codes and names supported on windows platforms.
	 * @var string[]
	 */
	protected static $locales = [
		'001'	=> 'World',
		'029'	=> 'Caribbean',
		'150'	=> 'Europe',
		'419'	=> 'Latin America',
		'AD'	=> 'Andorra',
		'AE'	=> 'U.A.E.',
		'AF'	=> 'Afghanistan',
		'AG'	=> 'Antigua and Barbuda',
		'AI'	=> 'Anguilla',
		'AL'	=> 'Albania',
		'AM'	=> 'Armenia',
		'AO'	=> 'Angola',
		'AR'	=> 'Argentina',
		'AS'	=> 'American Samoa',
		'AT'	=> 'Austria',
		'AU'	=> 'Australia',
		'AW'	=> 'Aruba',
		'AX'	=> 'Åland Islands',
		'BB'	=> 'Barbados',
		'BD'	=> 'Bangladesh',
		'BE'	=> 'Belgium',
		'BF'	=> 'Burkina Faso',
		'BG'	=> 'Bulgaria',
		'BH'	=> 'Bahrain',
		'BI'	=> 'Burundi',
		'BJ'	=> 'Benin',
		'BL'	=> 'Saint Barthélemy',
		'BM'	=> 'Bermuda',
		'BN'	=> 'Brunei Darussalam',
		'BO'	=> 'Bolivia',
		'BQ'	=> 'Bonaire, Sint Eustatius and Saba',
		'BR'	=> 'Brazil',
		'BS'	=> 'Bahamas',
		'BT'	=> 'Bhutan',
		'BW'	=> 'Botswana',
		'BY'	=> 'Belarus',
		'BZ'	=> 'Belize',
		'CA'	=> 'Canada',
		'CC'	=> 'Cocos [Keeling] Islands',
		'CD'	=> 'Congo DRC',
		'CF'	=> 'Central African Republic',
		'CG'	=> 'Congo',
		'CH'	=> 'Switzerland',
		'CI'	=> 'Côte d\'Ivoire',
		'CK'	=> 'Cook Islands',
		'CL'	=> 'Chile',
		'CM'	=> 'Cameroon',
		'CN'	=> 'People\'s Republic of China',
		'CO'	=> 'Colombia',
		'CR'	=> 'Costa Rica',
		'CU'	=> 'Cuba',
		'CV'	=> 'Cabo Verde',
		'CW'	=> 'Curaçao',
		'CX'	=> 'Christmas Island',
		'CY'	=> 'Cyprus',
		'CZ'	=> 'Czechia', // 'Czech Republic' for Windows 7
		'DE'	=> 'Germany',
		'DJ'	=> 'Djibouti',
		'DK'	=> 'Denmark',
		'DM'	=> 'Dominica',
		'DO'	=> 'Dominican Republic',
		'DZ'	=> 'Algeria',
		'EC'	=> 'Ecuador',
		'EE'	=> 'Estonia',
		'EG'	=> 'Egypt',
		'ER'	=> 'Eritrea',
		'ES'	=> 'Spain',
		'ET'	=> 'Ethiopia',
		'FI'	=> 'Finland',
		'FJ'	=> 'Fiji',
		'FK'	=> 'Falkland Islands',
		'FM'	=> 'Micronesia',
		'FO'	=> 'Faroe Islands',
		'FR'	=> 'France',
		'GA'	=> 'Gabon',
		'GB'	=> 'United Kingdom',
		'GD'	=> 'Grenada',
		'GE'	=> 'Georgia',
		'GF'	=> 'French Guiana',
		'GG'	=> 'Guernsey',
		'GH'	=> 'Ghana',
		'GI'	=> 'Gibraltar',
		'GL'	=> 'Greenland',
		'GM'	=> 'Gambia',
		'GN'	=> 'Guinea',
		'GP'	=> 'Guadeloupe',
		'GQ'	=> 'Equatorial Guinea',
		'GR'	=> 'Greece',
		'GT'	=> 'Guatemala',
		'GU'	=> 'Guam',
		'GW'	=> 'Guinea-Bissau',
		'GY'	=> 'Guyana',
		'HK'	=> 'Hong Kong',
		'HN'	=> 'Honduras',
		'HR'	=> 'Croatia',
		'HT'	=> 'Haiti',
		'HU'	=> 'Hungary',
		'ID'	=> 'Indonesia',
		'IE'	=> 'Ireland',
		'IL'	=> 'Israel',
		'IM'	=> 'Isle of Man',
		'IN'	=> 'India',
		'IO'	=> 'British Indian Ocean Territory',
		'IQ'	=> 'Iraq',
		'IR'	=> 'Iran',
		'IS'	=> 'Iceland',
		'IT'	=> 'Italy',
		'JE'	=> 'Jersey',
		'JM'	=> 'Jamaica',
		'JO'	=> 'Jordan',
		'JP'	=> 'Japan',
		'KE'	=> 'Kenya',
		'KG'	=> 'Kyrgyzstan',
		'KH'	=> 'Cambodia',
		'KI'	=> 'Kiribati',
		'KM'	=> 'Comoros',
		'KN'	=> 'Saint Kitts and Nevis',
		'KP'	=> 'North Korea',
		'KR'	=> 'Korea',
		'KW'	=> 'Kuwait',
		'KY'	=> 'Cayman Islands',
		'KZ'	=> 'Kazakhstan',
		'LA'	=> 'Lao P.D.R.',
		'LB'	=> 'Lebanon',
		'LC'	=> 'Saint Lucia',
		'LI'	=> 'Liechtenstein',
		'LK'	=> 'Sri Lanka',
		'LR'	=> 'Liberia',
		'LS'	=> 'Lesotho',
		'LT'	=> 'Lithuania',
		'LU'	=> 'Luxembourg',
		'LV'	=> 'Latvia',
		'LY'	=> 'Libya',
		'MA'	=> 'Morocco',
		'MC'	=> 'Principality of Monaco',
		'MD'	=> 'Moldova',
		'MF'	=> 'Saint Martin',
		'MG'	=> 'Madagascar',
		'MH'	=> 'Marshall Islands',
		'MK'	=> 'Macedonia, FYRO',
		'ML'	=> 'Mali',
		'MM'	=> 'Myanmar',
		'MO'	=> 'Macao SAR',
		'MP'	=> 'Northern Mariana Islands',
		'MQ'	=> 'Martinique',
		'MR'	=> 'Mauritania',
		'MS'	=> 'Montserrat',
		'MT'	=> 'Malta',
		'MU'	=> 'Mauritius',
		'MV'	=> 'Maldives',
		'MW'	=> 'Malawi',
		'MX'	=> 'Mexico',
		'MY'	=> 'Malaysia',
		'MZ'	=> 'Mozambique',
		'NA'	=> 'Namibia',
		'NC'	=> 'New Caledonia',
		'NE'	=> 'Niger',
		'NF'	=> 'Norfolk Island',
		'NG'	=> 'Nigeria',
		'NI'	=> 'Nicaragua',
		'NL'	=> 'Netherlands',
		'NP'	=> 'Nepal',
		'NR'	=> 'Nauru',
		'NU'	=> 'Niue',
		'NZ'	=> 'New Zealand',
		'OM'	=> 'Oman',
		'PA'	=> 'Panama',
		'PE'	=> 'Peru',
		'PF'	=> 'French Polynesia',
		'PG'	=> 'Papua New Guinea',
		'PH'	=> 'Philippines',
		'PK'	=> 'Pakistan',
		'PL'	=> 'Poland',
		'PM'	=> 'Saint Pierre and Miquelon',
		'PN'	=> 'Pitcairn Islands',
		'PR'	=> 'Puerto Rico',
		'PS'	=> 'Palestinian Authority',
		'PT'	=> 'Portugal',
		'PW'	=> 'Palau',
		'PY'	=> 'Paraguay',
		'QA'	=> 'Qatar',
		'RE'	=> 'Reunion',
		'RO'	=> 'Romania',
		'RU'	=> 'Russia',
		'RW'	=> 'Rwanda',
		'SA'	=> 'Saudi Arabia',
		'SB'	=> 'Solomon Islands',
		'SC'	=> 'Seychelles',
		'SD'	=> 'Sudan',
		'SE'	=> 'Sweden',
		'SG'	=> 'Singapore',
		'SH'	=> 'St Helena, Ascension, Tristan da Cunha',
		'SI'	=> 'Slovenia',
		'SJ'	=> 'Svalbard and Jan Mayen',
		'SK'	=> 'Slovakia',
		'SL'	=> 'Sierra Leone',
		'SM'	=> 'San Marino',
		'SN'	=> 'Senegal',
		'SO'	=> 'Somalia',
		'SR'	=> 'Suriname',
		'SS'	=> 'South Sudan',
		'ST'	=> 'São Tomé and Príncipe',
		'SV'	=> 'El Salvador',
		'SX'	=> 'Sint Maarten',
		'SY'	=> 'Syria',
		'SZ'	=> 'Swaziland',
		'TC'	=> 'Turks and Caicos Islands',
		'TD'	=> 'Chad',
		'TG'	=> 'Togo',
		'TH'	=> 'Thailand',
		'TK'	=> 'Tokelau',
		'TL'	=> 'Timor-Leste',
		'TM'	=> 'Turkmenistan',
		'TN'	=> 'Tunisia',
		'TO'	=> 'Tonga',
		'TR'	=> 'Turkey',
		'TT'	=> 'Trinidad and Tobago',
		'TV'	=> 'Tuvalu',
		'TZ'	=> 'Tanzania',
		'UA'	=> 'Ukraine',
		'UG'	=> 'Uganda',
		'UM'	=> 'US Minor Outlying Islands',
		'US'	=> 'United States',
		'UY'	=> 'Uruguay',
		'VA'	=> 'Vatican City',
		'VC'	=> 'Saint Vincent and the Grenadines',
		'VE'	=> 'Bolivarian Republic of Venezuela',
		'VG'	=> 'British Virgin Islands',
		'VI'	=> 'US Virgin Islands',
		'VN'	=> 'Vietnam',
		'VU'	=> 'Vanuatu',
		'WF'	=> 'Wallis and Futuna',
		'WS'	=> 'Samoa',
		'YE'	=> 'Yemen',
		'YT'	=> 'Mayotte',
		'ZA'	=> 'South Africa',
		'ZM'	=> 'Zambia',
		'ZW'	=> 'Zimbabwe',
	];

	/**
	 * Locale script codes and names.
	 * Commented values are not supported on windows yet.
	 * @var string[]
	 */
	protected static $scripts = [
		'Arab'	=>	'Perso-Arabic',
		//'Cans'	=>	'Syllabics',
		//'Cher'	=>	'Cherokee',
		'Cyrl'	=>	'Cyrillic',
		'Latn'	=>	'Latin',
		//'Hans'	=>	'Simplified',
		//'Hant'	=>	'Traditional',
		'Mong'	=>	'Traditional Mongolian',
		//'Tfng'	=>	'Tifinagh',
		//'Vaii'	=>	'Vaii',
	];

	/**
	 * All possible system encoding numbers and encoding names supported on windows.
	 * @var string[]
	 */
	protected static $encodings = [
		'874'			=> 'WINDOWS-874',
		'932'			=> 'CP932',
		'936'			=> 'CP936',
		'949'			=> 'EUC-KR',
		'950'			=> 'CP950',
		'1250'			=> 'WINDOWS-1250',
		'1251'			=> 'WINDOWS-1251',
		'1252'			=> 'WINDOWS-1252',
		'1253'			=> 'WINDOWS-1253',
		'1254'			=> 'WINDOWS-1254',
		'1255'			=> 'WINDOWS-1255',
		'1256'			=> 'WINDOWS-1256',
		'1257'			=> 'WINDOWS-1257',
		'1258'			=> 'WINDOWS-1258',
		//'65001'			=> '',
		'Gaelic'		=> 'WINDOWS-1252',
		//'x-iscii-ma'	=> 'x-iscii-ma',
	];

	/**
	 * Exceptions for windows platforms how to translate language and terotory combination
	 * into language and territory name or how to translte names into codes.
	 * To get 'language_territory' combination for windows `setlocale()` call, you have to
	 * get exception record by code and then you need to join language name and locale name by
	 * data founded in this array:
	 * 'exception_code' => array(
	 *		0	=> lang code,
	 *		1	=> locale code,
	 *		2	=> script code,
	 *		3	=> lang name is between standard langs - 0 - it is between exceptional langs, 1 - i'is between standard langs,
	 *		4	=> lang index in exception langs or lang code in standard langs,
	 *		5	=> territory name is between locales - 1 - it is between exceptional teritories, 2 - it's between standard teritories,
	 *		6	=> territory name or locale code or nothing
	 * Commented values are not supported on windows yet.
	 * @var \array[]
	 */
	protected static $exceptions = [
		'az'			=> ['az', NULL, 'Latn',	0,	1],
		//'az_Cyrl'		=> array('az', NULL, 'Cyrl',	0,	0),
		//'az_Cyrl_AZ'	=> array('az', 'AZ', 'Cyrl',	0,	0,		0,	0),
		//'az_Latn'		=> array('az', NULL, 'Latn',	0,	1),
		//'az_Latn_AZ'	=> array('az', 'AZ', 'Latn',	0,	1,		0,	0),
		//'bm_Latn_ML'	=> array('bm', 'ML', 'Latn',	0,	2,		1,	'ML'),
		'bs'			=> ['bs', NULL, 'Latn',	0,	4],
		//'bs_Cyrl'		=> array('bs', NULL, 'Cyrl',	0,	3),
		//'bs_Cyrl_BA'	=> array('bs', 'BA', 'Cyrl',	0,	3,		0,	1),
		//'bs_Latn'		=> array('bs', NULL, 'Latn',	0,	4),
		//'bs_Latn_BA'	=> array('bs', 'BA', 'Latn',	0,	4,		0,	1),
		//'ca_ES_valencia'=> array('ca', 'ES', 'valencia',1,	'ca',	1,	'ES'),
		//'chr_Cher'		=> array('chr', NULL, 'Cher',	0,	6),
		//'chr_Cher_US'	=> array('chr', 'US', 'Cher',	0,	6,		1,	'US'),
		//'es_ES_tradnl'	=> array('es', 'ES', 'tradnl',	1,	'es',	1,	'ES'),
		//'ff_Latn'		=> array('ff', NULL, 'Latn',	1,	'ff'),
		//'ff_Latn_SN'	=> array('ff', 'SN', 'Latn',	1,	'ff',	1,	'SN'),
		'ha'			=> ['ha', NULL, 'Latn',	0,	7],
		//'ha_Latn'		=> array('ha', NULL, 'Latn',	0,	7),
		//'ha_Latn_GH'	=> array('ha', 'GH', 'Latn',	0,	7,		1,	'GH'),
		//'ha_Latn_NE'	=> array('ha', 'NE', 'Latn',	0,	7,		1,	'NE'),
		//'ha_Latn_NG'	=> array('ha', 'NG', 'Latn',	0,	7,		1,	'NG'),
		'hr_BA'			=> ['hr', 'BA', 'Latn',	1,	'hr',	0,	1],
		'iu'			=> ['iu', NULL, 'Latn',	0,	8],
		//'iu_Cans'		=> array('iu', NULL, 'Cans',	0,	9),
		//'iu_Cans_CA'	=> array('iu', 'CA', 'Cans',	0,	9,		1,	'CA'),
		//'iu_Latn'		=> array('iu', NULL, 'Latn',	0,	8),
		//'iu_Latn_CA'	=> array('iu', 'CA', 'Latn',	0,	8,		1,	'CA'),
		//'jv_Latn'		=> array('jv', NULL, 'Latn',	0,	10,		0,	2),
		//'jv_Latn_ID'	=> array('jv', 'ID', 'Latn',	0,	10,		1,	'ID'),
		//'ks_Arab'		=> array('ks', NULL, 'Arab',	0,	12,		0,	6),
		//'ks_Arab_IN'	=> array('ks', 'IN', 'Arab',	0,	12,		1,	'IN'),
		//'ku_Arab'		=> array('ku', NULL, 'Arab',	1,	'ku'),
		//'ku_Arab_IQ'	=> array('ku', 'IQ', 'Arab',	1,	'ku',	1,	'IQ'),
		//'ku_Arab_IR'	=> array('ku', 'IR', 'Arab',	1,	'ku',	1,	'IR'),
		//'mk_MK'			=> array('mk', 'MK', NULL,		0,	13,		1,	'MK'),
		'mn'			=> ['mn', NULL, 'Cyrl',	0,	14],
		//'mn_Cyrl'		=> array('mn', NULL, 'Cyrl',	0,	14),
		'mn_MN'			=> ['mn', 'MN', 'Cyrl',	0,	14,		0,	3],
		//'mn_Mong'		=> array('mn', NULL, 'Mong',	0,	15),
		//'mn_Mong_CN'	=> array('mn', 'CN', 'Mong',	0,	15,		1,	'CN'),
		'mn_Mong_MN'	=> ['mn', 'MN', 'Mong',	0,	15,		0,	3],
		//'nb'			=> array('nb', NULL, NULL,		1,	'nb'),
		//'nb_NO'			=> array('nb', 'NO', NULL,		1,	'nb',	0,	5),
		'nn_NO'			=> ['nn', 'NO', NULL,		1,	'nn',	0,	5],
		//'os_GE'			=> array('os', 'GE', NULL,		0,	16,		1,	'GE'),
		//'os_RU'			=> array('os', 'RU', NULL,		0,	16,		1,	'RU'),
		//'pa_Arab'		=> array('pa', NULL, 'Arab',	1,	'pa'),
		//'pa_Arab_PK'	=> array('pa', 'PK', 'Arab',	1,	'pa',	1,	'PK'),
		//'quc_Latn_GT'	=> array('quc', 'GT', 'Latn',	0,	11,		1,	'GT'),
		//'sd_Arab'		=> array('sd', NULL, 'Arab',	0,	20),
		//'sd_Arab_PK'	=> array('sd', 'PK', 'Arab',	0,	20,		1,	'PK'),
		'se_FI'			=> ['se', 'FI', NULL,		1,	'se',	1,	'FI'],
		'se_NO'			=> ['se', 'NO', NULL,		1,	'se',	0,	5],
		'se_SE'			=> ['se', 'SE', NULL,		1,	'se',	1,	'SE'],
		//'shi_Latn'		=> array('shi', NULL, 'Latn',	0,	22),
		//'shi_Latn_MA'	=> array('shi', 'MA', 'Latn',	0,	22,		1,	'MA'),
		//'shi_Tfng'		=> array('shi', NULL, 'Tfng',	0,	21,		0,	11),
		//'shi_Tfng_MA'	=> array('shi', 'MA', 'Tfng',	0,	21,		1,	'MA'),
		'sma_NO'		=> ['sma', 'NO', NULL,		1,	'sma',	0,	5],
		'sma_SE'		=> ['sma', 'SE', NULL,		1,	'sma',	1,	'SE'],
		'smj_NO'		=> ['smj', 'NO', NULL,		1,	'smj',	0,	5],
		'smj_SE'		=> ['smj', 'SE', NULL,		1,	'smj',	1,	'SE'],
		'smn_FI'		=> ['smn', 'FI', NULL,		1,	'smn',	1,	'FI'],
		'sms_FI'		=> ['sms', 'FI', NULL,		1,	'sms',	1,	'FI'],
		//'sn_Latn'		=> array('sn', NULL, 'Latn',	0,	19,		0,	2),
		//'sn_Latn_ZW'	=> array('sn', 'ZW', 'Latn',	0,	19,		1,	'ZW'),
		'sr'			=> ['sr', NULL, 'Latn',	0,	18],
		//'sr_Cyrl'		=> array('sr', NULL, 'Cyrl',	0,	17),
		//'sr_Cyrl_BA'	=> array('sr', 'BA', 'Cyrl',	0,	17,		0,	1),
		//'sr_Cyrl_CS'	=> array('sr', 'CS', 'Cyrl',	0,	17,		0,	8),
		//'sr_Cyrl_ME'	=> array('sr', 'ME', 'Cyrl',	0,	17,		0,	4),
		//'sr_Cyrl_RS'	=> array('sr', 'RS', 'Cyrl',	0,	17,		0,	7),
		//'sr_Latn'		=> array('sr', NULL, 'Latn',	0,	18),
		//'sr_Latn_BA'	=> array('sr', 'BA', 'Latn',	0,	18,		0,	1),
		//'sr_Latn_CS'	=> array('sr', 'CS', 'Latn',	0,	18,		0,	8),
		//'sr_Latn_ME'	=> array('sr', 'ME', 'Latn',	0,	18,		0,	4),
		//'sr_Latn_RS'	=> array('sr', 'RS', 'Latn',	0,	18,		0,	7),
		//'tg_Cyrl'		=> array('tg', NULL, 'Cyrl',	0,	23),
		//'tg_Cyrl_TJ'	=> array('tg', 'TJ', 'Cyrl',	0,	23,		0,	10),
		//'tzm_Latn'		=> array('tzm', NULL, 'Latn',	0,	24),
		//'tzm_Latn_DZ'	=> array('tzm', 'DZ', 'Latn',	0,	24,		1,	'DZ'),
		//'tzm_Latn_MA'	=> array('tzm', 'MA', 'Latn',	0,	5,		1,	'MA'),
		//'ur_PK'			=> array('ur', 'PK', NULL,		1,	'ur',	1,	'PK'),
		'uz'			=> ['uz', NULL, 'Latn',	0,	27],
		//'uz_Arab'		=> array('uz', NULL, 'Arab',	0,	25,		0,	6),
		//'uz_Arab_AF'	=> array('uz', 'AF', 'Arab',	0,	25,		1,	'AF'),
		//'uz_Cyrl'		=> array('uz', NULL, 'Cyrl',	0,	26),
		//'uz_Cyrl_UZ'	=> array('uz', 'UZ', 'Cyrl',	0,	26,		0,	13),
		//'uz_Latn'		=> array('uz', NULL, 'Latn',	0,	27),
		//'uz_Latn_UZ'	=> array('uz', 'UZ', 'Latn',	0,	27,		0,	13),
		//'vai_Latn'		=> array('vai', NULL, 'Latn',	0,	29),
		//'vai_Latn_LR'	=> array('vai', 'LR', 'Latn',	0,	29,		1,	'LR'),
		//'vai_Vaii'		=> array('vai', NULL, 'Vaii',	0,	28),
		//'vai_Vaii_LR'	=> array('vai', 'LR', 'Vaii',	0,	28,		1,	'LR'),
		//'zgh_Tfng'		=> array('zgh', NULL, 'Tfng',	1,	'zgh',	0,	11),
		//'zgh_Tfng_MA'	=> array('zgh', 'MA', 'Tfng',	1,	'zgh',	1,	'MA'),
		'zh_CN'			=> ['zh', 'CN', NULL,		1,	'zh',	1,	'CN'],
		//'zh_Hans'		=> array('zh', NULL, 'Hans',	1,	'zh'),
		//'zh_Hant'		=> array('zh', NULL, 'Hant',	1,	'zh'),
		//'zh_HK'			=> array('zh', 'HK', NULL,		1,	'zh',	1,	'HK'),
		//'zh_MO'			=> array('zh', 'MO', NULL,		1,	'zh',	1,	'MO'),
		'zh_SG'			=> ['zh', 'SG', NULL,		1,	'zh',	1,	'SG'],
		'zh_TW'			=> ['zh', 'TW', NULL,		1,	'zh',	0,	9],
	];

	/**
	 * Exceptional language names without any language codes.
	 * @var string[]
	 */
	protected static $exceptionsLangs = [
		//0	=> 'Azerbaijani (Cyrillic)',
		1	=> 'Azerbaijani (Latin)',
		//2	=> 'Bamanankan (Latin)',
		//3	=> 'Bosnian (Cyrillic)',
		4	=> 'Bosnian (Latin)',
		//5	=> 'Central Atlas Tamazight (Latin)',
		//6	=> 'Cherokee',
		7	=> 'Hausa (Latin)',
		8	=> 'Inuktitut (Latin)',
		//9	=> 'Inuktitut (Syllabics)',
		//10	=> 'Javanese',
		//11	=> 'K\'iche',
		//12	=> 'Kashmiri',
		//13	=> 'Macedonian',
		14	=> 'Mongolian (Cyrillic)',
		15	=> 'Mongolian (Traditional Mongolian)',
		//16	=> 'Ossetian',
		//17	=> 'Serbian (Cyrillic)',
		18	=> 'Serbian (Latin)',
		//19	=> 'Shona',
		//20	=> 'Sindhi',
		//21	=> 'Tachelhit',
		//22	=> 'Tachelhit (Latin)',
		//23	=> 'Tajik (Cyrillic)',
		//24	=> 'Tamazight (Latin)',
		//25	=> 'Uzbek',
		//26	=> 'Uzbek (Cyrillic)',
		27	=> 'Uzbek (Latin)',
		//28	=> 'Vai',
		//29	=> 'Vai (Latin)',
	];

	/**
	 * Exceptional territory names without any territory codes.
	 * @var string[]
	 */
	protected static $exceptionsLocales = [
		//0	=> 'Azerbaijan',
		1	=> 'Bosnia and Herzegovina',
		//2	=> 'Latin',
		3	=> 'Mongolia',
		//4	=> 'Montenegro',
		5	=> 'Norway',
		//6	=> 'Perso-Arabic',
		//7	=> 'Serbia',
		//8	=> 'Serbia and Montenegro (Former)',
		9	=> 'Taiwan',
		//10	=> 'Tajikistan',
		//11	=> 'Tifinagh',
		//12	=> 'Uzbekistan',
	];

	/**
	 * Opposite array to translate windows system locale value back into application locale value,
	 * with keys by windows languages names and with values by languages codes.
	 * @var string[]
	 */
	protected static $LANGS = [];

	/**
	 * Opposite array to translate windows system locale value back into application locale value,
	 * with keys by windows territory names and with values by territory codes.
	 * @var string[]
	 */
	protected static $LOCALES = [];

	/**
	 * Opposite array to translate windows system locale value back into application locale value,
	 * with keys by script names and with values by script codes.
	 * @var string[]
	 */
	protected static $SCRIPTS = [];

	/**
	 * Opposite array to translate windows system locale value back into application locale value,
	 * with keys by language name and territory name cobination and with values
	 * as exception indexes into `static::$exceptions` array.
	 * @var string[]
	 */
	protected static $EXCEPTIONS = [];

	/**
	 * `TRUE` if current platform is any windows system, `FALSE` otherwise.
	 * @var bool
	 */
	protected static $windowsPlatform = FALSE;

	/**
	 * Cache array with currently set system locale values, indexed by locale categories. (LC_ALL, LC_CTYPE...)
	 * @var string[]|bool[]
	 */
	protected static $rawSystemValues = [];

	/**
	 * Cache property with currently set parsed system locale for all categories.
	 * @var \stdClass|NULL
	 */
	protected static $allSystemValues = NULL;

	/**
	 * Cache array with currently set parsed system locale values, indexed by locale categories. (LC_ALL, LC_CTYPE...)
	 * @var \stdClass[]
	 */
	protected static $parsedSystemValues = [];

	/**
	 * System locale categories names to parse all set system locale categories properly.
	 * @var string[]
	 */
	protected static $categories = [
		0	=> 'LC_CTYPE',
		1	=> 'LC_NUMERIC',
		2	=> 'LC_TIME',
		3	=> 'LC_COLLATE',
		4	=> 'LC_MONETARY',
		5	=> 'LC_MESSAGES',
		6	=> 'LC_ALL',
	];

	/**
	 * Static class initialization to initialize windows platform boolean.
	 * @return void
	 */
	public static function StaticInit () {
		static::$windowsPlatform = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
	}

	/**
	 * Set locale information on non-windows platforms as it is,
	 * set locale information on windows platforms with `$locale`
	 * specific conversion implemented inside this class to set locale properly.
	 * @param int $category			Named constant specifying the category of the functions affected by the locale setting:
	 *								LC_ALL		For all of the below.
	 *								LC_COLLATE	For string comparison, see `strcoll()`.
	 *								LC_CTYPE	For character classification and conversion, for example `strtoupper()`.
	 *								LC_MONETARY	For `localeconv()`.
	 *								LC_NUMERIC	For decimal separator (See also `localeconv()`).
	 *								LC_TIME		For date and time formatting with `strftime()`.
	 *								LC_MESSAGES	For system responses (available if PHP was compiled with libintl).
	 * @param string|array $locale
	 * @return string				Returns the new current locale, or FALSE if the locale functionality is not implemented on your platform, the specified locale does not exist or the category name is invalid.
	 */
	public static function SetLocale ($category = LC_ALL, $locale = 'en_US.UTF-8@euro') {
		$args = func_get_args();
		$category = array_shift($args);
		$inputLocales = $args;
		$result = NULL;
		$newValue = NULL;
		$parsedLocale = new \stdClass;
		foreach ($inputLocales as $inputLocale) {
			$parsedLocale = static::parseLocale($inputLocale);
			if (static::$windowsPlatform) {
				// translate lang and territory (for windows),
				// remove any encoding (for windows)
				// and let microsoft choose their own crazyshit encoding
				$translatedSystemValue = static::translateParsedLocaleToSystemValue($parsedLocale);
				$result = \setlocale($category, $translatedSystemValue);
				$dotPos = strpos($result, '.');
				if ($dotPos !== FALSE) {
					$encodingBySystem = substr($result, $dotPos + 1);
					if ($encodingBySystem && isset(static::$encodings[$encodingBySystem])) {
						$parsedLocale->encoding = static::$encodings[$encodingBySystem];
					}
				}
				$parsedLocale->system = $result;
			} else {
				$result = \setlocale($category, $parsedLocale->system);
				// try it again without "@euro"
				if ($result === FALSE && $parsedLocale->euro !== NULL) {
					$parsedLocale = static::completeParsedLocaleSystemValue($parsedLocale, FALSE);
					$result = \setlocale($category, $parsedLocale->system);
				}
			}
			$newValue = \setlocale($category, NULL);
			if ($result !== FALSE) break;
		}
		// cache parsed result and raw system value for future `GetLocale()` call(s)
		if ($result !== FALSE) {
			static::$rawSystemValues[$category] = $newValue;
			if ($category === LC_ALL) {
				static::$allSystemValues = $parsedLocale;
				foreach (static::$categories as $categoryId => $categoryName)
					if ($categoryId !== 0)
						static::$parsedSystemValues[$categoryId] = $parsedLocale;
			} else {
				static::$parsedSystemValues[$category] = $parsedLocale;
				if (static::$allSystemValues != NULL && static::$allSystemValues->system !== $parsedLocale->system)
					static::$allSystemValues = NULL;
			}
		}
		return $newValue;
	}

	/**
	 * Return currently set system locale value by given
	 * single locale category as parsed `\stdClass` object or
	 * return currently set system locale values for all categories
	 * by category `LC_ALL` as parsed `\stdClass` object(s), indexed by categories.
	 * Returned parsed locale value `\stdClass` object has fields:
	 * - `lang`		(`string`)		- Language code, lower case (`"en" | "de" ...`).
	 * - `locale`	(`string|NULL`)	- Teritory code, upper case (`"US" | "GB" ...`).
	 * - `script`	(`string|NULL`)	- Script code (`"Latn" | "Cyrl" ...`).
	 * - `encoding`	(`string|NULL`)	- System encoding name (`"UTF-8" | "WINDOWS-1250" | "CP936"...`).
	 * - `euro`		(`string|NULL`)	- `"euro"` if there is Euro support or `NULL` otherwise.
	 * - `system`	`(string|NULL`)	- True system value used by calling PHP `setlocale()` (`"en_GB.UTF-8"` for UNIX or `"English_United Kingdom.WINDOWS-1250"` for Windows).
	 * @param int $category			Named constant specifying the category of the functions affected by the locale setting:
	 *								LC_ALL		For all of the below.
	 *								LC_COLLATE	For string comparison, see `strcoll()`.
	 *								LC_CTYPE	For character classification and conversion, for example `strtoupper()`.
	 *								LC_MONETARY	For `localeconv()`.
	 *								LC_NUMERIC	For decimal separator (See also `localeconv()`).
	 *								LC_TIME		For date and time formatting with `strftime()`.
	 *								LC_MESSAGES	For system responses (available if PHP was compiled with libintl).
	 * @return \stdClass|\stdClass[]|NULL
	 */
	public static function GetLocale ($category = LC_ALL) {
		// try to return remembered translated value(s)
		if ($category !== LC_ALL) {
			if (isset(static::$parsedSystemValues[$category])) {
				return static::$parsedSystemValues[$category];
			} else if (static::$allSystemValues !== NULL) {
				static::$parsedSystemValues[$category] = static::$allSystemValues;
				return static::$parsedSystemValues[$category];
			}
		} else if ($category === LC_ALL && static::$allSystemValues !== NULL) {
			return static::$allSystemValues;
		}
		// parse value(s) from system value
		$rawSystemValue = isset(static::$rawSystemValues[$category])
			? static::$rawSystemValues[$category]
			: \setlocale($category, NULL);
		static::$rawSystemValues[$category] = $rawSystemValue;
		// if value is `C` only - sel att categories to null and return nulls;
		if ($rawSystemValue === 'C') {
			static::$allSystemValues = NULL;
			static::$parsedSystemValues = [];
			return NULL;
		}
		// if system returns more info
		$lccTypeSubstr = 'LC_CTYPE=';
		$lccTypePos = strpos($rawSystemValue, $lccTypeSubstr);
		if ($lccTypePos === FALSE) {
			// all system locale categories has the same value(s)
			$parsedResultItem = static::parseLocale($rawSystemValue);
			$parsedResultItem = static::$windowsPlatform
				? static::translateParsedLocaleToAppValue($parsedResultItem)
				: $parsedResultItem ;
			static::$allSystemValues = $parsedResultItem;
			foreach (static::$categories as $categoryId => $categoryName)
				if ($categoryId !== 0)
					static::$parsedSystemValues[$categoryId] = $parsedResultItem;
		} else {
			// system locale categories has different value(s)
			$rawSystemValue = ';'.$rawSystemValue.';';
			static::$allSystemValues = NULL;
			foreach (static::$categories as $categoryId => $categoryName) {
				if ($categoryId === 0) continue;
				$categoryStr = $categoryName . '=';
				$categoryStrPos = strpos($rawSystemValue, $categoryStr);
				$categoryStrPos += strlen($categoryStr);
				$nextSemicolonPos = strpos($rawSystemValue, ';', $categoryStrPos);
				$subResultToParse = substr($rawSystemValue, $categoryStrPos, $nextSemicolonPos - $categoryStrPos);
				$parsedSubResult = static::parseLocale($subResultToParse);
				$translatedSubResult = static::$windowsPlatform
					? static::translateParsedLocaleToAppValue($parsedSubResult)
					: $parsedSubResult ;
				static::$parsedSystemValues[$category] = $translatedSubResult;
			}
		}
		return $category === LC_ALL
			? static::$parsedSystemValues
			: static::$parsedSystemValues[$category] ;
	}

	/**
	 * Parse given application or system locale value into `\stdClass` object with records:
	 * - `lang`		(`string`)		- Language code (or with language name on windows).
	 * - `locale`	(`string|NULL`)	- Teritory code (or with territory name on windows).
	 * - `script`	(`string|NULL`)	- Script code.
	 * - `encoding`	(`string|NULL`)	- System encoding name (or with system encoding number on windows).
	 * - `euro`		(`string|NULL`)	- `"euro"` if there is Euro support or `NULL` otherwise.
	 * - `system`	`(string|NULL`)	- true system value used by calling PHP `setlocale()`.
	 * @param string $locale
	 * @return \stdClass
	 */
	protected static function parseLocale ($locale = 'en_US.UTF-8@euro') {
		$result = (object) [
			'lang'		=> '',
			'locale'	=> NULL,
			'script'	=> NULL,
			'encoding'	=> NULL,
			'euro'		=> NULL,
			'system'	=> '',
		];
		$locale = (string) $locale;
		// euro
		$atSignPos = strrpos($locale, '@');
		if ($atSignPos !== FALSE) {
			$result->euro = substr($locale, $atSignPos + 1);
			$locale = substr($locale, 0, $atSignPos);
		}
		// encoding
		$dotPos = strrpos($locale, '.');
		if ($dotPos !== FALSE) {
			$result->encoding = strtoupper(substr($locale, $dotPos + 1));
			$locale = substr($locale, 0, $dotPos);
		}
		// lang and locale (and script)
		$firstUnderscorePos = strpos($locale, '_');
		$lastUnderscorePos = strrpos($locale, '_');
		if ($firstUnderscorePos !== FALSE && $lastUnderscorePos !== FALSE) {
			$result->lang = strtolower(substr($locale, 0, $firstUnderscorePos));
			$result->locale = strtoupper(substr($locale, $lastUnderscorePos + 1));
			if ($firstUnderscorePos !== $lastUnderscorePos) {
				$result->script = substr($locale, $firstUnderscorePos + 1, $lastUnderscorePos - $firstUnderscorePos - 1);
			}
		} else {
			$result->lang = strtolower($locale);
		}
		// complete system value
		return static::completeParsedLocaleSystemValue($result, TRUE);
	}

	/**
	 * Complete parsed locale system record (optionally with euro sign or without euro sign).
	 * @param \stdClass $parsedLocale
	 * @param bool $withEuro
	 * @return \stdClass
	 */
	protected static function completeParsedLocaleSystemValue (\stdClass $parsedLocale, $withEuro = TRUE) {
		$parsedLocale->system = $parsedLocale->lang;
		if ($parsedLocale->script !== NULL) $parsedLocale->system .= '_' . $parsedLocale->script;
		if ($parsedLocale->locale !== NULL) $parsedLocale->system .= '_' . $parsedLocale->locale;
		if ($parsedLocale->encoding !== NULL) $parsedLocale->system .= '.' . $parsedLocale->encoding;
		if ($withEuro && $parsedLocale->euro !== NULL) $parsedLocale->system .= '@' . $parsedLocale->euro;
		if (!$withEuro) $parsedLocale->euro = NULL;
		return $parsedLocale;
	}

	/**
	 * Translate parsed system locale value into application locale value.
	 * Do not translate anything on non-windows plaforms, but translate windows system
	 * locale value language, terotiry and encoding combination into standard application values.
	 * @param \stdClass $parsedLocale
	 * @return \stdClass
	 */
	protected static function translateParsedLocaleToAppValue (\stdClass $parsedLocale) {
		if (!static::$windowsPlatform) {
			$result = $parsedLocale;
		} else {
			$result = (object) array_merge([], (array) $parsedLocale);
			if (!static::$LANGS) static::prepareWinConfigOppositeArrays();

			$langAndLocale = $parsedLocale->lang . ($parsedLocale->locale !== NULL ? $parsedLocale->locale : '');
			if (isset(static::$EXCEPTIONS[$langAndLocale])) {
				$exception = static::$EXCEPTIONS[$langAndLocale];
				$result->lang = $exception[0];
				$result->locale = $exception[1];
				if ($result->locale === NULL && isset($exception[5]))
					$result->locale = ($exception[5]
						? $exception[6]
						: static::$exceptionsLocales[$exception[6]]);
				$result->script = $exception[2];
			} else {
				$result->system = $result->lang;
				$langNameUpper = strtoupper($result->lang);
				$result->lang = (isset(static::$LANGS[$langNameUpper])
					? static::$LANGS[$langNameUpper]
					: $result->lang);
				if ($result->script !== NULL) {
					$result->system .= '_' . $result->script;
					$scriptNameUpper = strtoupper($result->script);
					$result->script = (isset(static::$SCRIPTS[$scriptNameUpper])
						? static::$SCRIPTS[$scriptNameUpper]
						: $result->script);
				}
				if ($result->locale !== NULL) {
					$result->system .= '_' . $result->locale;
					$localeNameUpper = strtoupper($result->locale);
					$result->locale = (isset(static::$LOCALES[$localeNameUpper])
						? static::$LOCALES[$localeNameUpper]
						: $result->locale );
				}
			}
			if ($result->encoding !== NULL) {
				$encodingOpposite = static::$encodings[$result->encoding];
				if ($encodingOpposite) {
					$result->system .= '.' . $result->encoding;
					$result->encoding = $encodingOpposite;
				} else {
					$result->system .= '.' . $result->encoding;
				}
			}
		}
		return $result;
	}

	/**
	 * Translate application locale value into proper system locale value.
	 * Do not change anything and return `$parsedLocale->system` immediately
	 * on non-windows platforms. But return translated `$parsedLocale->system`
	 * value on windows platforms into proper string with language and territory combination.
	 * @param \stdClass $parsedLocale
	 * @return string
	 */
	protected static function translateParsedLocaleToSystemValue (\stdClass $parsedLocale) {
		if (!static::$windowsPlatform) {
			// return parsed system value for all non-windows platforms
			return $parsedLocale->system;
		} else {
			$langAndLocale = $parsedLocale->lang;
			if ($parsedLocale->locale !== NULL) $langAndLocale .= '_' . $parsedLocale->locale;
			if (isset(static::$exceptions[$langAndLocale])) {
				// if there is any exception how to define windows locale value - use exception values
				$exception = static::$exceptions[$langAndLocale];
				$result = ($exception[3]
					? static::$langs[$exception[4]]
					: static::$exceptionsLangs[$exception[4]]);
				if (isset($exception[5]))
					$result .= '_' . ($exception[5]
						? static::$locales[$exception[6]]
						: static::$exceptionsLocales[$exception[6]]);
				return $result;
			} else {
				// if there is no exception - translate language and territory (and script if any)
				$result = (isset(static::$langs[$parsedLocale->lang])
						? static::$langs[$parsedLocale->lang]
						: $parsedLocale->lang);
				if ($parsedLocale->script !== NULL) {
					$result .= '_' . (isset(static::$scripts[$parsedLocale->script])
						? static::$scripts[$parsedLocale->script]
						: $parsedLocale->script);
				}
				if ($parsedLocale->locale !== NULL) {
					$result .= '_' . (isset(static::$locales[$parsedLocale->locale])
						? static::$locales[$parsedLocale->locale]
						: $parsedLocale->locale);
				}
				return $result;
			}
		}
	}

	/**
	 * Prepare static configuration arrays to read
	 * and translate windows system locale value
	 * into application locale value.
	 * Create from values keys and from keys values for:
	 * - `static::$langs		=> static::$LANGS`
	 * - `static::$locales		=> static::$LOCALES`
	 * - `static::$scripts		=> static::$SCRIPTS`
	 * - `static::$exceptions	=> static::$EXCEPTIONS` (keys by lang and locale)
	 * @return void
	 */
	protected static function prepareWinConfigOppositeArrays () {
		foreach (static::$langs as $key => $value)
			static::$LANGS[strtoupper($value)] = $key;
		foreach (static::$locales as $key => $value)
			static::$LOCALES[strtoupper($value)] = $key;
		foreach (static::$scripts as $key => $value)
			static::$SCRIPTS[strtoupper($value)] = $key;
		foreach (static::$exceptions as $code => $exception) {
			$langAndLocale = ($exception[3]
				? static::$langs[$exception[4]]
				: static::$exceptionsLangs[$exception[4]]);
			if (isset($exception[5]))
				$langAndLocale .= '_' . ($exception[5]
					? static::$locales[$exception[6]]
					: static::$exceptionsLocales[$exception[6]]);
			static::$EXCEPTIONS[$langAndLocale] = $code;
		}
	}
}
Locale::StaticInit(); // initialize platform boolean
