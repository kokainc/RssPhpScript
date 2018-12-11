<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "rssnews";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";




$url = "https://allafrica.com/tools/headlines/rdf/namibia/headlines.rdf";
$rss = simplexml_load_file($url);

if($rss)
{
echo '<h1>'.$rss->channel->title.'</h1>';
echo '<li>'.$rss->channel->pubDate.'</li>';
$items = $rss->channel->item;
foreach($items as $item)
{
$title = $item->title;
$link = $item->link;
$published_on = $item->pubDate;
$description = $item->description;
$category = $item->category;
$guid = $item->guid;
//, Publish Date, Description, Link
//, '$published_on', '$description', '$link'


$sql = "
INSERT INTO NewsLibrary (Title,Link)
VALUES ('$title','$link')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



echo '<h3><a href="'.$link.'">'.$title.'</a></h3>';
echo '<span>('.$published_on.')</span>';
echo '<p>'.$description.'</p>';
echo '<p>'.$category.'</p>';
echo '<p>'.$guid.'</p>';
echo "<img src=\"" . (string)$item->enclosure['url'][0] . "\">";
}
$conn->close();
}
?> 
</body>
</html>