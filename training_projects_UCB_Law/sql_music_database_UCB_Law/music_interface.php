<!DOCTYPE html>
<html>
<head>
<title>Music Collection</title>
<style>

  /* Ask Devin how table UI should be formatted */
  /* Idea: Interqctable form with buttons? OR Upon hitting update button we can interact*/
  /* Add styling for the table, font, background, etc. here */
table, th, td{
  border:1px solid black;
}

</style>
</head>
<body>
<h1>THE BANGERS</h1>
  
<table style ="width:100%">
  <form>
  <tr>
    <th>Id</th>
    <th>Artist</th>
    <th>Album</th>
    <th>Update</th>
    <th>Delete</th>
  </tr>
  <?php
  require __DIR__ . '/record_functions.php';//imports get_artist function
  $conn = new mysqli("localhost","root","","musicDB");
	if($conn->connect_error){
		die("Connection failed: ".$conn->connect_error);
	}

  $sql = "SELECT id, artist_id, album_name FROM music_album";
  
  try{
    $result = $conn->query($sql);
    if($result-> num_rows > 0){
      while($row = $result->fetch_assoc()){
        $artist = get_artist($row["artist_id"]); //="Nirvana"
        echo "<tr><td>". $row["id"] ."</td><td>". $artist 
        ."</td><td>". $row["album_name"] ."</td><td>".
        "<button>Update</button>"."</td><td>".
        "<button>Delete</button>"."</td></tr>";//Not good for sql injection
      }
//echo "<tr><td>". $row["id"] ."</td><td>". $artist."</td><td>". $row["album_name"] ."</td><td>". 
    } else {
      echo "0 result";
    }
    $conn->close();
  }catch(Exception $e){
    echo "Error in Displaying Data: ".$conn->error;
  } 
  ?>
  </form>
</table>
<h2>Insert Data</h2>
<form action="insert.php" method="post">
    Artist: <input type="text" name = "art" /><br/>
    Album: <input type="text" name = "alb" /><br/>
    <input type="submit"/>
</form>

<h2>Update Data</h2>
<form action="update.php" method="post">
    Id: <input type="text" name = "id" /><br/>
    Artist: <input type="text" name = "art" /><br/>
    Album: <input type="text" name = "alb" /><br/>
    <input type="submit"/>
</form>

<h2>Delete Data</h2>
<form action="delete.php" method="post">
  Id: <input type="text" name = "id" /><br/>
    <input type="submit"/>
</form>
<?php
/* Replace username, password, and dbname with the username, password, and database name
  that you used to create the database in setup */
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = 'musicDB';
 
  // Create a connection to your database and check that it was successful (similar to the connection you made to create the table)
  $conn = new mysqli($servername,$username,$password,$dbname);
 
  //INSERT CODE HERE
 
 
  function insertData(){
    $conn = new mysqli("localhost","root","","musicDB");
    $artist = $conn->real_escape_string($_POST['art']);//Double check with prev project how this was done
    $album = $conn->real_escape_string($_POST['alb']);
    $sql = "INSERT INTO musicTab (artist, album)
            VALUES ('{$artist}','{$album}')";
    try{
      $conn->query($sql)===TRUE;
      echo "Data Inserted";
    }catch(Exception $e){
      echo "Error in Inserting Data: ".$conn->error;
    }
  }
 
  function updateData($conn){
 
  }
 
  function deleteData($conn){
 
  }

?>

  <!-- 

  Display the table with PHP/HTML and create PHP functions to add, update, and delete rows. 
  There are multiple ways to do this project. You can code everything in this file, or create other files as you wish, as long as you achieve the desired functionality.

  -->


</body>
</html>