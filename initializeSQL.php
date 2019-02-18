<?php
$host="localhost";  // Host name
$username="admin";  // Mysql username
$password="admin";  // Mysql password
$db_name="cccDB";   // Database name

// Connect to server and select database.
$conn = new mysqli($host, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*CREATE DATABASE*/
$sql = "CREATE DATABASE cccDB";
if ($conn->query($sql) !== TRUE)
    echo "Error creating database: " . $conn->error;


// Create connection
$datab = new mysqli($host, $username, $password, $db_name);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);


/*CREATE TABLE USERS*/
$userstable = "CREATE TABLE users (
accountID INT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR (30) NOT NULL
)";

if ($datab->query($userstable) !== TRUE)
    echo "Error creating table USERS: " . $datab->error;



/*CREATE TABLE Client*/
$clientable = "CREATE TABLE clients(
accountID INT(30) NOT NULL PRIMARY KEY,
expDate VARCHAR(10),
availBalance INT(10),
debt INT(10),
creditLimit INT(10),
isCompany BOOLEAN DEFAULT 0
)";

if ($datab->query($clientable) !== TRUE)
    echo "Error creating table Clients: " . $datab->error;


/*CREATE TABLE Dealers*/
$dealerstable = "CREATE TABLE dealers (
accountID INT(30) NOT NULL PRIMARY KEY,
debt FLOAT(10),
profit INT(10),
commission INT(10)
)";

if ($datab->query($dealerstable) !== TRUE)
    echo "Error creating table Dealers: " . $datab->error;



/*CREATE TABLE  corporate client*/
$corporatec = "CREATE TABLE corporate_clients (
accountID INT (30) NOT NULL,
corpoName VARCHAR (30) NOT NULL,
IDNum INT(10) PRIMARY KEY
)";

if ($datab->query($corporatec) !== TRUE)
    echo "Error creating table corporate client: " . $datab->error;


/* CREATE TABLE transaction */
$trans = "CREATE TABLE transactions (
transID INT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
clientAccountID INT(30) NOT NULL,
dealerAccountID INT(30) NOT NULL,
date VARCHAR(10),
amount INT(10),
transType INT(10),
corporateClientID INT(10)
)";

if ($datab->query($trans) !== TRUE)
    echo "Error creating table transactions: " . $datab->error;

/*
 * Now we insert some data!!!
 */

$conect=  mysql_connect($host, $username, $password);
mysql_select_db($db_name, $conect);

/*Creating new account procedure*/
//Insert User Mark into users
$insertusersql="INSERT INTO users(username)
        VALUE('Mark')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
  die('Could not enter data: ' . mysql_error());

//Next step is to get Mark's accountID
$getidsql="SELECT accountID FROM users WHERE username='Mark'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Mark after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Mark's accountID at resultTable[0]

//Next step is to insert Mark into Clients table
$insertclientsql="INSERT INTO clients(accountID,expDate,availBalance,debt,creditLimit)
        VALUE($resultTable[0],'2006-11-25',200,0,300)";
$retval = mysql_query($insertclientsql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());
//END!!!!

/*Creating new account procedure*/
//Insert User Kostas into users
$insertusersql="INSERT INTO users(username)
        VALUE('Kostas')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//Next step is to get Kostas's accountID
$getidsql="SELECT accountID FROM users WHERE username='Kostas'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Kostas after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Kostas's accountID at resultTable[0]

//Next step is to insert Kostas into Clients table
$insertclientsql="INSERT INTO clients(accountID,expDate,availBalance,debt,creditLimit)
        VALUE($resultTable[0],'2026-11-25',2000,0,3600)";
$retval = mysql_query($insertclientsql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());
//END!!!!

/*Creating new account procedure*/
//Insert User Stathis into users
$insertusersql="INSERT INTO users(username)
        VALUE('Stathis')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//Next step is to get Stathis's accountID
$getidsql="SELECT accountID FROM users WHERE username='Stathis'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Stathis after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Stathis's accountID at resultTable[0]

//Next step is to insert Stathis into Clients table
$insertclientsql="INSERT INTO clients(accountID,expDate,availBalance,debt,creditLimit)
        VALUE($resultTable[0],'2026-11-25',500,0,300)";
$retval = mysql_query($insertclientsql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());
//END!!!!



/*Now lets create 2 companIES the same way we created Mark but with a small difference when inserting to Clients table*/
//Insert company Apple into users
$insertusersql="INSERT INTO users(username)
        VALUE('Apple')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//Next step is to get Apple's accountID
