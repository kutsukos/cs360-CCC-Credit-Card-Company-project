<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>State of Good Clients</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>State of Good Clients</h1>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <table class="table table-striped">
                <tr class="active">
                    <td>AccountID</td>
                    <td>Name</td>
                    <td>ExpDate</td>
                    <td>Available Balance</td>
                    <td>Credit Limit</td>
                </tr>
                <?php

                include('connect.php');


                $getIDsql = "SELECT * FROM clients WHERE debt = 0";
                $resultTable = mysql_query($getIDsql);

                if(mysql_num_rows($resultTable) > 0) {
                    while ($row = mysql_fetch_assoc($resultTable))
                    {
                        echo("<tr>");
                        $IDD=$row["accountID"];
                        $getNamesql = "SELECT username FROM users  WHERE accountID='$IDD'";
                        $nameresult=mysql_query($getNamesql);
                        $nametable=mysql_fetch_array($nameresult);
                        echo("<td>" . $row["accountID"] . "</td>");
                        echo("<td>" . $nametable[0] . "</td>");
                        echo("<td>" . $row["expDate"] . "</td>");
                        echo("<td>" . $row["availBalance"] . "</td>");
                        echo("<td>" . $row["creditLimit"] . "</td>");
                        echo("</tr>");
                    }
                }else
                {
                    echo("<tr>");
                    echo("<td>0 results</td>");
                    echo("<td>0 results</td>");
                    echo("<td>0 results</td>");
                    echo("<td>0 results</td>");
                    echo("<td>0 results</td>");
                    echo("</tr>");
                }

                ?>

            </table>
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
</div>
</body>