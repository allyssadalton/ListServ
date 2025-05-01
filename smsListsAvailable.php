<!-- Allyssa Dalton
 March 3rd, 2025-->

<html>
<head>
	<title>SMS List</title>
    <link rel = "stylesheet" href="commonstylesheet.css">
</head>

<body>
    <h1>Subscribe to or Unsubscribe from a SMS List</h1>
    <?php
        include 'db.php';
        //checks if number is in SMSMyUser, adds it if not
        if (isset($_REQUEST['phonenumber'])){
            $checkSql = "SELECT COUNT(*) FROM SMSMyUser WHERE PhoneNumber = ?";
            $checkSqlStatement = $pdo -> prepare($checkSql);
            $checkSqlStatement -> bindValue(1, $_REQUEST['phonenumber']);
            $checkSqlStatement -> execute();
            $phoneExists = $checkSqlStatement -> fetchColumn();

            if ($phoneExists == 0){
                $sql = "INSERT INTO SMSMyUser(PhoneNumber) VALUES (?)";
                $sqlStatement = $pdo -> prepare($sql);
                $sqlStatement -> bindValue(1, $_REQUEST['phonenumber']);
                try{$ret = $sqlStatement -> execute();}
                catch(Exception $e){echo "Error: ", $e -> getMessage();}
            }
        }
        
        //checks if list exists
        if (isset($_REQUEST['list_name'])){
            $checkSql = "SELECT COUNT(*) FROM SMSList_name WHERE Name = ?";
            $checkSqlStatement = $pdo -> prepare($checkSql);
            $checkSqlStatement -> bindValue(1, $_REQUEST['list_name']);
            $checkSqlStatement -> execute();
            $listExists = $checkSqlStatement -> fetchColumn();

            if ($listExists == 0){echo $_REQUEST['list_name'], " doesn't exist.";}

            else{
                //checks if the combo already exists
                $checkSql = "SELECT COUNT(*) FROM SMSList_User WHERE PhoneNumber_id = ? AND List_id = (SELECT ID FROM SMSList_name WHERE Name = ?)";
                $checkSqlStatement = $pdo -> prepare($checkSql);
                $checkSqlStatement -> bindValue(1, $_REQUEST['phonenumber']);
                $checkSqlStatement -> bindValue(2, $_REQUEST['list_name']);
                $checkSqlStatement -> execute();
                $combinationExists = $checkSqlStatement -> fetchColumn();

                if ($combinationExists == 0){
                    $sql = "INSERT INTO SMSList_User(PhoneNumber_id, List_id) VALUES (?, (SELECT ID FROM SMSList_name WHERE Name = ?))";
                    $sqlStatement = $pdo -> prepare($sql);
                    $sqlStatement -> bindValue(1, $_REQUEST['phonenumber']);
                    $sqlStatement -> bindValue(2, $_REQUEST['list_name']);
                    
                    try{
                        $ret = $sqlStatement -> execute();
                        echo $_REQUEST['phonenumber'], " subscribed to list ", $_REQUEST['list_name'];
                    }
                    catch(Exception $e){echo "Error: ", $e -> getMessage();}
                }

                else{
                    echo $_REQUEST['phonenumber'], " is already subscribed to ", $_REQUEST['list_name'];
                }
            }
        }

        if (isset($_REQUEST['remove_phonenumber'], $_REQUEST['removelist_name'])){
            $checkSql = "SELECT COUNT(*) FROM SMSList_User WHERE PhoneNumber_id = ? AND List_id = (SELECT ID FROM SMSList_name WHERE Name = ?)";
            $checkSqlStatement = $pdo -> prepare($checkSql);
            $checkSqlStatement -> bindValue(1, $_REQUEST['remove_phonenumber']);
            $checkSqlStatement -> bindValue(2, $_REQUEST['removelist_name']);
            $checkSqlStatement -> execute();
            $combinationExists = $checkSqlStatement -> fetchColumn();

            if ($combinationExists == 0){echo  $_REQUEST['remove_phonenumber'], " isn't subscribed to ", $_REQUEST['removelist_name'], ".";}
            
            else{
                $sql = "DELETE FROM SMSList_User WHERE PhoneNumber_id = ? AND List_id = (SELECT ID FROM SMSList_name WHERE Name = ?)";
                $sqlStatement = $pdo -> prepare($sql);
                $sqlStatement -> bindValue(1, $_REQUEST['remove_phonenumber']);
                $sqlStatement -> bindValue(2, $_REQUEST['removelist_name']);
                try{
                    $ret = $sqlStatement -> execute();
                    echo $_REQUEST['remove_phonenumber'], " is now unsubscribed from ", $_REQUEST['removelist_name'], ".";
                }
                catch(Exception $e){echo "Error: ", $e -> getMessage();}
            }

        }


    ?>

<div class="subscribeForm">
    <h3>Subscribe to New List</h3>
    <form>
        Phone Number: <input type ="text" name="phonenumber" required>
        List: <input type ="text" name="list_name" required>
        <input type="submit" value="Add phone to list">
    </form>
</div>

<div class="unsubscribeForm">
    <h3>Unsubscribe from a List</h3>
    <form>
        Phone Number: <input type ="text" name="remove_phonenumber" required>
        List: <input type ="text" name="removelist_name" required>
        <input type="submit" value="Remove phone from list">
    </form>
</div>
<footer>
    <hr>
    <p><a href='index.php'>Home Page</a> | 
    <a href='emailListsAvailable.php'>Subscribe to or Unsubscribe from an Email List</a> | 
	<a href='lists.php'>View Email/SMS Lists & Their subscribers</a> | 
	<a href='updateLists.php'>Add or Remove Email/SMS Lists</a></p>
</footer>
</body>
</html>