$getidsql="SELECT accountID FROM users WHERE username='Apple'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Apple after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Apple's accountID at resultTable[0]

//Next step is to insert Apple into Clients table
$insertclientsql="INSERT INTO clients(accountID,expDate,availBalance,debt,creditLimit,isCompany)
        VALUE($resultTable[0],'2016-12-05',3000,0,4000,1)";
$retval = mysql_query($insertclientsql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());
//END!!!!


//Insert company Microsoft into users
$insertusersql="INSERT INTO users(username)
        VALUE('Microsoft')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//Next step is to get Microsoft's accountID
$getidsql="SELECT accountID FROM users WHERE username='Microsoft'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Microsoft after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Microsoft's accountID at resultTable[0]

//Next step is to insert Apple into Clients table
$insertclientsql="INSERT INTO clients(accountID,expDate,availBalance,debt,creditLimit,isCompany)
        VALUE($resultTable[0],'2019-12-05',1500,0,6000,1)";
$retval = mysql_query($insertclientsql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());
//END!!!!


//Insert company Microsoft into users
$insertusersql="INSERT INTO users(username)
        VALUE('Google')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//Next step is to get Microsoft's accountID
$getidsql="SELECT accountID FROM users WHERE username='Google'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Microsoft after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Microsoft's accountID at resultTable[0]

//Next step is to insert Apple into Clients table
$insertclientsql="INSERT INTO clients(accountID,expDate,availBalance,debt,creditLimit,isCompany)
        VALUE($resultTable[0],'2028-12-05',2500,0,4000,1)";
$retval = mysql_query($insertclientsql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());
//END!!!!


/*Now lets create a client from Apple*/
//Firstly we will need Apple's account ID to connect Apple with this user
$getidsql="SELECT accountID FROM users WHERE username='Apple'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Apple after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Apple's accountID at resultTable[0]

//Now we can insert user at corporate users table
$insertcorpousersql="INSERT INTO corporate_clients(accountID,corpoName,IDNum)
        VALUE($resultTable[0],'Steven',2609)";
$retval = mysql_query($insertcorpousersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());


/*Now lets create a client from Google*/
//Firstly we will need Google's account ID to connect Apple with this user
$getidsql="SELECT accountID FROM users WHERE username='Google'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Apple after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Apple's accountID at resultTable[0]

//Now we can insert user at corporate users table
$insertcorpousersql="INSERT INTO corporate_clients(accountID,corpoName,IDNum)
        VALUE($resultTable[0],'Mark',262)";
$retval = mysql_query($insertcorpousersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());



/*Now lets create a dealer. It's almost the same as we created client Mark*/
//Insert User Barbastathis into users
$insertusersql="INSERT INTO users(username)
        VALUE('Barbastathis')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//Next step is to get Barbastathis's accountID
$getidsql="SELECT accountID FROM users WHERE username='Barbastathis'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Barbastathis's accountID at resultTable[0]

//Next step is to insert Barbastathis into Dealers table
$insertdealerssql="INSERT INTO dealers(accountID,debt,profit,commission)
        VALUE($resultTable[0],0,30,50)";
$retval = mysql_query($insertdealerssql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());
//END!!!!


/*Now lets create another dealer. It's almost the same as we created client Mark*/
//Insert User Police into users
$insertusersql="INSERT INTO users(username)
        VALUE('Police')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//Next step is to get Police's accountID
$getidsql="SELECT accountID FROM users WHERE username='Police'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Police after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Police's accountID at resultTable[0]

//Next step is to insert Police into Dealers table
$insertdealerssql="INSERT INTO dealers(accountID,debt,profit,commission)
        VALUE($resultTable[0],0,99999,20)";
$retval = mysql_query($insertdealerssql,$conect);
if(!$retval )
    die('Could not enter data Police: ' . mysql_error());
//END!!!!

/*Now lets create another dealer. It's almost the same as we created client Mark*/
//Insert User Pfizer into users
$insertusersql="INSERT INTO users(username)
        VALUE('Pfizer')";
$retval = mysql_query($insertusersql,$conect);
if(!$retval )
    die('Could not enter data Pfizer: ' . mysql_error());

//Next step is to get Pfizer's accountID
$getidsql="SELECT accountID FROM users WHERE username='Pfizer'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Pfizer after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Pfizer's accountID at resultTable[0]

//Next step is to insert Pfizer into Dealers table
$insertdealerssql="INSERT INTO dealers(accountID,debt,profit,commission)
        VALUE($resultTable[0],0,988799,15)";
