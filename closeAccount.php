<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>CCC Close Account</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Account Cancellation</h1>
        </div>
    </div>
    <div class="row">
        <form class="form-inline" action="closeAccount.php" method="POST"  role="form">

            <div class="form-group">
                <label for="inputname">Name</label>
                <input type="text" class="form-control" id="cname" name="cname" placeholder="Joe Doe">
            </div>
            <button type="submit" name="submit" id="submit" class="btn btn-danger">Cancel Account</button>
        </form>
    </div>
    <?php
        include('connect.php');
        if(isset( $_POST["submit"])) {
            if ($_REQUEST['cname'] == null) {
                echo("<h3>Please enter a name</h3>");
            }else{
                $name=$_POST['cname'];                                                  //We have the name.
                //We search for ID, if exists
                $getidsql="SELECT accountID FROM users WHERE username='$name'";
                $result=mysql_query($getidsql);
                if(mysql_num_rows($result) == 0)                                     //There is nobody with this name
                    echo("<h3>Error: There is not a client with this name!</h3>");
                else{
                    $caccountID = mysql_fetch_array($result);                               //We have and the acountID
                    //check if it is a company
                    $getdebtsql="SELECT isCompany FROM clients WHERE accountID='$caccountID[0]'";
                    $result2=mysql_query($getdebtsql);
                    $check = mysql_fetch_array($result2);
                    if($check[0]==1){
                        echo("<h3>Error: This is a Company client. Cant delete</h3>");
                    }
                    else{
                        //Lets check caccounts debt
                        $getdebtsql="SELECT debt FROM clients WHERE accountID='$caccountID[0]'";
                        $result2=mysql_query($getdebtsql);
						if(mysql_num_rows($result2) == 0) { 							//Its not a client. Its a dealer
							$getdebtsql2="SELECT debt FROM dealers WHERE accountID='$caccountID[0]'";
							$result3=mysql_query($getdebtsql2);
							
							$debt = mysql_fetch_array($result3);
							if ($debt[0] != 0) {                                                        //error cant delete! has a debt to CCC
								echo("<h3>Error: Dealer has a debt to CCC!</h3>");
							} else {                                                                   //we are ok to delete
								$deletefromdealers = "DELETE FROM dealers WHERE accountID='$caccountID[0]'";
								$deletefromusers = "DELETE FROM users WHERE accountID='$caccountID[0]'";
								$result3 = mysql_query($deletefromdealers);
								$result4 = mysql_query($deletefromusers);
								if (!$result3)
									die('Error: Could not delete user from dealers table: ' . mysql_error());
								if (!$result4)
									die('Error: Could not delete user from users table: ' . mysql_error());
								echo("<h3>Success: Dealer deleted from database</h3>");
							}
						}
						else{
							$debt = mysql_fetch_array($result2);
							if ($debt[0] != 0) {                                                        //error cant delete! has a debt to CCC
								echo("<h3>Error: Client has a debt to CCC!</h3>");
							} else {                                                                   //we are ok to delete
								$deletefromclients = "DELETE FROM clients WHERE accountID='$caccountID[0]'";
								$deletefromusers = "DELETE FROM users WHERE accountID='$caccountID[0]'";
								$result3 = mysql_query($deletefromclients);
								$result4 = mysql_query($deletefromusers);
								if (!$result3)
									die('Error: Could not delete user from clients table: ' . mysql_error());
								if (!$result4)
									die('Error: Could not delete user from users table: ' . mysql_error());
								echo("<h3>Success: Client deleted from database</h3>");
							}
						}
                    }
                }
            }
        }
    ?>
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
