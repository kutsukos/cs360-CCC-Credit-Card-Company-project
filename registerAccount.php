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
    <title>Account Registration</title>

</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Account Registration</h1>
        </div>
    </div>
    <div class="row">
        <form action="registerAccount.php" method="POST" class="form-horizontal my-form" role="form">

            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">Name</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="ClientName" placeholder="Name">
                </div><!-- /col-sm-9 -->
            </div><!-- /form-group -->



            <div class="form-group">
                <label class="col-sm-3 control-label">Exp Date</label>
                <div class="col-sm-3">
                    <input type="date" name="ExpDate" min="2016-12-00">
                </div><!-- /col-sm-9 -->
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Available Balance</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="Balance" placeholder="Available Balance">
                </div><!-- /col-sm-9 -->
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Debt</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="DebtAmount" placeholder="Debt">
                </div><!-- /col-sm-9 -->
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Credit Limit</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="Limit" placeholder="Credit Limit">
                </div><!-- /col-sm-9 -->
            </div>

<br><br>
            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">I am a corporate client</label>
                <div class="col-sm-3">
                    <input type="checkbox" name="isCorpo" value="1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">Client id</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="CorpID" placeholder="Client id">
                </div><!-- /col-sm-9 -->
            </div>
            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">Client name</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="CorpName" placeholder="Client name">
                </div><!-- /col-sm-9 -->
            </div>
            <div class="form-group">
                <label class="col-xl-3 col-md-3 col-xs-3 control-label">Corporate name</label>
                <div class="col-sm-3">
                    <input name="companyname" list="Corp">
                        <datalist id="Corp">
                            <?php
                            $sql="SELECT U.username FROM users U,clients C WHERE U.accountID=C.accountID and C.isCompany=TRUE";
                            $result=mysql_query($sql);
                            while($table = mysql_fetch_array($result)){
                                echo "<option value='".$table[0]."'>";
                            }
                            ?>
                        </datalist>
                </div>
            </div>


        <div class="row">

            <div class="col-xl-6 col-md-6 col-xs-6">
                <button class="btn btn-md btn-success btn-block"  name="Register" id="Register" >
                    <h4>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        Register
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
</html>

<?php
include('connect.php');
if(isset( $_POST["Register"])) {
    //first check for inputs
    if ($_REQUEST['isCorpo'] != null) {     //The user is corporate
        if($_REQUEST['CorpID'] == '' && $_REQUEST['CorpName'] == '' && $_REQUEST['companyname'] == '') {
            echo('Please enter data');
        }else {
            $corporateClientID = $_REQUEST['CorpID'];
            $corporateClientName = $_REQUEST['CorpName'];
            $companyName = $_REQUEST['companyname'];
            //We have everything we need time for some insert!!!!
            /*Now lets create a client for a company*/
            //Firstly we will need company's account ID to connect company with this user
            $getidsql = "SELECT accountID FROM users WHERE username='$companyName'";
            $result = mysql_query($getidsql);
            if(mysql_num_rows($result) == 0)
                die('Could not find company after creation: ' . mysql_error());
            $resultTable = mysql_fetch_array($result);
            //Now I have company's accountID at resultTable[0]

            //Now we can insert user at corporate users table
            $insertcorpousersql = "INSERT INTO corporate_clients(accountID,corpoName,IDNum)
                VALUE($resultTable[0],'" . $corporateClientName . "',$corporateClientID)";
            $retval = mysql_query($insertcorpousersql, $conect);
            if (!$retval)
                die('Could not enter data: ' . mysql_error());
        }
    }else{
        if($_REQUEST['ClientName'] == '' && $_REQUEST['ExpDate'] == '' && $_REQUEST['Balance'] == '' &&
            $_REQUEST['DebtAmount'] == '' && $_REQUEST['Limit'] == '')
            echo ('Please enter data');
        else {
            $ClientName = $_REQUEST['ClientName'];
            $ExpDate = $_REQUEST['ExpDate'];
            $AvailBalance = $_REQUEST['Balance'];
            $Debt = $_REQUEST['DebtAmount'];
            $Limit = $_REQUEST['Limit'];
            //Insert User Mark into users
            $insertusersql = "INSERT INTO users(username)
        VALUE('" . $ClientName . "')";
            $retval = mysql_query($insertusersql, $conect);
            if (!$retval)
                die('Could not enter data: ' . mysql_error());

            //Next step is to get new user's accountID
            $getidsql = "SELECT accountID FROM users WHERE username='$ClientName'";
            $result = mysql_query($getidsql);
            if(mysql_num_rows($result) == 0)
                die('Could not find Mark after creation: ' . mysql_error());
            $resultTable = mysql_fetch_array($result);
            //Now I have user's accountID at resultTable[0]

            //Next step is to insert user into Clients table
            $insertclientsql = "INSERT INTO clients(accountID,expDate,availBalance,debt,creditLimit)
        VALUE($resultTable[0],'" . $ExpDate . "',$AvailBalance,$Debt,$Limit)";
            $retval = mysql_query($insertclientsql, $conect);
            if (!$retval)
                die('Could not enter data: ' . mysql_error());
            //END!!!!
        }
    }
}
?>

