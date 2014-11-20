<?php
class Form_Profile extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setName('profile');
		
		$filter = new Zend_Filter_Alnum(array('allowwhitespace' => true));
		
		$address = $this->createElement('text', 'address');
		$address->setLabel('Address:');
		$address->addFilter(new Zend_Filter_StringTrim());
		$address->addFilter(new Zend_Filter_StripTags());
		$address->addFilter(new Zend_Filter_StringToLower());
		$address->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$this->addElement($address);
		
		$city = $this->createElement('text', 'city');
		$city->setLabel('City:');
		$city->addFilter(new Zend_Filter_StringTrim());
		$city->addFilter(new Zend_Filter_StripTags());
		$city->addFilter(new Zend_Filter_StringToLower());
		$city->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
		$city->addValidator(new Zend_Validate_Alpha($filter));
		$this->addElement($city);
		
		$state = $this->createElement('select', 'state');
		$state->addFilter(new Zend_Filter_StringTrim());
		$state->addFilter(new Zend_Filter_StripTags());
		$state->addValidator(new Zend_Validate_StringLength(array('max' => 50)));
        $state ->setLabel('State:')
            ->addMultiOptions(array(
					'' => '',
                    'alabama' => 'Alabama',
                    'alaska' => 'Alaska', 
					'american samoa' => 'American Samoa',
					'arizona' => 'Arizona',
					'arkansas' => 'Arkansas',
					'california' => 'California',
					'colorado' => 'Colorado',
					'connecticut' => 'Connecticut',
					'delaware' => 'Delaware',
					'district of columbia' => 'District of Columbia',
					'florida' => 'Florida',
					'georgia' => 'Georgia',
					'guam' => 'Guam',
					'hawaii' => 'Hawaii',
					'idaho' => 'Idaho',
					'illinois' => 'Illinois',
					'indiana' => 'Indiana',
					'iowa' => 'Iowa',
					'kansas' => 'Kansas',
					'kentucky' => 'Kentucky',
					'louisiana' => 'Louisiana',
					'maine' => 'Maine',
					'maryland' => 'Maryland',
					'massachusetts' => 'Massachusetts',
					'michigan' => 'Michigan',
					'minnesota' => 'Minnesota',
					'mississippi' => 'Mississippi',
					'missouri' => 'Missouri',
					'montana' => 'Montana',
					'nebraska' => 'Nebraska',
					'nevada' => 'Nevada',
					'new hampshire' => 'New Hampshire',
					'new jersey' => 'New Jersey',
					'new mexico' => 'New Mexico',
					'new york' => 'New York',
					'north carolina' => 'North Carolina',
					'north dakota' => 'North Dakota',
					'northern marianas islands' => 'Northern Marianas Islands',
					'ohio' => 'Ohio',
					'oklahoma' => 'Oklahoma',
					'oregon' => 'Oregon',
					'pennsylvania' => 'Pennsylvania',
					'puerto rico' => 'Puerto Rico',
					'rhode island' => 'Rhode Island',
					'south carolina' => 'South Carolina',
					'south dakota' => 'South Dakota',
					'tennessee' => 'Tennessee',
					'texas' => 'Texas',
					'utah' => 'Utah',
					'vermont' => 'Vermont',
					'virginia' => 'Virginia',
					'virgin islands' => 'Virgin Islands',
					'washington' => 'Washington',
					'west virginia' => 'West Virginia',
					'wisconsin' => 'Wisconsin',
					'wyoming' => 'Wyoming'
                 ));   
		$this->addElement($state); 
		
		$country = $this->createElement('select', 'country');
		$country->addFilter(new Zend_Filter_StringTrim());
		$country->addFilter(new Zend_Filter_StripTags());
		$country->addValidator(new Zend_Validate_StringLength(array('max' => 100)));
        $country ->setLabel('Country:')
            ->addMultiOptions(array(
					'' => '',
                    'united states' => 'United States',
                    'canada' => 'Canada', 
					'afghanistan' => 'Afghanistan',
					'albania' => 'Albania',
					'algeria' => 'Algeria',
					'american samoa' => 'American Samoa',
					'andorra' => 'Andorra',
					'angola' => 'Angola',
					'anguilla' => 'Anguilla',
					'antarctica' => 'Antarctica',
					'antigua and barbuda' => 'Antigua and Barbuda',
					'argentina' => 'Argentina',
					'armenia' => 'Armenia',
					'aruba' => 'Aruba',
					'australia' => 'Australia',
					'austria' => 'Austria',
					'azerbaijan' => 'Azerbaijan',
					'bahamas' => 'Bahamas',
					'bahrain' => 'Bahrain',
					'bangladesh' => 'Bangladesh',
					'barbados' => 'Barbados',
					'belarus' => 'Belarus',
					'Belgium' => 'Belgium',
					'belize' => 'Belize',
					'benin' => 'Benin',
					'bermuda' => 'Bermuda',
					'bhutan' => 'Bhutan',
					'bolivia' => 'Bolivia',
					'bosnia and Herzegovina' => 'Bosnia and Herzegovina',
					'botswana' => 'Botswana',
					'brazil' => 'Brazil',
					'brunei darussalam' => 'Brunei Darussalam',
					'bulgaria' => 'Bulgaria',
					'burkina faso' => 'Burkina Faso',
					'burundi' => 'Burundi',
					'cambodia' => 'Cambodia',
					'cameroon' => 'Cameroon',
					'cape verde' => 'Cape Verde',
					'cayman islands' => 'Cayman Islands',
					'central african republic' => 'Central African Republic',
					'chad' => 'Chad',
					'chile' => 'Chile',
					'china' => 'China',
					'christmas Island' => 'Christmas Island',
					'cocos kslands' => 'Cocos Islands',
					'colombia' => 'Colombia',
					'comoros' => 'Comoros',
					'democratic republic of the congo' => 'Democratic Republic of the Congo',
					'cook cslands' => 'Cook Islands',
					'costa cica' => 'Costa Rica',
					'ivory coast' => 'Ivory Coast',
					'croatia' => 'Croatia',
					'cuba' => 'Cuba',
					'cyprus' => 'Cyprus',
					'czech republic' => 'Czech Republic',
					'denmark' => 'Denmark',
					'djibouti' => 'Djibouti',
					'dominica' => 'Dominica',
					'dominican republic' => 'Dominican Republic',
					'east timor' => 'East Timor',
					'ecuador' => 'Ecuador',
					'egypt' => 'Egypt',
					'el salvador' => 'El Salvador',
					'equatorial guinea' => 'Equatorial Guinea',
					'eritrea' => 'Eritrea',
					'estonia' => 'Estonia',
					'ethiopia' => 'Ethiopia',
					'falkland islands' => 'Falkland Islands',
					'faroe islands' => 'Faroe Islands',
					'fiji' => 'Fiji',
					'finland' => 'Finland',
					'france' => 'France',
					'french polynesia' => 'French Polynesia',
					'gabon' => 'Gabon',
					'gambia' => 'Gambia',
					'georgia' => 'Georgia',
					'germany' => 'Germany',
					'ghana' => 'Ghana',
					'gibraltar' => 'Gibraltar',
					'greece' => 'Greece',
					'greenland' => 'Greenland',
					'grenada' => 'Grenada',
					'guadeloupe' => 'Guadeloupe',
					'guam' => 'Guam',
					'guatemala' => 'Guatemala',
					'guinea' => 'Guinea',
					'guinea Bissau' => 'Guinea Bissau',
					'guyana' => 'Guyana',
					'haiti' => 'Haiti',
					'holy see' => 'Holy See',
					'honduras' => 'Honduras',
					'hong kong' => 'Hong Kong',
					'hungary' => 'Hungary',
					'Iceland' => 'Iceland',
					'India' => 'India',
					'Indonesia' => 'Indonesia',
					'iran' => 'Iran',
					'iraq' => 'Iraq',
					'ireland' => 'Ireland',
					'israel' => 'Israel',
					'italy' => 'Italy',
					'jamaica' => 'Jamaica',
					'japan' => 'Japan',
					'jordan' => 'Jordan',
					'kazakhstan' => 'Kazakhstan',
					'kenya' => 'Kenya',
					'kiribati' => 'Kiribati',
					'north korea' => 'North Korea',
					'south korea' => 'South Korea',
					'kosovo' => 'Kosovo',
					'kuwait' => 'Kuwait',
					'kyrgyzstan' => 'Kyrgyzstan',
					'lao' => 'Lao',
					'latvia' => 'Latvia',
					'lebanon' => 'Lebanon',
					'lesotho' => 'Lesotho',
					'liberia' => 'Liberia',
					'libya' => 'Libya',
					'liechtenstein' => 'Liechtenstein',
					'lithuania' => 'Lithuania',
					'luxembourg' => 'Luxembourg',
					'macau' => 'Macau',
					'macedonia' => 'Macedonia',
					'madagascar' => 'Madagascar',
					'malawi' => 'Malawi',
					'malaysia' => 'Malaysia',
					'maldives' => 'Maldives',
					'mali' => 'Mali',
					'malta' => 'Malta',
					'marshall Islands' => 'Marshall Islands',
					'martinique' => 'Martinique',
					'mauritania' => 'Mauritania',
					'mauritius' => 'Mauritius',
					'mayotte' => 'Mayotte',
					'mexico' => 'Mexico',
					'micronesia' => 'Micronesia',
					'moldova' => 'Moldova',
					'monaco' => 'Monaco',
					'mongolia' => 'Mongolia',
					'montenegro' => 'Montenegro',
					'montserrat' => 'Montserrat',
					'morocco' => 'Morocco',
					'mozambique' => 'Mozambique',
					'myanmar' => 'Myanmar',
					'namibia' => 'Namibia',
					'nauru' => 'Nauru',
					'nepal' => 'Nepal',
					'netherlands' => 'Netherlands',
					'new caledonia' => 'New Caledonia',
					'new zealand' => 'New Zealand',
					'nicaragua' => 'Nicaragua',
					'niger' => 'Niger',
					'nigeria' => 'Nigeria',
					'niue' => 'Niue',
					'northern mariana islands' => 'Northern Mariana Islands',
					'norway' => 'Norway',
					'oman' => 'Oman',
					'pakistan' => 'Pakistan',
					'palau' => 'Palau',
					'palestinian territories' => 'Palestinian territories',
					'panama' => 'Panama',
					'papua new guinea' => 'Papua New Guinea',
					'paraguay' => 'Paraguay',
					'peru' => 'Peru',
					'philippines' => 'Philippines',
					'pitcairn island' => 'Pitcairn Island',
					'poland' => 'Poland',
					'portugal' => 'Portugal',
					'puerto rico' => 'Puerto Rico',
					'qatar' => 'Qatar',
					'reunion island' => 'Reunion Island',
					'romania' => 'Romania',
					'russian Federation' => 'Russian Federation',
					'rwanda' => 'Rwanda',
					'saint kitts and nevis' => 'Saint Kitts and Nevis',
					'saint lucia' => 'Saint Lucia',
					'saint vincent and the grenadines' => 'Saint Vincent and the Grenadines',
					'samoa' => 'Samoa',
					'san marino' => 'San Marino',
					'saudi arabia' => 'Saudi Arabia',
					'senegal' => 'Senegal',
					'serbia' => 'Serbia',
					'seychelles' => 'Seychelles',
					'sierra leone' => 'Sierra Leone',
					'singapore' => 'Singapore',
					'slovakia' => 'Slovakia',
					'slovenia' => 'Slovenia',
					'solomon islands' => 'Solomon Islands',
					'somalia' => 'Somalia',
					'south africa' => 'South Africa',
					'south sudan' => 'South Sudan',
					'spain' => 'Spain',
					'sri lanka' => 'Sri Lanka',
					'sudan' => 'Sudan',
					'suriname' => 'Suriname',
					'swaziland' => 'Swaziland',
					'sweden' => 'Sweden',
					'switzerland' => 'Switzerland',
					'syria' => 'Syria',
					'taiwan' => 'Taiwan',
					'tajikistan' => 'Tajikistan',
					'tanzania' => 'Tanzania',
					'thailand' => 'Thailand',
					'tibet' => 'Tibet',
					'east timor' => 'East Timor',
					'togo' => 'Togo',
					'tokelau' => 'Tokelau',
					'tonga' => 'Tonga',
					'trinidad and tobago' => 'Trinidad and Tobago',
					'tunisia' => 'Tunisia',
					'turkey' => 'Turkey',
					'turkmenistan' => 'Turkmenistan',
					'turks and caicos islands' => 'Turks and Caicos Islands',
					'tuvalu' => 'Tuvalu',
					'uganda' => 'Uganda',
					'ukraine' => 'Ukraine',
					'united arab emirates' => 'United Arab Emirates',
					'united kingdom' => 'United Kingdom',
					'uruguay' => 'Uruguay',
					'uzbekistan' => 'Uzbekistan',
					'vanuatu' => 'Vanuatu',
					'venezuela' => 'Venezuela',
					'vietnam' => 'Vietnam',
					'virgin islands' => 'Virgin Islands',
					'wallis and futuna islands' => 'Wallis and Futuna Islands',
					'western sahara' => 'Western Sahara',
					'yemen' => 'Yemen',
					'zaire' => 'Zaire',
					'zambia' => 'Zambia',
					'zimbabwe' => 'Zimbabwe',
					'other' => 'Other'
				 ));   
		$this->addElement($country);
		
		$zip = $this->createElement('text', 'zip');
		$zip->setLabel('Zip:');
		$zip->addFilter(new Zend_Filter_StringTrim());
		$zip->addFilter(new Zend_Filter_StripTags());
		$zip->addValidator(new Zend_Validate_StringLength(array('max' => 5)));
		$zip->addValidator(new Zend_Validate_Alnum($filter));
		$this->addElement($zip); 
		
		$phone = $this->createElement('text', 'phone');
		$phone->setLabel('Phone:');
		$phone->setDescription('Ex: 5555555555, numbers only.');
		$phone->addFilter(new Zend_Filter_StripTags());
		$phone->addFilter(new Zend_Filter_StringTrim());
		$phone->addValidator(new Zend_Validate_StringLength(array('max' => 20)));
		$phone->addValidator(new Zend_Validate_Alnum());
		$this->addElement($phone);
		
		// still working on this one
		$dob = $this->createElement('text', 'dob');
		$dob->setLabel('Date of Birth:');
		$dob->setDescription('Ex: yyyy-MM-dd, 1985-06-01 format.');
		$dob->addFilter(new Zend_Filter_StringTrim());
		$dob->addValidator(new Zend_Validate_StringLength(array('max' => 10)));
		$dob->addFilter(new Zend_Filter_StripTags());
		
		$dateValidator = new Zend_Validate_Date();
		$dateValidator->isValid('2000-10-10');
		
		$dob->addValidator($dateValidator);
		$this->addElement($dob);
		
		$reminders = new Zend_Form_Element_Checkbox('reminders');
		$reminders->setLabel('Send Reminders');
		$reminders->setCheckedValue('yes');
		$reminders->setUncheckedValue('no');
		$reminders->setChecked(true); 
		$this->addElement($reminders);
		
		$blog = $this->createElement('text', 'blog');
		$blog->setLabel('Blog url');
		$blog->setDescription('Ex: http://www.myblog.com (must begin with http://)');
		$blog->addFilter(new Zend_Filter_StringTrim());
		$blog->addFilter(new Zend_Filter_StripTags());
		$blog->addFilter(new Zend_Filter_StringToLower());
		$blog->addValidator(new Zend_Validate_StringLength(array('max' => 50)));
		$this->addElement($blog);
		
		$facebook = $this->createElement('text', 'facebook');
		$facebook->setLabel('Facebook Username:');
		$facebook->setDescription('Ex: http://www.facebook.com/USERNAME');
		$facebook->addFilter(new Zend_Filter_StringTrim());
		$facebook->addFilter(new Zend_Filter_StripTags());
		$facebook->addFilter(new Zend_Filter_StringToLower());
		$facebook->addValidator(new Zend_Validate_StringLength(array('max' => 50)));
		$this->addElement($facebook);
		
		$twitter = $this->createElement('text', 'twitter');
		$twitter->setLabel('Twitter Username:');
		$twitter->setDescription('Ex: http://twitter.com/USERNAME');
		$twitter->addFilter(new Zend_Filter_StringTrim());
		$twitter->addFilter(new Zend_Filter_StripTags());
		$twitter->addFilter(new Zend_Filter_StringToLower());
		$twitter->addValidator(new Zend_Validate_StringLength(array('max' => 50)));
		$this->addElement($twitter);
		
		
		$this->addElement('submit', 'submit', array(
			'label' => 'Update'
		));
		
		$this->addElement('hidden', 'user_id', array(
			'filters' => array('StringTrim')
		));
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/profile/');
	}
}
