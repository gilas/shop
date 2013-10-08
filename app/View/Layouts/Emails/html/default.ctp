<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts.email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
	<title><?php echo $title_for_layout;?></title>
        <style>
            body{
                font-family: Nazanin;

            }
            html{
                direction: rtl;
            }
            h2{
                display: block;
                border-bottom: solid 1px gray;
            }
        </style>
</head>

<body>
	<?php echo $content_for_layout;?>

	<p>این پیام از طرف <a href="http://www.mosafer-behesht.ir">مسافر بهشت</a> فرستاده شده است</p>
</body>
</html>