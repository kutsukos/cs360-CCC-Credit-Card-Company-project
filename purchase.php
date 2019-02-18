<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>CCC Purchase</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Purchase Procedure</h1>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <form class="form-inline" action="purchase.php" method="POST"  role="form">
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-xs-3">
                        <div class="form-group">
                                <label for="client">Client Name</label>
                                <input type="text" class="form-control" id="clientname" name="clientname" placeholder="Joe Doe" required >
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="dealer">Dealer Name</label>
                            <input type="text" class="form-control" id="dealername" name="dealername" placeholder="Joe Doe" required >
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" min="<?php $today = date("Y-m-d"); echo($today); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="dealer">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="$$$$$" required >
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="dealer">Credit Transaction</label>
                            <input type="checkbox" id="creditcheck" name="creditcheck" aria-label="...">
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="dealer">Corporate Transaction</label>
                            <input type="checkbox" id="corpocheck" name="corpocheck" aria-label="...">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-xs-6">
                        <div class="form-group">
                            <label for="dealer">Corporate ID</label>
                            <input type="text" class="form-control" id="corpoID" name="corpoID" placeholder="12345">
                        </div>
                    </div>
                </div>

                <br><br><br>

                <div class="row">
                    <div class="col-xl-3 col-md-3 col-xs-3">
                        <button type="submit" name="submit" id="submit" class="btn btn-md btn-success btn-block">
                            <h4>
                                <span class=" glyphicon glyphicon-ok" aria-hidden="true"></span>
                                PURCHASE!
                            </h4>

                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-3 col-xs-3">
            <a href="index.php">
                <button class="btn btn-md btn-primary btn-block"  id="home" >
                    <h4>
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                        Home
                    </h4>
                </button>
            </a>
        </div>
    </div>
    <?php
        include('connect.php');
        if(isset( $_POST["submit"])) {
            $clientname=$_REQUEST['clientname'];
            $dealername=$_REQUEST['dealername'];
            $amount=$_REQUEST['amount'];
            $date=$_REQUEST['date'];
            $corpoID=$_REQUEST['corpoID'];
            $type=0;

            if($_REQUEST['creditcheck'] != null){                                   //so it is a credit transaction
                $type=1;
                     /*
                     * Note! We dont update dealers money yet. We wait for client to payoff its debts!!!!
                     */
                if($_REQUEST['corpocheck'] != null){                                   //so it is a CORPO transaction
                    //CHECK IF CorpoID is entered
                    if($_REQUEST['corpoID'] == null){
                        echo("Please enter Corporate client ID");
                    }else{
                        /*
                         * EDW KANW CREDIT TRANS ME CORPO CLIENT
                         */

                        //1.Find accountID for Stevens company and Barbastathis
                        $getidsql="SELECT accountID FROM users WHERE username='$dealername'";
                        $result=mysql_query($getidsql);
                        if(mysql_num_rows($result) == 0)
                            die('Could not find dealer' . mysql_error());
                        $barbaID = mysql_fetch_array($result);
                        //Now I have dealer's accountID at resultTable[0]

                        $getallfromcorposql="SELECT * FROM corporate_clients WHERE IDNum='$corpoID'";
                        $result=mysql_query($getallfromcorposql);
                        if(mysql_num_rows($result) == 0)
                            die('Could not find client' . mysql_error());
                        $stevensinfo = mysql_fetch_array($result);
                        //Now I have client's accountID at resultTable[0]

                        /*
                         * Check point for data
                         * $barbaID[0] <- dealer ID
                         * $stevensinfo <- all client's info from corporate users
                         */



                        //2. Now we will have to check if client is able to buy. We check creditLimit cause he is gonna credit  it
                        $getidsql="SELECT * FROM clients WHERE accountID='$stevensinfo[0]' AND expDate>=CURDATE()"; //client's company
                        $result=mysql_query($getidsql);
                        if(mysql_num_rows($result) == 0)
                            die('Cant find find client or this account is expired');
                        $stevenscompanyinfo = mysql_fetch_array($result);
                        //Now I have client's company's creditLimit at $stevenscompanyinfo[4]
                        if($stevenscompanyinfo[4]<$amount)
                            die('Cant buy. Does not have money');


                        //3. Else client can buy
                        // We are ready to create a transaction Now Type is 1. It is a credit trans.
                        $inserttranssql="INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
                                    VALUE($stevensinfo[0],$barbaID[0],'".$date."',$amount,$type,$stevensinfo[2])";
                        $retval = mysql_query($inserttranssql,$conect);
                        if(!$retval)
                            die('Could not enter data. ' . mysql_error());

                        /*
                         * Check point for data
                         * $barbaID[0] <- Barbastathis ID
                         * $stevensinfo <- all steven's info from corporate users
                         * $stevenscompanyinfo <- all steven's company info from clients ;)
                         */
                        //4. Now that this transaction is credit, we dont really move money from client to dealer until client pay his credit transactions
                        //Time to update creditLimit and debt
                        //We need some info first.
                        $stevenscompanyinfo[3]=$stevenscompanyinfo[3]+$amount;  //updating debt value
                        $stevenscompanyinfo[4]=$stevenscompanyinfo[4]-$amount;  //updating creditLimit value

                        //Now we update this two values on Mark's row
                        $updatedebtsql="UPDATE clients SET debt='$stevenscompanyinfo[3]'  WHERE accountID='$stevenscompanyinfo[0]'";
                        $retval = mysql_query($updatedebtsql,$conect);
                        if(!$retval)
                            die('Could not update data. ' . mysql_error());

                        $updatelimitsql="UPDATE clients SET creditLimit='$stevenscompanyinfo[4]'  WHERE accountID='$stevenscompanyinfo[0]'";
                        $retval = mysql_query($updatelimitsql,$conect);
                        if(!$retval)
                            die('Could not update data. ' . mysql_error());

                    }

                }else{                                                                  //it is NOT a CORPO transaction
                        /*
                         * EDW KANW CREDIT TRANS OXI SE CORPOCLIENT
                         */

                    //1.Find accountID for client and dealer
                    $getidsql="SELECT accountID FROM users WHERE username='$dealername'";
                    $result=mysql_query($getidsql);
                    if(mysql_num_rows($result) == 0)
                        die('Could not find dealer. ' . mysql_error());
                    $barba = mysql_fetch_array($result);
                    //Now I have dealer's accountID at $barba[0]

                    $getidsql="SELECT accountID FROM users WHERE username='$clientname'";
                    $result=mysql_query($getidsql);
                    if(mysql_num_rows($result) == 0)
                        die('Could not find client. ' . mysql_error());
                    $mark = mysql_fetch_array($result);
                    //Now I have client's accountID at $mark[0]



                    //2. Now we will have to check if client is able to buy. We check creditLimit cause he is gonna credit  it
                    $getidsql="SELECT * FROM clients WHERE accountID='$mark[0]' AND expDate>=CURDATE()";
                    $result=mysql_query($getidsql);
                    if(mysql_num_rows($result) == 0)
                        die('Cant find find client or this account is expired');
                    $markTable = mysql_fetch_array($result);
                    /*
                     * $markTable[3] -> debt
                     * $markTable[4] -> creditLimit
                     */
                    if($markTable[4]<$amount)
                        die('Cant buy. Does not have money');


                    //3. Else client can buy
                    // We are ready to create a transaction Now Type is 1. It is a credit trans.
                    $inserttranssql="INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
                            VALUE($mark[0],$barba[0],'".$date."',$amount,$type,0)";
                    $retval = mysql_query($inserttranssql,$conect);
                    if(!$retval)
                        die('Could not enter data. ' . mysql_error());


                    //4. Now that this transaction is credit, we dont really move money from client to dealer until client pay his credit transactions
                    //Time to update creditLimit and debt
                    /*
                     * $markTable[3] -> debt
                     * $markTable[4] -> creditLimit
                     */
                    $markTable[4]=$markTable[4]-$amount;
                    $markTable[3]=$markTable[3]+$amount;

                    //Now we update this two values on Mark's row
                    $updatedebtsql="UPDATE clients SET debt='$markTable[3]'  WHERE accountID='$mark[0]'";
                    $retval = mysql_query($updatedebtsql,$conect);
                    if(!$retval)
                        die('Could not update data. ' . mysql_error());

                    $updatelimitsql="UPDATE clients SET creditLimit='$markTable[4]'  WHERE accountID='$mark[0]'";
                    $retval = mysql_query($updatelimitsql,$conect);
                    if(!$retval)
                        die('Could not update data. ' . mysql_error());

                    /*
                     * Done! We dont update dealers money yet. We wait for client to payoff its debts!
                     */
                }
            }else{                                                                  //it is NOT a credit transaction
                if($_REQUEST['corpocheck'] != null){                                   //so it is a CORPO transaction
                    //CHECK IF CorpoID is entered
                    if($_REQUEST['corpoID'] == null){
                        echo("Please enter Corporate client ID");
                    }else{
                        /*
                         * EDW DEN EINAI CREDIT ALLA EINAI CORPO
                         */

                        //1.Find accountID for corporate client and dealer
                        $getidsql="SELECT accountID FROM users WHERE username='$dealername'";
                        $result=mysql_query($getidsql);
                        if(mysql_num_rows($result) == 0)
                            die('Could not find dealer. ' . mysql_error());
                        $barbaID = mysql_fetch_array($result);
                        //Now I have dealer's accountID at resultTable[0]

                        $getallfromcorposql="SELECT * FROM corporate_clients WHERE IDNum='$corpoID'";
                        $result=mysql_query($getallfromcorposql);
                        if(mysql_num_rows($result) == 0)
                            die('Could not find Client. ' . mysql_error());
                        $stevensinfo = mysql_fetch_array($result);
                        //Now I have clients's accountID at resultTable[0]

                        /*
                         * Check point for data
                         * $barbaID[0] <- Dealer ID
                         * $stevensinfo <- all client's info from corporate users
                         */

                        //2. Now we will have to check if client is able to buy. We check AvalBalance cause he is gonna buy it
                        $getidsql="SELECT * FROM clients WHERE accountID='$stevensinfo[0]' AND expDate>=CURDATE()"; //Steven's company
                        $result=mysql_query($getidsql);
                        if(mysql_num_rows($result) == 0)
                            die('Cant find find client or this account is expired');
                        $stevenscompanyinfo = mysql_fetch_array($result);
                        //Now I have steven's company's avalBalance at $stevenscompanyinfo[2]
                        if($stevenscompanyinfo[2]<$amount)
                            die('Cant buy. Does not have money');

                        /*
                         * Check point for data
                         * $barbaID[0] <- Barbastathis ID
                         * $stevensinfo <- all steven's info from corporate users
                         * $stevenscompanyinfo <- all steven's company info from clients ;)
                         */
                        //3. Now We are ready to create a transaction
                        $inserttranssql="INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
                                            VALUE($stevensinfo[0],$barbaID[0],'".$date."',$amount,$type,$stevensinfo[2])";
                        $retval = mysql_query($inserttranssql,$conect);
                        if(!$retval)
                            die('Could not enter data: ' . mysql_error());


                        /*
                         * Check point for data
                         * $barbaID[0] <- Barbastathis ID
                         * $stevensinfo <- all steven's info from corporate users
                         * $stevenscompanyinfo <- all steven's company info from clients ;)
                         */
                        //4. Now that the transaction is created. Time to update user's data.
                        //First lets remove money from client
                        $stevenscompanyinfo[2]=$stevenscompanyinfo[2]-$amount;
                        $updateavailbalancesql="UPDATE clients SET availBalance='$stevenscompanyinfo[2]'  WHERE accountID='$stevensinfo[0]'";
                        $retval = mysql_query($updateavailbalancesql,$conect);
                        if(!$retval)
                            die('Could not update data. ' . mysql_error());

                        //Now lets add money to dealer's profit and update debt values
                        //We need some info first. Like dealers profit, debt, commission -
                        $getidsql="SELECT * FROM dealers WHERE accountID='$barbaID[0]'";
                        $result=mysql_query($getidsql);
                        if(mysql_num_rows($result) == 0)
                            die('Could not find Barbastathis. ' . mysql_error());
                        $barbastathisTable = mysql_fetch_array($result);
                        /*
                         * Now I have barbastathis info at
                         * profit - $barbastathisTable[2]
                         * debt - $barbastathisTable[1]
                         * commission - $barbastathisTable[3]
                         */
                        $barbastathisTable[2]=$barbastathisTable[2]+$amount;     //profit
                        $barbastathisTable[3]=$barbastathisTable[3]/100;    //commission
                        $barbastathisTable[1]=$barbastathisTable[1]+($amount*$barbastathisTable[3]);  //new debt
                        //update profit first
                        $updatedealerssql="UPDATE dealers SET profit='$barbastathisTable[2]'  WHERE accountID='$barbastathisTable[0]'";
                        $retval = mysql_query($updatedealerssql,$conect);
                        if(!$retval)
                            die('Could not update profit dealer. ' . mysql_error());

                        $updatedealerssql="UPDATE dealers SET debt='$barbastathisTable[1]'  WHERE accountID='$barbastathisTable[0]'";
                        $retval = mysql_query($updatedealerssql,$conect);
                        if(!$retval)
                            die('Could not update dept dealer. ' . mysql_error());
                        //DONE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                        //FINALLY!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                        //NUMBERS ARE CHECKED + WHEN CLIENT DOES NOT HAVE MONEY SITUATION!!!!
                    }
                }else{                                                                  //it is NOT a CORPO transaction
                        /*
                         * EDW DEN EINAI CREDIT KAI DEN EINAI CORPO
                         */

                    //Firstly lets say Mark is about to buy from Barbastathis something which cost 10$ and Mark is gonna pay
                    //1.Find accountIDs
                    $getidsql="SELECT accountID FROM users WHERE username='$dealername'";
                    $result=mysql_query($getidsql);
                    if(mysql_num_rows($result) == 0)
                        die('Could not find dealers. ' . mysql_error());
                    $resultTable = mysql_fetch_array($result);
                    //Now I have dealers's accountID at resultTable[0]

                    $getidsql="SELECT accountID FROM users WHERE username='$clientname'";
                    $result=mysql_query($getidsql);
                    if(mysql_num_rows($result) == 0)
                        die('Could not find client. ' . mysql_error());
                    $resultTable2 = mysql_fetch_array($result);
                    //Now I have clients's accountID at resultTable[0]

                    //2. Now we will have to check if client is able to buy. We check AvalBalance cause he is gonna buy it
                    $getidsql="SELECT availBalance FROM clients WHERE accountID='$resultTable2[0]' AND expDate>=CURDATE()";
                    $result=mysql_query($getidsql);
                    if(mysql_num_rows($result) == 0)
                        die('Cant find find client or this account is expired');
                    $resultTable3 = mysql_fetch_array($result);
                    //Now I have Mark's avalBalance at resultTable3[0]
                    if($resultTable3[0]<$amount) {
                        echo('Error: Client cant buy. Does not have money');
                    }else {         //Client have money to payoff this transaction

                        //3. We are ready to create a transaction
                        $inserttranssql = "INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
                                            VALUE($resultTable2[0],$resultTable[0],'".$date."',$amount,$type,0)";
                        $retval = mysql_query($inserttranssql, $conect);
                        if(!$retval)
                            die('Could not enter data. ' . mysql_error());

                        //4. Now that the transaction is created. Time to update user's data.
                        //Reminder: We have $resultTable2[0] - Client, $resultTable[0] - Dealer, $resultTable3[0] - AvailBalance
                        //First lets remove money from client
                        $resultTable3[0] = $resultTable3[0] - $amount;
                        $updateavailbalancesql = "UPDATE clients SET availBalance='$resultTable3[0]'  WHERE accountID='$resultTable2[0]'";
                        $retval = mysql_query($updateavailbalancesql, $conect);
                        if(!$retval)
                            die('Could not update data. ' . mysql_error());

                        //Now lets add money to dealer's profit and update debt values
                        //We need some info first. Like dealers profit, debt, commission -
                        $getidsql = "SELECT * FROM dealers WHERE accountID='$resultTable[0]'";
                        $result = mysql_query($getidsql);
                        if(mysql_num_rows($result) == 0)
                            die('Could not find dealer. ' . mysql_error());
                        $barbastathisTable = mysql_fetch_array($result);
                        /*
                         * Now I have dealers info at
                         * profit - $barbastathisTable[2]
                         * debt - $barbastathisTable[1]
                         * commission - $barbastathisTable[3]
                         */
                        $barbastathisTable[2] = $barbastathisTable[2] + $amount;     //profit
                        $barbastathisTable[3] = $barbastathisTable[3] / 100;    //commission
                        $barbastathisTable[1] = $barbastathisTable[1] + ($amount * $barbastathisTable[3]);  //new debt
                        //update profit first
                        $updatedealerssql = "UPDATE dealers SET profit='$barbastathisTable[2]'  WHERE accountID='$resultTable[0]'";
                        $retval = mysql_query($updatedealerssql, $conect);
                        if(!$retval)
                            die('Could not update profit dealer. ' . mysql_error());

                        $updatedealerssql = "UPDATE dealers SET debt='$barbastathisTable[1]'  WHERE accountID='$resultTable[0]'";
                        $retval = mysql_query($updatedealerssql, $conect);
                        if (!$retval)
                            die('Could not update dept dealer: ' . mysql_error());
                    }
                }
            }
        }
    ?>

</div>
</body>
</html>