$retval = mysql_query($insertdealerssql,$conect);
if(!$retval )
    die('Could not enter data Pfizer: ' . mysql_error());
//END!!!!


/*
 *      Finally time to create a transaction. It's gonna be HARD!!! and we have two ways to perform trans.
 *      We can pay or we can credit
 *      Every time after the transaction is inserted. We will have to update user's table's values
 */

//Firstly lets say Mark is about to buy from Barbastathis something which cost 10$ and Mark is gonna pay
//1.Find accountID for Mark and Barbastathis
$getidsql="SELECT accountID FROM users WHERE username='Barbastathis'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after creation: ' . mysql_error());
$resultTable = mysql_fetch_array($result);
//Now I have Barbastathis's accountID at resultTable[0]

$getidsql="SELECT accountID FROM users WHERE username='Mark'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Mark after creation: ' . mysql_error());
$resultTable2 = mysql_fetch_array($result);
//Now I have Mark's accountID at resultTable[0]


//2. Now we will have to check if client is able to buy. We check AvalBalance cause he is gonna buy it
$getidsql="SELECT availBalance FROM clients WHERE accountID='$resultTable2[0]'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find mark after balance after creation: ' . mysql_error());
$resultTable3 = mysql_fetch_array($result);
//Now I have Mark's avalBalance at resultTable3[0]
if($resultTable3[0]<10)
    die('Cant buy. Does not have money');


//3. Now we have at resultTable barbastathis ID and at resultTable2 Mark ID and we know that Mark is able to buy. We are ready to create a transaction
$inserttranssql="INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
        VALUE($resultTable2[0],$resultTable[0],'2016-12-12',10,0,0)";
