
<?php
// Make a MySQL Connection
mysql_connect("localhost", "root", "properset$") or die(mysql_error());
mysql_select_db("properset") or die(mysql_error());

// Get all the data from the "example" table
$result = mysql_query("SELECT users.mobile,users.otp,users.userId,auth_token.tokenId FROM users INNER JOIN auth_token on users.userId=auth_token.userId   ORDER BY  `users`.`userId` DESC ") 
or die(mysql_error());  

echo "<table border='1'>";
echo "<tr> <th>UserId</th>  <th>Mobile</th> <th>OTP</th> <th>Token</th> </tr>";
// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $result )) {
    // Print out the contents of each row into a table
    echo "<tr><td>"; 
    echo $row['userId'];
	 echo "<td>"; 
    echo $row['mobile'];
	 echo "<td>"; 
    echo $row['tokenId'];
    echo "<td>"; 
    echo $row['otp'];
    echo "</td></tr>"; 
} 

echo "</table>"; 
?>