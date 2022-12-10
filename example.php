<?php
include("BBCode2HTML.php");

/**
 * example for the use of BBCode2HTML Class
 *
 * This class is free for the educational use as long as maintain this header together with this class.
 * Author: Win Aung Cho
 * Contact winaungcho@gmail.com
 * version 1.0 10-12-2022
 * Date: 10-12-2022
 */
 
$post = <<<EOD
[img h=200 w=300]http://www.structsoftlab.com/android/AndroCAD/images/logo.jpg[/img][hr/]
[a href="http://blog.civil-uni.com"]phpBLOG[s][b]Site[/b][/s][/a][hr/]
[img w=350 src="https://structsoftlab.com/images/Logo.gif" /]
[hr/]
[a ref='http://edu.structsoftlab.com'][h1]Author's HOME[/h1][/a]
[table w=600 border="1" bg="#dff" c=green]
[tr][th]name[/th][th]value[/th][th]remark[/th][/tr]
[tr][th cspan=3]Sample Table[/th][/tr]
[tr][td]Item one[/td][td a=right]345.67[/td][td]in $[/td][/tr]
[tr][td]Item two[br/]next line[/td][td a=center][b]two[/b][/td][td bg=red a=right]format[/td][/tr]
[/table]

[ol/]
[ol]
[li c="blue"]Main[/li]
[li]Heading 1[/li]
[ol]
[li]item 1[/li]
[li]item 2
[ul][li][a ref='http://edu.structsoftlab.com/forum']link 1[/a][/li]
[li][a ref='http://www.structsoftlab.com']link 2[/a] [/li]
[/ul][/li]
[/ol]
[li]item 3[/li]
[/ol]
EOD;

$bb2html = new BBCode2HTML();
echo $bb2html->parse($post);

?>
