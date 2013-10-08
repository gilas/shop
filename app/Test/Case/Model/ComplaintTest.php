<?php
App::uses('Complaint', 'Model');

/**
 * Complaint Test Case
 *
 */
class ComplaintTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.complaint',
		'app.user',
		'app.role',
		'app.content',
		'app.content_category',
		'app.comment',
		'app.gallery_item',
		'app.gallery_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Complaint = ClassRegistry::init('Complaint');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Complaint);

		parent::tearDown();
	}

}
