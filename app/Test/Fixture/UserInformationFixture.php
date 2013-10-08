<?php
/**
 * UserInformationFixture
 *
 */
class UserInformationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'this field determine the user id of registered user but by default have 0 value. when the request has been submitted then a user record will be create for this user and that user id completed with this'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => 'users first name', 'charset' => 'latin1'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => 'users last name', 'charset' => 'latin1'),
		'place_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'id of place which user added request for that'),
		'class_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'user paper class id '),
		'degree_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'users degree id which will complete By System Administrator'),
		'father_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => 'users father name', 'charset' => 'latin1'),
		'alias_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'gender' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'comment' => 'users gender'),
		'code_melli' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shenasnameh_number' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mahale_sodoor' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'birth_day' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'din' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mazhab' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'vazifeh_omoomi' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'madrak_tahsili' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'taahol' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'sarparast' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'afrad_tahte_takafol' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'comment' => 'number of people who is takafol him :)'),
		'isargari' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'gov_employment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => '0 means not', 'charset' => 'latin1'),
		'reg_other_union' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => '0 means not', 'charset' => 'latin1'),
		'parvaneh_other_union' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => '0 means not', 'charset' => 'latin1'),
		'latest_employment' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'comment' => '0 means not other employments', 'charset' => 'latin1'),
		'history_duration' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'comment' => '0 means not'),
		'postal_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'latin1_swedish_ci', 'comment' => '0511-8519648', 'charset' => 'latin1'),
		'home_address' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mobile' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 11, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'market_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'market_sign' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'market_address' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'market_telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'market_fax' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'market_postal_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mantagheh_shahrdari' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'nahiye_shahrdari' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'hozeh_kalantari' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'vazeyat_joghrafiaee' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'mahale_esteghrar' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'vazeyat_malekiat' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'market_masahat' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'cod_rahgiri' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'status' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'first_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'place_id' => 1,
			'class_id' => 1,
			'degree_id' => 1,
			'father_name' => 'Lorem ipsum dolor sit amet',
			'alias_name' => 'Lorem ipsum dolor sit amet',
			'gender' => 1,
			'code_melli' => 'Lorem ip',
			'shenasnameh_number' => 'Lorem ip',
			'mahale_sodoor' => 'Lorem ipsum dolor sit amet',
			'birth_day' => 'Lorem ip',
			'din' => 'Lorem ipsum dolor sit amet',
			'mazhab' => 'Lorem ipsum dolor sit amet',
			'vazifeh_omoomi' => 1,
			'madrak_tahsili' => 1,
			'taahol' => 1,
			'sarparast' => 1,
			'afrad_tahte_takafol' => 1,
			'isargari' => 1,
			'gov_employment' => 'Lorem ipsum dolor sit amet',
			'reg_other_union' => 'Lorem ipsum dolor sit amet',
			'parvaneh_other_union' => 'Lorem ipsum dolor sit amet',
			'latest_employment' => 'Lorem ipsum dolor sit amet',
			'history_duration' => 1,
			'postal_code' => 'Lorem ip',
			'telephone' => 'Lorem ipsu',
			'home_address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'mobile' => 'Lorem ips',
			'market_name' => 'Lorem ipsum dolor sit amet',
			'market_sign' => 'Lorem ipsum dolor sit amet',
			'market_address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'market_telephone' => 'Lorem ipsu',
			'market_fax' => 'Lorem ipsu',
			'market_postal_code' => 'Lorem ip',
			'mantagheh_shahrdari' => 1,
			'nahiye_shahrdari' => 1,
			'hozeh_kalantari' => 'Lorem ipsum dolor sit amet',
			'vazeyat_joghrafiaee' => 1,
			'mahale_esteghrar' => 1,
			'vazeyat_malekiat' => 1,
			'market_masahat' => 1,
			'cod_rahgiri' => 'Lorem ipsum dolor ',
			'status' => 1
		),
	);

}
