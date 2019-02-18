<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>CCC Return Product</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Return Product Procedure</h1>
        </div>
    </div>
    <br><br>
    <div class="row">
        <form class="form-inline" action="return.php" method="POST"  role="form">
            <div class="form-group">
                <label for="inputname">Enter the Client's name</label>
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
                //check if it is a company
                $getdebtsql="SELECT * FROM transactions WHERE clientAccountID='$caccountID[0]'";
                $result2=mysql_query($getdebtsql);
                if(mysql_num_rows($result2) == 0){
                    echo("<h3>Sorry! There are not any transactions with this client!</h3>");
                }
                else{
                    echo("<form class=\"form-inline\" action=\"return.php\" method=\"POST\"  role=\"form\">");
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
                            <td>Return</td>
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
            $type=$resulttable[5];

            //1. check type and change stuff
            if($type==1){
                /*
                 * It was a credit transaction. We dont change anything at dealers table, but we have to update client
                 * info
                 */
                $transinfosql="SELECT * FROM clients WHERE accountID='$clientID'";
                $resultquery=mysql_query($transinfosql);
                $resulttable=mysql_fetch_array($resultquery);
                $resulttable[3]=$resulttable[3]-$amount;    //debt
                $resulttable[4]=$resulttable[4]+$amount;    //creditlimit
                //Now we update these values!
                $updatedebtsql="UPDATE clients SET debt='$resulttable[3]'  WHERE accountID='$clientID'";
                $retval = mysql_query($updatedebtsql,$conect);
                if(!$retval )
                    die('Could not update data: ' . mysql_error());
                $updatelimitsql="UPDATE clients SET creditLimit='$resulttable[4]'  WHERE accountID='$clientID'";
                $retval = mysql_query($updatelimitsql,$conect);
                if(!$retval )
                    die('Could not update data: ' . mysql_error());
            }else{
                /*
                 * It was not a credit transaction. So we have to update dealers table too
                 */
                /*
                 * First lets see clients table
                 */
                $clientinfosql="SELECT availBalance FROM clients WHERE accountID='$clientID'";
                $resultquery=mysql_query($clientinfosql);
                $resulttable=mysql_fetch_array($resultquery);
                $resulttable[0]=$resulttable[0]+$amount;    //availBalance
                //Now we update these values!
                $updatebalancesql="UPDATE clients SET availBalance='$resulttable[0]'  WHERE accountID='$clientID'";
                $retval = mysql_query($updatebalancesql,$conect);
                if(!$retval )
                    die('Could not update data: ' . mysql_error());
                /*
                 * Now lets update dealers table. We have to update profit and debt
                 */
                $dealerinfosql="SELECT * FROM dealers WHERE accountID='$dealerID'";
                $resultquery=mysql_query($dealerinfosql);
                $resulttable=mysql_fetch_array($resultquery);
                $resulttable[3]=$resulttable[3]/100;
                $resulttable[1]=$resulttable[1]-($amount*$resulttable[3]);  //debt=debt-(amount*commission/100)
                $resulttable[2]=$resulttable[2]-$amount;                    //profit=profit-amount
                //Now we update dealers table
                $updatedebtsql="UPDATE dealers SET debt='$resulttable[1]'  WHERE accountID='$dealerID'";
                $retval = mysql_query($updatedebtsql,$conect);
                if(!$retval )
                    die('Could not update data: ' . mysql_error());
                $updateprofitsql="UPDATE dealers SET profit='$resulttable[2]'  WHERE accountID='$dealerID'";
                $retval = mysql_query($updateprofitsql,$conect);
                if(!$retval )
                    die('Could not update data: ' . mysql_error());
            }
            //2. delete transaction
            $deletefromtrans = "DELETE FROM transactions WHERE transID='$transID'";
            $result3 = mysql_query($deletefromtrans);
            if (!$result3)
                die('Error: Could not delete transaction from database: ' . mysql_error());
            echo("<h3>Success: Transaction deleted from database</h3><h4>Product returned successfully</h4>");

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
