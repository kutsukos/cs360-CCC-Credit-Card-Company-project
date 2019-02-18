<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel='stylesheet' type='text/css' href='style.css' />
        <title>CCC Control Home</title>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row ">
                <div class="col-xl-12 col-md-12 col-xs-12">
                    <h1>Welcome to CCC Control Panel</h1>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-xl-3 col-md-3 col-xs-3">
                    <h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Account Procedures</h4>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="registerAccount.php">
                        <button class="btn btn-md btn-primary btn-block"  id="create" >Create Account</button>
                    </a>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="closeAccount.php">
                        <button class="btn btn-md btn-danger btn-block"  id="close" >Close Account</button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-3 col-xs-3">
                    <h4><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>Transactions</h4>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="purchase.php">
                        <button class="btn btn-md btn-success btn-block"  id="purchase" >Purchase</button>
                    </a>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="return.php">
                        <button class="btn btn-md btn-warning btn-block"  id="return">Return</button>
                    </a>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="payoff.php">
                        <button class="btn btn-md btn-info btn-block"  id="payoff">PayOff</button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-3 col-xs-3">
                    <h4><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>Information</h4>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="questions.php">
                        <button class="btn  btn-default btn-block"  id="questions">Questions</button>
                    </a>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="goodClients.php">
                        <button class="btn btn-md btn-info btn-block"  id="goodclients">State of Good Clients</button>
                    </a>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="badClients.php">
                        <button class="btn btn-md btn-info btn-block"  id="badclients">State of Bad Clients</button>
                    </a>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="monthsDealer.php">
                        <button class="btn btn-md btn-default btn-block"  id="monthsdealer">Dealer of the Month</button>
                    </a>
                </div>
            </div>
            <br><br><br><br><br>
            <div class="row">
                <div class="col-xl-3 col-md-3 col-xs-3">
                    <h4><span class="glyphicon glyphicon-grain" aria-hidden="true"></span>Admin Procedures</h4>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="initializeSQL.php">
                        <button class="btn btn-md btn-default btn-block"  id="init">Initialize DB</button>
                    </a>
                </div>
                <div class="col-xl-2 col-md-2 col-xs-2">
                    <a href="dropSQL.php">
                        <button class="btn btn-md btn-danger btn-block"  id="init">DROP DB</button>
                    </a>
                </div>
            </div>
        </div>

    </body>
</html>
