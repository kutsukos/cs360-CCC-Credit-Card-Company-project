<?php
include('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>Questions</title>

</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Questions</h1>
        </div>
    </div>
    <div class="row">
        <form action="questions.php" method="POST" class="form-horizontal my-form" role="form">

            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">Account id</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="AccountID" placeholder="AccountID">
                </div><!-- /col-sm-9 -->
            </div><!-- /form-group -->



            <div class="form-group">
                <label class="col-sm-3 control-label">From Date</label>
                <div class="col-sm-3">
                    <input type="date" name="FromDate" min="1900-01-01">
                </div><!-- /col-sm-9 -->
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label">To</label>
                <div class="col-sm-3">
                    <input type="date" name="ToDate" min="1900-01-01">
                </div><!-- /col-sm-9 -->
            </div>
            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">I am a corporation</label>
                <div class="col-sm-3">
                    <input type="checkbox" name="isCorpClient" value="1">
                </div>
            </div>

            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">CorpClientID</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="corpClientID" placeholder="CorpClientID">
                </div><!-- /col-sm-9 -->
            </div><!-- /form-group -->

            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">Check all CorpClientsID </label>
                <div class="col-sm-3">
                    <input type="checkbox" name="allCorpClientID" value="1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">Check trancsactions lower by amount</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="Amount" placeholder="Amount">
                </div><!-- /col-sm-9 -->
            </div><!-- /form-group -->

            <div class="row">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <table class="table table-striped">
                        <tr class="active">
                            <td>TransactionID</td>
                            <td>ClientID</td>
                            <td>DealerID</td>
                            <td>Date</td>
                            <td>Amount</td>
                            <td>TransactionType</td>
                            <td>CorpclientID</td>
                        </tr>
                        <?php
                        include('connect.php');
                        if(isset( $_POST['Go1'])) {
                            //first check for inputs


                            if ($_REQUEST['isCorpClient'] != null && $_REQUEST['corpClientID'] == '' && $_REQUEST['allCorpClientID'] == null) {
                                echo('Please enter data');
                            } else if ($_REQUEST['isCorpClient'] != null && $_REQUEST['corpClientID'] != '' && $_REQUEST['allCorpClientID'] == null) {     //The user is  corporate
                                if ($_REQUEST['AccountID'] == '' && $_REQUEST['FromDate'] == '' && $_REQUEST['ToDate'] == '')
                                    echo('Please enter data');

                                $AccountID = $_REQUEST['AccountID'];
                                $FromDate = $_REQUEST['FromDate'];
                                $ToDate = $_REQUEST['ToDate'];
                                $amountfromuser = $_REQUEST['Amount'];
                                $CorpClientID = $_REQUEST['corpClientID'];
                                if ($_REQUEST['Amount'] == '') {
                                    $corsql = "SELECT * FROM transactions WHERE corporateClientID = $CorpClientID AND (date>'$FromDate' AND date<'$ToDate')";
                                    $cor = mysql_query($corsql);

                                    if (mysql_num_rows($cor) != 0) {
                                        while ($row = mysql_fetch_assoc($cor)) {
                                            echo("<tr>");
                                            echo("<td>" . $row["transID"] . "</td>");
                                            echo("<td>" . $row["clientAccountID"] . "</td>");
                                            echo("<td>" . $row["dealerAccountID"] . "</td>");
                                            echo("<td>" . $row["date"] . "</td>");
                                            echo("<td>" . $row["amount"] . "</td>");
                                            echo("<td>" . $row["transType"] . "</td>");
                                            echo("<td>" . $row["corporateClientID"] . "</td>");
                                            echo("</tr>");


                                        }
                                    } else {
                                        echo("<tr>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("</tr>");
                                    }
                                } else {
                                    $corsql = "SELECT * FROM transactions WHERE corporateClientID = $CorpClientID AND (date>'$FromDate' AND date<'$ToDate') AND amount < $amountfromuser";
                                    $cor = mysql_query($corsql);

                                    if (mysql_num_rows($cor) != 0) {
                                        while ($row = mysql_fetch_assoc($cor)) {
                                            echo("<tr>");
                                            echo("<td>" . $row["transID"] . "</td>");
                                            echo("<td>" . $row["clientAccountID"] . "</td>");
                                            echo("<td>" . $row["dealerAccountID"] . "</td>");
                                            echo("<td>" . $row["date"] . "</td>");
                                            echo("<td>" . $row["amount"] . "</td>");
                                            echo("<td>" . $row["transType"] . "</td>");
                                            echo("<td>" . $row["corporateClientID"] . "</td>");
                                            echo("</tr>");


                                        }
                                    } else {
                                        echo("<tr>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("</tr>");
                                    }

                                }
                            } else if ($_REQUEST['isCorpClient'] != null && $_REQUEST['corpClientID'] == '' && $_REQUEST['allCorpClientID'] != null) {
                                if ($_REQUEST['AccountID'] == '' && $_REQUEST['FromDate'] == '' && $_REQUEST['ToDate'] == '')
                                    echo('Please enter data');

                                $AccountID = $_REQUEST['AccountID'];
                                $FromDate = $_REQUEST['FromDate'];
                                $ToDate = $_REQUEST['ToDate'];
                                $amountfromuser = $_REQUEST['Amount'];

                                $allcorsql = "SELECT IDNum FROM corporate_clients c WHERE c.accountID = $AccountID  ";
                                $allcor = mysql_query($allcorsql);

                                if (mysql_num_rows($allcor) != 0) {


                                    while ($row = mysql_fetch_assoc($allcor)) {
                                        $temp = $row["IDNum"];
                                        ECHO "EDW :" . $temp . "<br>";

                                        if ($_REQUEST['Amount'] == null) {
                                            $alltran = "SELECT * FROM transactions WHERE corporateClientID = $temp AND (date>'$FromDate' AND date<'$ToDate')";
                                            $alltable = mysql_query($alltran);


                                            if (mysql_num_rows($alltable)) {
                                                while ($row = mysql_fetch_assoc($alltable)) {
                                                    echo("<tr>");
                                                    echo("<td>" . $row["transID"] . "</td>");
                                                    echo("<td>" . $row["clientAccountID"] . "</td>");
                                                    echo("<td>" . $row["dealerAccountID"] . "</td>");
                                                    echo("<td>" . $row["date"] . "</td>");
                                                    echo("<td>" . $row["amount"] . "</td>");
                                                    echo("<td>" . $row["transType"] . "</td>");
                                                    echo("<td>" . $row["corporateClientID"] . "</td>");
                                                    echo("</tr>");
                                                }
                                            } else {
                                                echo("<tr>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("</tr>");
                                            }
                                        } else {
                                            $alltran = "SELECT * FROM transactions WHERE corporateClientID = $temp AND (date>'$FromDate' AND date<'$ToDate') AND amount < $amountfromuser";
                                            $alltable = mysql_query($alltran);


                                            if (mysql_num_rows($alltable)) {
                                                while ($row = mysql_fetch_assoc($alltable)) {
                                                    echo("<tr>");
                                                    echo("<td>" . $row["transID"] . "</td>");
                                                    echo("<td>" . $row["clientAccountID"] . "</td>");
                                                    echo("<td>" . $row["dealerAccountID"] . "</td>");
                                                    echo("<td>" . $row["date"] . "</td>");
                                                    echo("<td>" . $row["amount"] . "</td>");
                                                    echo("<td>" . $row["transType"] . "</td>");
                                                    echo("<td>" . $row["corporateClientID"] . "</td>");
                                                    echo("</tr>");
                                                }
                                            } else {
                                                echo("<tr>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("<td>0 results</td>");
                                                echo("</tr>");
                                            }
                                        }
                                    }
                                } else {
                                    echo("<tr>");
                                    echo("<td>0 results</td>");
                                    echo("<td>0 results</td>");
                                    echo("<td>0 results</td>");
                                    echo("<td>0 results</td>");
                                    echo("<td>0 results</td>");
                                    echo("<td>0 results</td>");
                                    echo("<td>0 results</td>");
                                    echo("</tr>");
                                }


                            } else if ($_REQUEST['isCorpClient'] == null) {     //The user is not corporate
                                if ($_REQUEST['AccountID'] == '' && $_REQUEST['FromDate'] == '' && $_REQUEST['ToDate'] == '')
                                    echo('Please enter data');

                                $AccountID = $_REQUEST['AccountID'];
                                $FromDate = $_REQUEST['FromDate'];
                                $ToDate = $_REQUEST['ToDate'];
                                $amountfromuser = $_REQUEST['Amount'];
                                if ($_REQUEST['Amount'] == null) {


                                    $trans = "SELECT * FROM transactions t WHERE (t.clientAccountID = $AccountID OR  t.dealerAccountID = $AccountID ) AND t.corporateClientID = 0 AND (t.date>'$FromDate' AND t.date<'$ToDate')";
                                    $table = mysql_query($trans);

                                    if (mysql_num_rows($table) != 0) {
                                        while ($row = mysql_fetch_assoc($table)) {
                                            echo("<tr>");
                                            echo("<td>" . $row["transID"] . "</td>");
                                            echo("<td>" . $row["clientAccountID"] . "</td>");
                                            echo("<td>" . $row["dealerAccountID"] . "</td>");
                                            echo("<td>" . $row["date"] . "</td>");
                                            echo("<td>" . $row["amount"] . "</td>");
                                            echo("<td>" . $row["transType"] . "</td>");
                                            echo("<td>" . $row["corporateClientID"] . "</td>");
                                            echo("</tr>");
                                        }
                                    } else {
                                        echo("<tr>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("</tr>");
                                    }
                                } else {
                                    $trans = "SELECT * FROM transactions t WHERE (t.clientAccountID = $AccountID OR  t.dealerAccountID = $AccountID ) AND t.corporateClientID = 0 AND (t.date>'$FromDate' AND t.date<'$ToDate') AND t.amount < $amountfromuser";
                                    $table = mysql_query($trans);

                                    if (mysql_num_rows($table) != 0) {
                                        while ($row = mysql_fetch_assoc($table)) {
                                            echo("<tr>");
                                            echo("<td>" . $row["transID"] . "</td>");
                                            echo("<td>" . $row["clientAccountID"] . "</td>");
                                            echo("<td>" . $row["dealerAccountID"] . "</td>");
                                            echo("<td>" . $row["date"] . "</td>");
                                            echo("<td>" . $row["amount"] . "</td>");
                                            echo("<td>" . $row["transType"] . "</td>");
                                            echo("<td>" . $row["corporateClientID"] . "</td>");
                                            echo("</tr>");
                                        }
                                    } else {
                                        echo("<tr>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("<td>0 results</td>");
                                        echo("</tr>");
                                    }
                                }


                            }
                        }
                        ?>
                    </table>
                </div>
            </div>











            <div class="row">

                <div class="col-xl-3 col-md-3 col-xs-3">
                    <button class="btn btn-md btn-success btn-info"  name="Go1" id="Go" >
                        <h4>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            Go
                        </h4>
                    </button>
                </div>
            </div>













        </form>
        <br>
        <div class="row">
            <div class="col-xl-3 col-md-3 col-xs-3">
                <a href="index.php">
                    <button class="btn btn-md btn-info btn-block"  id="home" >
                        <h4>
                            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                            Home
                        </h4>
                    </button>
                </a>
            </div>
        </div>
    </div>


</div>
</body>
<html>