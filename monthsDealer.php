<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>Dealer of the Month</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Dealer of the Month</h1>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <table class="table table-striped">
                <tr class="active">
                    <td>DealerName</td>
                    <td>AccountID</td>
                    <td>Debt</td>
                    <td>Profit</td>
                    <td>Commission</td>
                </tr>
                <?php

                include('connect.php');


                $sql = "SELECT dealerAccountID,COUNT(dealerAccountID) AS dealerAccountID_occ FROM transactions GROUP BY dealerAccountID  LIMIT 1";

                $resultTable = mysql_query($sql);

                $temp;

                if(mysql_num_rows($resultTable) > 0)
                {     while ($row = mysql_fetch_assoc($resultTable))
                {    $temp = $row["dealerAccountID"];
                    $dealersql = "SELECT * FROM dealers WHERE accountID = $temp ";
                    $dealerresult = mysql_query($dealersql);
                    $table = mysql_fetch_array($dealerresult);



                    $namesql = "SELECT username FROM users WHERE accountID = $temp ";
                    $nameresult = mysql_query($namesql);
                    $name = mysql_fetch_array($nameresult);



                    echo("<td>" . $name[0] . "</td>");
                    echo("<td>" . $row["dealerAccountID"] . "</td>");
                    echo("<td>" . $table["debt"] . "</td>");
                    echo("<td>" . $table["profit"] . "</td>");
                    echo("<td>" . $table["commission"] . "</td>");
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



                $commissionsql = " UPDATE  dealers SET  debt = (debt - (debt *0.05)) WHERE accountID = $temp";
                $commresult = mysql_query($commissionsql);










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