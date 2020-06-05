<?php
function lang( $pharse ){
	static $lang = array(
		//Navbar Links
		'HOME_ADMIN'    => 'Home' ,
		'CATEGORIES'    => 'Categories ',
		'ITEMS'         => 'Items' ,
		'MEMBERS'       => 'Members' ,
		'COMMENTS'      => 'comments',
        'STATISTIC'     => 'Statistic',
		'LOGS'          => 'Logs' 

		 
	);
	return $lang[$pharse];
}




/*$lang = array(
	'osama' => 'zero'
);
echo $lang['osama'] ;*/