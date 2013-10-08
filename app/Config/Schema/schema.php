<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $aros = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $aros_acos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'aro_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'aco_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'_create' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'_read' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'_update' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'_delete' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'aco_id' => array('column' => 'aco_id', 'unique' => 0),
			'aro_id' => array('column' => 'aro_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'id of comment for replying from users for example administrator reply a comment which posted from Mohammad and it will be show in a quote tag in below the parent comment 
 default is set to 0 for the main(parent) comments'),
		'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'first name of user who add the comment this field is for guest users who haven\'t user account in site', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'user email address', 'charset' => 'utf8'),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'web site address', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'comment' => 'comment body', 'charset' => 'utf8'),
		'published' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'comment is published or not By default all comment is published => published = 1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'content_id' => array('column' => 'content_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $contact_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'title of contact', 'charset' => 'utf8'),
		'manager' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'manager name of company or web site', 'charset' => 'utf8'),
		'telephone_1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 11, 'collate' => 'utf8_persian_ci', 'comment' => 'company tel #1 example : 05118456628', 'charset' => 'utf8'),
		'telephone_2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 11, 'collate' => 'utf8_persian_ci', 'comment' => 'company tel #2 example : 05118456629', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 11, 'collate' => 'utf8_persian_ci', 'comment' => 'company fax number', 'charset' => 'utf8'),
		'mobile' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 11, 'collate' => 'utf8_persian_ci', 'comment' => 'manger mobile number or company mobile number', 'charset' => 'utf8'),
		'sms_center' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 14, 'collate' => 'utf8_persian_ci', 'comment' => 'company sms center for example : 3000662849', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $content_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'parent id of a category default is 0 this mean the category is parent! '),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_persian_ci', 'comment' => 'name of category', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'the id of user from users table who post the content'),
		'content_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'id of content category'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'allow_comment' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'determine users can adding comments to this post or not?'),
		'published_comment' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'this field determine comment show after added by users or after published by administrator'),
		'frontpage' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'status of content to show on the frontpage or not in the other pages By default all content is in other pages!'),
		'published' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'status of content to be published or not By default all content is published'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'UQ_gl_contents_slug' => array('column' => 'slug', 'unique' => 1),
			'content_category_id' => array('column' => 'content_category_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $gallery_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'category parent id  By default all category added to the app is parent while the admin did \'nt  select a parent for its'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'folder_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'category folder name for inserting images! for example image category folder is stored to : app/webroot/images/gallery 
 and category name is MyFreinds so the images which added to this category will stored into :  app/webroot/images/gallery/MyFreinds', 'charset' => 'utf8'),
		'published' => array('type' => 'integer', 'null' => true, 'default' => null),
		'lft' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'rght' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $gallery_items = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'user id who added this image!'),
		'gallery_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_persian_ci', 'comment' => 'image title', 'charset' => 'utf8'),
		'image_file_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_persian_ci', 'comment' => 'image name for accessing to it on gallery category folder', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_persian_ci', 'comment' => 'image descriptions', 'charset' => 'utf8'),
		'published' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'By default all images is published!'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'gallery_category_id' => array('column' => 'gallery_category_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $menus = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'menu parent id for example a gallery menu which link\'s to My Friends Gallery is a Child of Gallery menu which was an separator menu type  
 By default all menu is parent=>0'),
		'title' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_persian_ci', 'comment' => 'menu alias for using on slugs', 'charset' => 'utf8'),
		'type' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'menu type for example :  1) contact 2) gallery 3) static page(linked to content) 4) web links 5) register 6) menu separator 7) site map ,.....'),
		'published' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'By default all menu is published'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null),
		'level' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $slider_items = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'link' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_persian_ci', 'comment' => 'reference link for this slide', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'image title', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_persian_ci', 'comment' => 'image description for displaying under title!', 'charset' => 'utf8'),
		'image_file_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_persian_ci', 'comment' => 'image name for accessing the true image on the slider folder! for example :  app/webroot/images/slider/slide_01.jpg', 'charset' => 'utf8'),
		'published' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'By default all images in slider is published!'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'key' => 'unique', 'collate' => 'utf8_persian_ci', 'comment' => 'username must be unique', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'Both Of first name and last name', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'activation status of users By default all users is deactivated'),
		'registered_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'last_logged_in' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => 'latest login of user to the web site'),
		'last_ip_logged_in' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'UQ_gl_users_username' => array('column' => 'username', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $weblink_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
	public $weblinks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'weblink_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_persian_ci', 'comment' => 'links title', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_persian_ci', 'comment' => 'links description', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_persian_ci', 'comment' => 'link address', 'charset' => 'utf8'),
		'hits' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'number of link hits after each click on link hits +1'),
		'published' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4, 'comment' => 'By default all link is published'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'weblink_category_id' => array('column' => 'weblink_category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'MyISAM')
	);
}
