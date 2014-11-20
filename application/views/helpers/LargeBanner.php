<?php
class Zend_View_Helper_LargeBanner extends Zend_View_Helper_Abstract
{
	public function LargeBanner()
	{
		$advert = array(); 
		
		$refId = new Zend_View_Helper_RefIds();
		
		foreach ($refId->refIds() as $ref) {
if ($ref->hits4pay != '') {
$advert[] = '<a href="http://hits4pay.com/members/index.cgi?'.$ref->hits4pay.'" target="_blank"><img border="0" src="http://hits4pay.com/imgn/banners/728x90.png" width="728" height="90"></a>';
} else {
$advert[] = '<a href="http://hits4pay.com/members/index.cgi?gdc25" target="_blank"><img border="0" src="http://hits4pay.com/imgn/banners/728x90.png" width="728" height="90"></a>';
}
if ($ref->clixsense != '') {
$advert[] = '<a href="http://www.clixsense.com/?'.$ref->clixsense.'" target="_blank"><img src="http://csstatic.com/banners/clixsense_gpt728x90a.png" border="0"></a>';
} else {
$advert[] = '<a href="http://www.clixsense.com/?2251204" target="_blank"><img src="http://csstatic.com/banners/clixsense_gpt728x90a.png" border="0"></a>';
}
if ($ref->sendearnings != '') {
$advert[] = '<a href="http://www.sendearnings.com/?r='.$ref->sendearnings.'" target="_blank"><img src="http://www.sendearnings.com/graphics/creative/banners/728x90/728x90_2.jpg" border="0" /></a>';
} else {
$advert[] = '<a href="http://www.sendearnings.com/?r=ref271274" target="_blank"><img src="http://www.sendearnings.com/graphics/creative/banners/728x90/728x90_2.jpg" border="0" /></a>';
}
if ($ref->inboxdollars != '') {
$advert[] = '<a href="http://www.inboxdollars.com/?r='.$ref->inboxdollars.'" target="_blank"><img src="http://www.inboxdollars.com/graphics/creative/banners/728x90/728x90_1.gif" border="0" /></a>';
} else {
$advert[] = '<a href="http://www.inboxdollars.com/?r=ref12218393" target="_blank"><img src="http://www.inboxdollars.com/graphics/creative/banners/728x90/728x90_1.gif" border="0" /></a>';
}
$advert[] = '<a href="http://www.squishycash.com/homepage?ref=gdc25" target="_blank"><img src="http://squishycash.com/images/banners/66.gif" width="728" height="90" border="0" /></a>';
$advert[] = '<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bdv.bidvertiser.com/BidVertiser.dbm?pid=118577&bid=1364207" type="text/javascript"></SCRIPT><noscript><a href="http://www.bidvertiser.com">pay per click</a></noscript>';
if ($ref->surveysavvy != '') {
$advert[] = '<a href="https://www.surveysavvy.com/?m='.$ref->surveysavvy.'" target="_blank"><img src="http://www.signupandmakemoney.com/Assets/affiliate/surveysavvy-banner.jpg" border="0" alt="Survey Savvy" /></a>';
} else {
$advert[] = '<a href="https://www.surveysavvy.com/?m=2450703" target="_blank"><img src="http://www.signupandmakemoney.com/Assets/affiliate/surveysavvy-banner.jpg" border="0" alt="Survey Savvy" /></a>';
}

		}

shuffle($advert); 

return $advert[0];

	}
}
