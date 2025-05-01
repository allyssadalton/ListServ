<!-- Allyssa Dalton
 March 3rd, 2025-->
 
 <html>
    <head>
        <title>Update Lists</title>
        <link rel = "stylesheet" href="commonstylesheet.css">
    </head>

    <body>
        <h1>Add or Remove Email/SMS Lists</h1>
        <div class='php'>
        <?php
            include 'db.php';
            //adds email list
            if (isset($_REQUEST['addEmailList'])){
                $checkSql = 'SELECT COUNT(*) FROM List_name WHERE Name = ?';
                $checkSqlStatement = $pdo -> prepare($checkSql);
                $checkSqlStatement -> bindValue(1, $_REQUEST['addEmailList']);
                $checkSqlStatement -> execute();
                $listExists = $checkSqlStatement -> fetchColumn();

                if ($listExists == 0){
                    $sql = 'INSERT INTO List_name(Name) VALUES(?)';
                    $sqlStatement = $pdo -> prepare($sql);
                    $sqlStatement -> bindValue(1, $_REQUEST['addEmailList']);

                    try{
                        $ret = $sqlStatement -> execute();
                        echo $_REQUEST['addEmailList'], " email list created \n";
                    }
                    catch(Exception $e){
                        echo "Error: ", $e -> getMessage();
                    }
                }
                else{
                    echo $_REQUEST['addEmailList'], " is already an email list \n";
                }
            }
            //removes email list
            if (isset($_REQUEST['removeEmailList'])){
                $checkSql = 'SELECT COUNT(*) FROM List_name WHERE Name = ?';
                $checkSqlStatement = $pdo -> prepare($checkSql);
                $checkSqlStatement -> bindValue(1, $_REQUEST['removeEmailList']);
                $checkSqlStatement -> execute();
                $listExists = $checkSqlStatement -> fetchColumn();

                if ($listExists > 0){
                    $sql = 'DELETE FROM List_name WHERE Name = ?';
                    $sqlStatement = $pdo -> prepare($sql);
                    $sqlStatement -> bindValue(1, $_REQUEST['removeEmailList']);

                    try{
                        $ret = $sqlStatement -> execute();
                        echo $_REQUEST['removeEmailList'], " email list removed \n";
                    }
                    catch(Exception $e){
                        echo "Error: ", $e -> getMessage();
                    }
                }
                else{echo $_REQUEST['removeEmailList'], " is not an email list \n";}
            
            
            }

            //adds sms list
            if (isset($_REQUEST['addSMSList'])){
                $checkSql = 'SELECT COUNT(*) FROM SMSList_name WHERE Name = ?';
                $checkSqlStatement = $pdo -> prepare($checkSql);
                $checkSqlStatement -> bindValue(1, $_REQUEST['addSMSList']);
                $checkSqlStatement -> execute();
                $listExists = $checkSqlStatement -> fetchColumn();

                if ($listExists == 0){
                    $sql = 'INSERT INTO SMSList_name(Name) VALUES(?)';
                    $sqlStatement = $pdo -> prepare($sql);
                    $sqlStatement -> bindValue(1, $_REQUEST['addSMSList']);

                    try{
                        $ret = $sqlStatement -> execute();
                        echo $_REQUEST['addSMSList'], " SMS list created \n";
                    }
                    catch(Exception $e){
                        echo "Error: ", $e -> getMessage();
                    }
                }
                else{
                    echo $_REQUEST['addSMSList'], " is already a SMS list \n";
                }
            }

            //removes sms list
            if (isset($_REQUEST['removeSMSList'])){
                $checkSql = 'SELECT COUNT(*) FROM SMSList_name WHERE Name = ?';
                $checkSqlStatement = $pdo -> prepare($checkSql);
                $checkSqlStatement -> bindValue(1, $_REQUEST['removeSMSList']);
                $checkSqlStatement -> execute();
                $listExists = $checkSqlStatement -> fetchColumn();

                if ($listExists > 0){
                    $sql = 'DELETE FROM SMSList_name WHERE Name = ?';
                    $sqlStatement = $pdo -> prepare($sql);
                    $sqlStatement -> bindValue(1, $_REQUEST['removeSMSList']);

                    try{
                        $ret = $sqlStatement -> execute();
                        echo $_REQUEST['removeSMSList'], " SMS list removed \n";
                    }
                    catch(Exception $e){
                        echo "Error: ", $e -> getMessage();
                    }
                }
                else{echo $_REQUEST['removeSMSList'], " is not a SMS list \n";}
            
            
            }
        ?>
        </div>
    <div class="changeEmailLists">
        <h2>Email Lists</h2>
        <div class="addlist">
            <form>
                Add Email List: <input type ="text" name="addEmailList" required>
                <input type="submit" value="Add List">
            </form>
        </div>
        <div class="removelist">
            <form>
                Remove Email List: <input type ="text" name="removeEmailList" required>
                <input type="submit" value="Remove List">
            </form>
        </div>
    </div>
    <br><br>
    <div class="changeSMSLists">
        <h2>SMS Lists</h2>
        <div class="addlist">
            <form>
                Add SMS List: <input type ="text" name="addSMSList" required>
                <input type="submit" value="Add List">
            </form>
        </div>
        <div class="removelist">
            <form>
                Remove SMS List: <input type ="text" name="removeSMSList" required>
                <input type="submit" value="Remove List">
            </form>
        </div>
    </div>
        <footer>
            <hr> 
            <p><a href='index.php'>Home Page</a> | 
            <a href='emailListsAvailable.php'>Subscribe to or Unsubscribe from an Email List</a> | 
            <a href='smsListsAvailable.php'>Subscribe to or Unsubscribe from a SMS List</a> | 
            <a href='lists.php'>View Email/SMS Lists & Their subscribers</a></p>
        </footer>
    </body>
</html>