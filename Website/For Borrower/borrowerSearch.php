<?php
//session_start();
$error=0;
$Body="";
$input=true;

if(isset($_POST['submit'])){ // Check if form was submitted

    $keyword = $_POST['keyword']; // Get input text
    $message = "<h3>You have entered keyword: " . $keyword."</h3>";
    echo $message;
    $input=false;
    //then start to search
    include("inc_digitalLibrary.php");
    $TableName = "resource";
   $sql = "SELECT * FROM $TableName where ISBN like '%$keyword%' or title like '%$keyword%' or author like '%$keyword%' or publisher like '%$keyword%' or status like '%$keyword%'";
   $qRes = mysqli_query($conn, $sql);
   if (mysqli_num_rows($qRes) > 0) {
    while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
        $avaliable[] = $Row;
    mysqli_free_result($qRes);
//mysqli_close($conn);
echo "<h1>The resource correlated.</h1>";
echo "<br/>";
//table and header
echo "<table border='1' width='100%'>\n";
echo "<tr>\n";
echo " <th style='background-color:cyan;width:100px'>BOOK NUMBER</th>\n";
echo " <th style='background-color:cyan'>ISBN</th>\n";
echo " <th style='background-color:cyan'>TITLE</th>\n";
echo " <th style='background-color:cyan'>AUTHOR</th>\n";
echo " <th style='background-color:cyan'>PUBLISHER</th>\n";
echo " <th style='background-color:cyan;width:100px'>COST PER DAY ($)</th>\n";
echo " <th style='background-color:cyan'>STATUS</th>\n";
echo "</tr>\n";
foreach ($avaliable as $a) {
    echo "<tr>\n";
    echo " <td style='text-align:center'>" . htmlentities($a['bookNo']) . "</td>\n";
    echo " <td style='text-align:center'>" . htmlentities($a['ISBN']) . "</td>\n";
    echo " <td style='text-align:center'>" . htmlentities($a['title']) . "</td>\n";
    echo " <td style='text-align:center'>" . htmlentities($a['author']) . "</td>\n";
    echo " <td style='text-align:center'>" . htmlentities($a['publisher']) . "</td>\n";
    echo " <td style='text-align:center'>" . htmlentities($a['cost_per_day']) . "</td>\n";
    echo " <td style='text-align:center;width:300px'>" . htmlentities($a['status']) . "</td>\n";
    echo "</tr>\n";

}
echo "</table>\n";

}
else if (mysqli_num_rows($qRes) == 0) {
  echo "<p>sorry no resource can be found according to your key word, please try another keyword.</p>";
}
}
if (isset($_SESSION['userID'])){

	$userID = $_SESSION['userID'];
    //echo "session set successfull";
}
else {
	$Body .= "<p>You have not logged in or registered. Please return to the <a href='registerAndLogin.php'>Registration / Log In page</a>.</p>";
	++$error;
    echo "$error";
}
if($input==true){ 
   $Body .='<form method="post" action="" >';
        
    $Body .='<p>Please enter the key word to search the resource: <input type="text" name="keyword" /></p>';
    //$Body .='<p>please enter the date of borrowing: <input type="date" name="password" /></p>';
    $Body .='<p><input type="submit" name="submit" value="submit" /></p>';
    $Body .='</form>';
}

    echo $Body;


?>