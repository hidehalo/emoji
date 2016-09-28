<meta charset="utf-8">
<?php
require_once "demo.php";
use Hidehalo\Emoji;
$emoji = new Emoji();
echo '
<form method="post" style="text-align:center;">
    <textarea type="text" name="text" rows="5" cols="120"></textarea>
    <br>
    <button type="submit" style="width:864px;">提交</button>
</form>
';
$string = @$_REQUEST['text']?$_REQUEST['text']:"";
if($string) {
    echo "<p style=\"text-align:center\">";
    print_r("没有匹配到的:".$emoji->replace($string,'clean'));
    echo "</p>";
}
