<meta charset="utf-8">
<?php
require_once "demo.php";
use Hidehalo\Emoji;
$emoji = new Emoji();
echo '
<form method="post">
    <input type="text" name="text">
    <button type="submit">提交</button>
</form>
';
$string = @$_REQUEST['text'];
if($string)
    echo "<p>";
    print_r($emoji->replace($string,'dec'));
    echo "</p>";