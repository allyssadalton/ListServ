<!-- Allyssa Dalton
 March 3rd, 2025-->

<html>
<head>
	<title>Lists & Subscribers</title>
    <link rel = "stylesheet" href="commonstylesheet.css">
</head>

<body>

<h1>View Email/SMS Lists & Their Subscribers</h1>

<div class='emailLists'>
<h2>Email Lists</h2>
<?php
    include 'db.php';
    $sql = 'SELECT * FROM List_name;';

    $statement = $pdo -> prepare($sql);
    try{
        $ret = $statement -> execute();
    }
	catch(Exception $e){
        echo "Error: ", $e -> getMessage();
    }

    echo "<table>\n";
    while($row = $statement -> fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['Name'];
        echo "</td></tr>\n";
    }

    echo "</table>\n"
?>
</div>

<div class='emails'>
<h2>Registered Emails</h2>
<?php
    include 'db.php';
    $sql = 'SELECT * FROM MyUser;';

    $statement = $pdo -> prepare($sql);
    try{
        $ret = $statement -> execute();
    }
	catch(Exception $e){
        echo "Error: ", $e -> getMessage();
    }

    echo "<table>\n";
    while($row = $statement -> fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['Email'];
        echo "</td></tr>\n";
    }

    echo "</table>\n"
?>
</div>

<div class='emailSubscriptions'>
<h2>Email Subscriptions</h2>
<?php
    include 'db.php';
    $sql = 'SELECT * FROM List_User INNER JOIN MyUser ON MyUser.Email = List_User.Email_id INNER JOIN List_name ON List_name.ID = List_User.List_id;';

    $statement = $pdo -> prepare($sql);
    try{
        $ret = $statement -> execute();
    }
	catch(Exception $e){
        echo "Error: ", $e -> getMessage();
    }

    echo "<table>\n";
    while($row = $statement -> fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['Email'],"</td><td>", $row['Name'];
        echo "</td></tr>\n";
    }

    echo "</table>\n"
?>
</div>

<div class='SMSSubscriptions'>
<h2>SMS Subscriptions</h2>
<?php
    include 'db.php';
    $sql = 'SELECT * FROM SMSList_User INNER JOIN SMSMyUser ON SMSMyUser.PhoneNumber = SMSList_User.PhoneNumber_id INNER JOIN SMSList_name ON SMSList_name.ID = SMSList_User.List_id;';

    $statement = $pdo -> prepare($sql);
    try{
        $ret = $statement -> execute();
    }
	catch(Exception $e){
        echo "Error: ", $e -> getMessage();
    }

    echo "<table>\n";
    while($row = $statement -> fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['PhoneNumber'],  "</td><td>", $row['Name'];
        echo "</td></tr>\n";
    }

    echo "</table>\n"
?>
</div>



<div class='phonenumbers'>
<h2>Phone Numbers</h2>
<?php
    include 'db.php';
    $sql = 'SELECT * FROM SMSMyUser;';

    $statement = $pdo -> prepare($sql);
    try{
        $ret = $statement -> execute();
    }
	catch(Exception $e){
        echo "Error: ", $e -> getMessage();
    }

    echo "<table>\n";
    while($row = $statement -> fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['PhoneNumber'];
        echo "</td></tr>\n";
    }

    echo "</table>\n"
?>
</div>

<div class='SMSLists'>
<h2>SMS Lists</h2>
<?php
    include 'db.php';
    $sql = 'SELECT * FROM SMSList_name;';

    $statement = $pdo -> prepare($sql);
    try{
        $ret = $statement -> execute();
    }
	catch(Exception $e){
        echo "Error: ", $e -> getMessage();
    }

    echo "<table>\n";
    while($row = $statement -> fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['Name'];
        echo "</td></tr>\n";
    }

    echo "</table>\n"
?>
</div>

<footer>
    <hr>
    <p><a href='index.php'>Home Page</a> | 
    <a href='emailListsAvailable.php'>Subscribe to or Unsubscribe from an Email List</a> | 
	<a href='smsListsAvailable.php'>Subscribe to or Unsubscribe from a SMS List</a> | 
	<a href='updateLists.php'>Add or Remove Email/SMS Lists</a></p>
</footer>
</body>
</html>