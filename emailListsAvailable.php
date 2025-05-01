<!-- Allyssa Dalton
 March 3rd, 2025-->
 
<html>
<head>
	<title> Email Lists</title>
    <link rel = "stylesheet" href="commonstylesheet.css">
</head>


<body>
    <h1>Subscribe to or Unsubscribe from an Email List</h1>
    <div class='php'>
    <?php
        include 'db.php';
        // checks if email is in myUser, if not it adds it
        if(isset($_REQUEST['email'])){
            $checkSql = "SELECT COUNT(*) FROM MyUser WHERE Email = ?"; 
            $checkStatement = $pdo -> prepare($checkSql);
            $checkStatement -> bindValue(1, $_REQUEST['email']);
            $checkStatement -> execute();
            $emailExists = $checkStatement -> fetchColumn(); //shoutout to ChatGPT for this line
            
            if ($emailExists == 0){
                $sql = "INSERT INTO MyUser(Email) VALUES (?);";
                $sqlStatement = $pdo -> prepare($sql);
                $sqlStatement -> bindValue(1, $_REQUEST['email']);
                try {$ret = $sqlStatement -> execute();}
                catch(Exception $e){echo "Error: ", $e -> getMessage();}
            }
        }

        if(isset($_REQUEST['list_name'])){
            $checkSql = "SELECT COUNT(*) FROM List_name WHERE Name = ?"; 
            $checkStatement = $pdo -> prepare($checkSql);
            $checkStatement -> bindValue(1, $_REQUEST['list_name']);
            $checkStatement -> execute();
            $listExists = $checkStatement -> fetchColumn(); //shoutout to ChatGPT for this line
            
            if ($listExists == 0){
                echo $_REQUEST['list_name'], " doesn't exist.";
            }
            //subscribes email to list
            else{
                 // checks if email and list name combo exists and subscribes email to list if it doesn't
                if(isset($_REQUEST['email'], $_REQUEST['list_name'])){
                    $checkSql = "SELECT COUNT(*) FROM List_User WHERE Email_id = ? AND List_id = (SELECT ID FROM List_name WHERE Name = ?)"; 
                    $checkStatement = $pdo -> prepare($checkSql);
                    $checkStatement -> bindValue(1, $_REQUEST['email']);
                    $checkStatement -> bindValue(2, $_REQUEST['list_name']);
                    $checkStatement -> execute();
                    $combinationExists = $checkStatement -> fetchColumn();

                    if ($combinationExists == 0){
                        $addEmailtoList = "INSERT INTO List_User(Email_id, List_id) VALUES (?, (SELECT ID FROM List_name WHERE Name = ?))";
                        $addEmailtoListStatement = $pdo -> prepare($addEmailtoList);
                        $addEmailtoListStatement -> bindValue(1, $_REQUEST['email']);
                        $addEmailtoListStatement -> bindValue(2, $_REQUEST['list_name']);

                        try{
                            $ret = $addEmailtoListStatement -> execute();
                            echo $_REQUEST['email'], " added to ", $_REQUEST['list_name'];
                        }
                        catch(Exception $e){echo "Error: ", $e -> getMessage();}
                    }

                    else{
                        echo $_REQUEST['email'], " is already subscribed to ",  $_REQUEST['list_name'], ".";
                    }
                }
            }
        }
        //removes email from list
        if(isset($_REQUEST['remove_email'], $_REQUEST['removelist_name'])){
            $checkSql = "SELECT COUNT(*) FROM List_User WHERE Email_id = ? AND List_id = (SELECT ID FROM List_name WHERE Name = ?)";
            $checkSqlStatement = $pdo -> prepare($checkSql);
            $checkSqlStatement -> bindValue(1, $_REQUEST['remove_email']);
            $checkSqlStatement -> bindValue(2, $_REQUEST['removelist_name']);
            $checkSqlStatement -> execute();
            $combinationExists = $checkSqlStatement -> fetchColumn();

            if ($combinationExists == 0){echo  $_REQUEST['remove_email'], " isn't subscribed to ", $_REQUEST['removelist_name'], ".";}
            
            else{
                $sql = "DELETE FROM List_User WHERE Email_id = ? AND List_id = (SELECT ID FROM List_name WHERE Name = ?)";
                $sqlStatement = $pdo -> prepare($sql);
                $sqlStatement -> bindValue(1, $_REQUEST['remove_email']);
                $sqlStatement -> bindValue(2, $_REQUEST['removelist_name']);
                try{
                    $ret = $sqlStatement -> execute();
                    echo $_REQUEST['remove_email'], " is now unsubscribed from ", $_REQUEST['removelist_name'], ".";
                }
                catch(Exception $e){echo "Error: ", $e -> getMessage();}
            }
        }
    ?>
    </div>

<div class="subscribeForm">
    <h3>Subscribe to New List</h3>
    <form>
        Email: <input type ="text" name="email" required>
        List: <input type ="text" name="list_name" required>
        <input type="submit" value="Add email to list">
    </form>
</div>

<div class="unsubscribeForm">
    <h3>Unsubscribe from a List</h3>
    <form>
        Email: <input type ="text" name="remove_email" required>
        List: <input type ="text" name="removelist_name" required>
        <input type="submit" value="Remove email from list">
    </form>
</div>
<footer>
    <hr>
	<p><a href='index.php'>Home Page</a> | 
    <a href='smsListsAvailable.php'>Subscribe to or Unsubscribe from a SMS List</a> | 
	<a href='lists.php'>View Email/SMS Lists & Their subscribers</a> | 
	<a href='updateLists.php'>Add or Remove Email/SMS Lists</a></p>
</footer>
</body>
</html>