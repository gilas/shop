<?php
App::uses('UserInformation', 'Model');

/**
 * UserInformation Test Case
 *
 */
class UserInformationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_information'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserInformation = ClassRegistry::init('UserInformation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserInformation);

		parent::tearDown();
	}

}