$retval = mysql_query($inserttranssql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

//4. Now that the transaction is created. Time to update user's data.
//Reminder: We have $resultTable2[0] - Client, $resultTable[0] - Dealer, $resultTable3[0] - AvailBalance
//First lets remove money from client
$resultTable3[0]=$resultTable3[0]-10;
$updateavailbalancesql="UPDATE clients SET availBalance='$resultTable3[0]'  WHERE accountID='$resultTable2[0]'";
$retval = mysql_query($updateavailbalancesql,$conect);
if(!$retval )
    die('Could not update data: ' . mysql_error());

//Now lets add money to dealer's profit and update debt values
//We need some info first. Like dealers profit, debt, commission -
$getidsql="SELECT * FROM dealers WHERE accountID='$resultTable[0]'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after profit: ' . mysql_error());
$barbastathisTable = mysql_fetch_array($result);
/*
 * Now I have barbastathis info at
 * profit - $barbastathisTable[2]
 * debt - $barbastathisTable[1]
 * commission - $barbastathisTable[3]
 */
$barbastathisTable[2]=$barbastathisTable[2]+10;     //profit
$barbastathisTable[3]=$barbastathisTable[3]/100;    //commission
$barbastathisTable[1]=$barbastathisTable[1]+(10*$barbastathisTable[3]);  //new debt
//update profit first
$updatedealerssql="UPDATE dealers SET profit='$barbastathisTable[2]'  WHERE accountID='$resultTable[0]'";
$retval = mysql_query($updatedealerssql,$conect);
if(!$retval)
    die('Could not update data profit dealer: ' . mysql_error());

$updatedealerssql="UPDATE dealers SET debt='$barbastathisTable[1]'  WHERE accountID='$resultTable[0]'";
$retval = mysql_query($updatedealerssql,$conect);
if(!$retval)
    die('Could not update data dept dealer: ' . mysql_error());
//DONE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//FINALLY!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//NUMBERS ARE CHECKED + WHEN CLIENT DOES NOT HAVE MONEY SITUATION!!!!



//Then Mark will buy from Barbastathis something which cost 20$ and it is a credit
//1.Find accountID for Mark and Barbastathis
$getidsql="SELECT accountID FROM users WHERE username='Barbastathis'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after creation: ' . mysql_error());
$barba = mysql_fetch_array($result);
//Now I have Barbastathis's accountID at resultTable[0]

$getidsql="SELECT accountID FROM users WHERE username='Mark'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Mark after creation: ' . mysql_error());
$mark = mysql_fetch_array($result);
//Now I have Mark's accountID at resultTable[0]



//2. Now we will have to check if client is able to buy. We check creditLimit cause he is gonna credit  it
$getidsql="SELECT creditLimit FROM clients WHERE accountID='$mark[0]'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find mark after balance after creation: ' . mysql_error());
$credit = mysql_fetch_array($result);
//Now I have Mark's avalBalance at resultTable3[0]
if($credit[0]<20)
    die('Cant buy. Does not have money');


//3. Else Mark can buy
// We are ready to create a transaction Now Type is 1. It is a credit trans.
$inserttranssql="INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
        VALUE($mark[0],$barba[0],'2016-12-13',20,1,0)";
$retval = mysql_query($inserttranssql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());


//4. Now that this transaction is credit, we dont really move money from client to dealer until client pay his credit transactions
//Time to update creditLimit and debt
//We need some info first.
$getidsql="SELECT * FROM clients WHERE accountID='$mark[0]'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after profit: ' . mysql_error());
$markTable = mysql_fetch_array($result);

/*
 * $markTable[3] -> debt
 * $markTable[4] -> creditLimit
 */
$markTable[4]=$markTable[4]-20;
$markTable[3]=$markTable[3]+20;

//Now we update this two values on Mark's row
$updatedebtsql="UPDATE clients SET debt='$markTable[3]'  WHERE accountID='$mark[0]'";
$retval = mysql_query($updatedebtsql,$conect);
if(!$retval )
    die('Could not update data: ' . mysql_error());

$updatelimitsql="UPDATE clients SET creditLimit='$markTable[4]'  WHERE accountID='$mark[0]'";
$retval = mysql_query($updatelimitsql,$conect);
if(!$retval )
    die('Could not update data: ' . mysql_error());

/*
 * Done! We dont update dealers money yet. We wait for client to payoff its debts!
 */


/*
 * Now Time to work like there is a corporate client who want to make a transaction.
 * Steven work for Apple. So he uses Apple's account to buy
 */
/*
 * 1st.  lets say Steven wants to buy from Barbastathis something which cost 40$ and Steven is gonna pay
 */
//1.Find accountID for Steven and Barbastathis
$getidsql="SELECT accountID FROM users WHERE username='Barbastathis'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after creation: ' . mysql_error());
$barbaID = mysql_fetch_array($result);
//Now I have Barbastathis's accountID at resultTable[0]

$getallfromcorposql="SELECT * FROM corporate_clients WHERE corpoName='Steven'";
$result=mysql_query($getallfromcorposql);
if(!$result )
    die('Could not find Steven after creation: ' . mysql_error());
$stevensinfo = mysql_fetch_array($result);
//Now I have Steven's accountID at resultTable[0]

/*
 * Check point for data
 * $barbaID[0] <- Barbastathis ID
 * $stevensinfo <- all steven's info from corporate users
 */

//2. Now we will have to check if client is able to buy. We check AvalBalance cause he is gonna buy it
$getidsql="SELECT * FROM clients WHERE accountID='$stevensinfo[0]'"; //Steven's company
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find stevens company balance after creation: ' . mysql_error());
$stevenscompanyinfo = mysql_fetch_array($result);
//Now I have steven's company's avalBalance at $stevenscompanyinfo[2]
if($stevenscompanyinfo[2]<40)
    die('Cant buy. Does not have money');

/*
 * Check point for data
 * $barbaID[0] <- Barbastathis ID
 * $stevensinfo <- all steven's info from corporate users
 * $stevenscompanyinfo <- all steven's company info from clients ;)
 */
//3. Now We are ready to create a transaction
$inserttranssql="INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
        VALUE($stevensinfo[0],$barbaID[0],'2016-12-20',40,0,$stevensinfo[2])";
$retval = mysql_query($inserttranssql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());


/*
 * Check point for data
 * $barbaID[0] <- Barbastathis ID
 * $stevensinfo <- all steven's info from corporate users
 * $stevenscompanyinfo <- all steven's company info from clients ;)
 */
//4. Now that the transaction is created. Time to update user's data.
//First lets remove money from client
$stevenscompanyinfo[2]=$stevenscompanyinfo[2]-40;
$updateavailbalancesql="UPDATE clients SET availBalance='$stevenscompanyinfo[2]'  WHERE accountID='$stevensinfo[0]'";
$retval = mysql_query($updateavailbalancesql,$conect);
if(!$retval )
    die('Could not update data: ' . mysql_error());

//Now lets add money to dealer's profit and update debt values
//We need some info first. Like dealers profit, debt, commission -
$getidsql="SELECT * FROM dealers WHERE accountID='$barbaID[0]'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after profit: ' . mysql_error());
$barbastathisTable = mysql_fetch_array($result);
/*
 * Now I have barbastathis info at
 * profit - $barbastathisTable[2]
 * debt - $barbastathisTable[1]
 * commission - $barbastathisTable[3]
 */
$barbastathisTable[2]=$barbastathisTable[2]+40;     //profit
$barbastathisTable[3]=$barbastathisTable[3]/100;    //commission
$barbastathisTable[1]=$barbastathisTable[1]+(40*$barbastathisTable[3]);  //new debt
//update profit first
$updatedealerssql="UPDATE dealers SET profit='$barbastathisTable[2]'  WHERE accountID='$barbastathisTable[0]'";
$retval = mysql_query($updatedealerssql,$conect);
if(!$retval)
    die('Could not update data profit dealer: ' . mysql_error());

$updatedealerssql="UPDATE dealers SET debt='$barbastathisTable[1]'  WHERE accountID='$barbastathisTable[0]'";
$retval = mysql_query($updatedealerssql,$conect);
if(!$retval)
    die('Could not update data dept dealer: ' . mysql_error());
//DONE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//FINALLY!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//NUMBERS ARE CHECKED + WHEN CLIENT DOES NOT HAVE MONEY SITUATION!!!!




/*
 * 2nd. Steven will buy from Barbastathis something which cost 200$ and it is a credit
 */
//1.Find accountID for Stevens company and Barbastathis
$getidsql="SELECT accountID FROM users WHERE username='Barbastathis'";
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find Barbastathis after creation: ' . mysql_error());
$barbaID = mysql_fetch_array($result);
//Now I have Barbastathis's accountID at resultTable[0]

$getallfromcorposql="SELECT * FROM corporate_clients WHERE corpoName='Steven'";
$result=mysql_query($getallfromcorposql);
if(!$result )
    die('Could not find Steven after creation: ' . mysql_error());
$stevensinfo = mysql_fetch_array($result);
//Now I have Steven's accountID at resultTable[0]

/*
 * Check point for data
 * $barbaID[0] <- Barbastathis ID
 * $stevensinfo <- all steven's info from corporate users
 */



//2. Now we will have to check if client is able to buy. We check creditLimit cause he is gonna credit  it
$getidsql="SELECT * FROM clients WHERE accountID='$stevensinfo[0]'"; //Steven's company
$result=mysql_query($getidsql);
if(!$result )
    die('Could not find stevens company balance after creation: ' . mysql_error());
$stevenscompanyinfo = mysql_fetch_array($result);
//Now I have steven's company's creditLimit at $stevenscompanyinfo[4]
if($stevenscompanyinfo[4]<200)
    die('Cant buy. Does not have money');


//3. Else Steven can buy
// We are ready to create a transaction Now Type is 1. It is a credit trans.
$inserttranssql="INSERT INTO transactions(clientAccountID,dealerAccountID,date,amount,transType,corporateClientID)
        VALUE($stevensinfo[0],$barbaID[0],'2016-12-21',200,1,$stevensinfo[2])";
$retval = mysql_query($inserttranssql,$conect);
if(!$retval )
    die('Could not enter data: ' . mysql_error());

/*
 * Check point for data
 * $barbaID[0] <- Barbastathis ID
 * $stevensinfo <- all steven's info from corporate users
 * $stevenscompanyinfo <- all steven's company info from clients ;)
 */
//4. Now that this transaction is credit, we dont really move money from client to dealer until client pay his credit transactions
//Time to update creditLimit and debt
//We need some info first.
$stevenscompanyinfo[3]=$stevenscompanyinfo[3]+200;  //updating debt value
$stevenscompanyinfo[4]=$stevenscompanyinfo[4]-200;  //updating creditLimit value

//Now we update this two values on Mark's row
$updatedebtsql="UPDATE clients SET debt='$stevenscompanyinfo[3]'  WHERE accountID='$stevenscompanyinfo[0]'";
$retval = mysql_query($updatedebtsql,$conect);
if(!$retval )
    die('Could not update data: ' . mysql_error());

$updatelimitsql="UPDATE clients SET creditLimit='$stevenscompanyinfo[4]'  WHERE accountID='$stevenscompanyinfo[0]'";
$retval = mysql_query($updatelimitsql,$conect);
if(!$retval )
    die('Could not update data: ' . mysql_error());


//Closing connections
$conn->close();
$datab->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='style.css' />
    <title>CCC Initialize DB</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ">
        <div class="col-xl-12 col-md-12 col-xs-12">
            <h1>Initializing DB</h1>
        </div>
    </div>
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