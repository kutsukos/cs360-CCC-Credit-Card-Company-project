<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>CCC Payoff Debts</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Payoff Debts Procedure</h1>
        </div>
    </div>
    <br><br>
    <div class="row">
        <form class="form-inline" action="payoff.php" method="POST"  role="form">
            <div class="form-group">
                <label for="inputname">Enter the Client or the Dealer's name</label>
                <input type="text" class="form-control" id="cname" name="cname" placeholder="Joe Doe" required>
            </div>
            <button type="submit" name="submit" id="submit" class="btn btn-danger">Validate</button>
        </form>
    </div>
    <br><br>
    <?php
    include('connect.php');
    if(isset( $_POST["submit"])) {
        $name=$_POST['cname'];                                                  //We have the name.
        //We search for ID, if exists
        $getidsql="SELECT accountID FROM users WHERE username='$name'";
        $result=mysql_query($getidsql);
        if(mysql_num_rows($result) == 0)                                     //There is nobody with this name
            echo("<h3>Error: There is not any client with this name!</h3>");
        else{
            $caccountID = mysql_fetch_array($result);                               //We have and the acountID

                /*
                 * We check now if the client is dealer
                 */
            $getdealersql="SELECT * FROM dealers WHERE accountID='$caccountID[0]'";
            $dealerresult=mysql_query($getdealersql);
            if(mysql_num_rows($dealerresult) == 0) {
                /*
                 * Its not a dealer
                 */
                $getdebtsql="SELECT * FROM transactions WHERE transType=1 AND clientAccountID='$caccountID[0]'";
                $result2=mysql_query($getdebtsql);
                if(mysql_num_rows($result2) == 0){
                    echo("<h3>Sorry! There are not any debts for this client!</h3>");
                }
                else{
                    echo("<form class=\"form-inline\" action=\"payoff.php\" method=\"POST\"  role=\"form\">");
                    echo("<div class=\"row\">
                            <div class=\"col-xl-12 col-md-12 col-xs-12\">
                            <table class=\"table table-striped\">
                            <tr class=\"active\">
                            <td>Transaction ID</td>
                            <td>DealerID</td>
                            <td>Date</td>
                            <td>Amount</td>
                            <td>Transaction Type</td>
                            <td>Corporate ClientID</td>
                            <td>Pay</td>
                        </tr>");

                    while ($row = mysql_fetch_assoc($result2))
                    {
                        echo("<tr>");
                        $type="payment";
                        if($row["transType"]==1){
                            $type="credit";
                        }
                        $IDD=$row["dealerAccountID"];
                        $transID=$row["transID"];
                        $getNamesql = "SELECT username FROM users WHERE accountID='$IDD'";
                        $nameresult=mysql_query($getNamesql);
                        $nametable=mysql_fetch_array($nameresult);

                        echo("<td>" . $row["transID"] . "</td>");
                        echo("<td>" . $nametable[0] . "</td>");
                        echo("<td>" . $row["date"] . "</td>");
                        echo("<td>" . $row["amount"] . "</td>");
                        echo("<td>" . $type . "</td>");
                        echo("<td>" . $row["corporateClientID"] . "</td>");
                        echo("<td><button class=\"btn btn-warning btn-block\" name=\"select\" value=". $transID .">select</button></td>");
                        echo("</tr>");

                    }
                    echo("</table>
                            </div>
                                </div>");
                    echo("</form>");
                }
            }else{
                /*
                 * Its a dealer
                 */
                $dealerinfo=mysql_fetch_array($dealerresult);

                if($dealerinfo[1] == 0){
                    echo("<h3>Sorry! There are not any debts for this dealer!</h3>");
                }
                else{
                    echo("<form class=\"form-inline\" action=\"payoff.php\" method=\"POST\"  role=\"form\">");
                    echo("<div class=\"row\">
                            <div class=\"col-xl-12 col-md-12 col-xs-12\">
                            <table class=\"table table-striped\">
                            <tr class=\"active\">
                            <td>Dealer Name</td>
                            <td>DealerID</td>
                            <td>Debt</td>
                            <td>Profit</td>
                            <td>Commission Percent</td>
                            <td>Pay</td>
                        </tr>");

                        echo("<tr>");
                        echo("<td>" . $name . "</td>");
                        echo("<td>" . $caccountID[0] . "</td>");
                        echo("<td>" . $dealerinfo[1] . "</td>");
                        echo("<td>" . $dealerinfo[2] . "</td>");
                        echo("<td>" . $dealerinfo[3] . "</td>");
                        echo("<td><button class=\"btn btn-warning btn-block\" name=\"selectdealer\" value=". $caccountID[0] .">select</button></td>");
                        echo("</tr>");

                    echo("</table>
                            </div>
                                </div>");
                    echo("</form>");
                }
            }
        }
    }
    ?>
    <?php
    include('connect.php');
    if(isset( $_POST["select"])) {
        $transID=$_REQUEST["select"];
        $transinfosql="SELECT * FROM transactions WHERE transID='$transID'";
        $resultquery=mysql_query($transinfosql);
        $resulttable=mysql_fetch_array($resultquery);

        $clientID=$resulttable[1];
        $dealerID=$resulttable[2];
        $amount=$resulttable[4];

        //1. check if the availbalance is ok.
        $clientinfosql="SELECT * FROM clients WHERE accountID='$clientID'";
        $resultquery=mysql_query($clientinfosql);
        $resulttable=mysql_fetch_array($resultquery);
        $availBalance=$resulttable[2];
        $clientdebt=$resulttable[3];
        $clientlimit=$resulttable[4];
        if($availBalance<$amount){                                              //cant pay the bill
            echo("<h3>Sorry! There are not money to pay the debt. Deal with it</h3>");
        }
        else{                                                                   //can pay the bill
            //2. pay dealer
            $dealerinfosql="SELECT * FROM dealers WHERE accountID='$dealerID'";
            $resultquery=mysql_query($dealerinfosql);
            $resulttable=mysql_fetch_array($resultquery);
            $dealerdebt=$resulttable[1];
            $dealerprofit=$resulttable[2];
            $dealerprofit=$dealerprofit+$amount;
            $commission=$resulttable[3];
            $dealerdebt=$dealerdebt+($amount*$commission/100);
            //time to update profit and debt
            $updateprofitsql="UPDATE dealers SET profit='$dealerprofit'  WHERE accountID='$dealerID'";
            $retval = mysql_query($updateprofitsql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());
            $updatedebtsql="UPDATE dealers SET debt='$dealerdebt'  WHERE accountID='$dealerID'";
            $retval = mysql_query($updatedebtsql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());


            //3. update values at clients table
            $availBalance=$availBalance-$amount;
            $clientdebt=$clientdebt-$amount;
            $clientlimit=$clientlimit+$amount;
            $updatebalancesql="UPDATE clients SET availBalance='$availBalance'  WHERE accountID='$clientID'";
            $retval = mysql_query($updatebalancesql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());
            $updatedebtsql="UPDATE clients SET debt='$clientdebt'  WHERE accountID='$clientID'";
            $retval = mysql_query($updatedebtsql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());
            $updatelimitsql="UPDATE clients SET creditLimit='$clientlimit'  WHERE accountID='$clientID'";
            $retval = mysql_query($updatelimitsql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());

            //4. update trans type from credit to payment
            $type=0;
            $transinfosql="UPDATE transactions SET transType='$type'  WHERE transID='$transID'";
            $retval = mysql_query($transinfosql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());
        }


    }

    if(isset( $_POST["selectdealer"])) {
        $dealerID=$_REQUEST["selectdealer"];
        $dealerinfosql="SELECT * FROM dealers WHERE accountID='$dealerID'";
        $resultquery=mysql_query($dealerinfosql);
        $resulttable=mysql_fetch_array($resultquery);

        $debt=$resulttable[1];
        $profit=$resulttable[2];
        //0. Check if profit > debt
        if($profit<$debt){
            echo("<h3>Sorry! There are not money to pay the debt. Deal with it</h3>");
        }else{
            $profit=$profit-$debt;
            $debt=0;
            //time to update profit and debt
            $updateprofitsql="UPDATE dealers SET profit='$profit'  WHERE accountID='$dealerID'";
            $retval = mysql_query($updateprofitsql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());
            $updatedebtsql="UPDATE dealers SET debt='$debt'  WHERE accountID='$dealerID'";
            $retval = mysql_query($updatedebtsql,$conect);
            if(!$retval )
                die('Could not update data: ' . mysql_error());
            echo("<h3>Success! Debts are paid. Database is updated</h3>");
        }
    }


    ?>
    <br><br>
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
</div>
</body>
</html>
