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
echo "Connecte";





$url = "https://allafrica.com/tools/headlines/rdf/namibia/headlines.rdf";
$rss = simplexml_load_file($url);

if($rss)
{
echo '<h1>'.$rss->channel->title.'</h1>';
echo '<li>'.$rss->channel->link.'</li>';
echo '<li>'.$rss->channel->item.'</li>';
$items = $rss->channel->item;

require_once 'vendor/autoload.php';



foreach($items as $item)
{

	

	
	
$title = $item->title;
$link = $item->link;
$published_on = $item->pubDate;
$description = $item->description;
//$category = $output;
$guid = $item->guid;











echo '<h3><a href="'.$link.'">'.$title.'</a></h3>';
echo '<span>('.$published_on.')</span>';
echo '<p>'.$description.'</p>';
//echo '<p>'.$category.'</p>';
echo '<p>'.$guid.'</p>';

$input1 = (string)$item->link;
$client1 = Algorithmia::client("simYzWmJq6ESnUvDZ00nHsJGs6T1");
$algo1 = $client1->algo("util/Html2Text/0.1.6");
//print_r($algo1->pipe($input1)->result);



$input =(string)$algo1->pipe($input1)->result;
$client = Algorithmia::client("simYzWmJq6ESnUvDZ00nHsJGs6T1");
$algo = $client->algo("nlp/AutoTag/1.0.1");
print_r($algo->pipe($input)->result);
$records = $algo->pipe($input)->result;


$sql = "INSERT INTO newstags (one,two,three,four,five,six,link) VALUES ('$records[1]','$records[2]','$records[3]','$records[4]','$records[5]','$records[6]','$link')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}












echo "<img src=\"" . (string)$item->enclosure['url'][0] . "\">";
}
$conn->close();
}
?> 































?>
</body>
</html> 