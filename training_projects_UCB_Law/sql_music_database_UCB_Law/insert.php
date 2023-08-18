<?php
require __DIR__ . '/record_functions.php';
$conn = new mysqli("localhost","root","","musicDB");
$artist = $conn->real_escape_string($_POST['art']);//Double check with prev project how this was done
$album = $conn->real_escape_string($_POST['alb']);
$new_artist_query = "INSERT INTO music_artist (artist_name) VALUES ('{$artist}'); 
INSERT INTO music_album (album_name,artist_id) VALUES ('{$album}',0)";
$old_artist_query = "INSERT INTO music_album (album_name,artist_id) VALUES ('{$album}',0)";


//If already in stortable and unmarked
//Just Mark it again in music store and insert the item with all its parameters
//If already in stortable and marked
//Do nothing
//Else, 
//Create a item
//$sql = "INSERT INTO musicTab (artist, album)
        //VALUES ('{$artist}','{$album}');
        //INSERT INTO musicStor (artist, album)
        //VALUES ('{$artist}','{$album}');";
try{
  $artist_exists = is_artist_recorded($artist);
  $artist_and_album_exists = is_album_and_artist_recorded($artist,$album);
  if ($artist_and_album_exists) {
    echo "Artist and album already exists";
  } elseif ($artist_exists) {
    echo "artist exists!";
    $conn->multi_query($old_artist_query)===TRUE; 
    $artist_id = get_artist_id($artist);
    update_artist_id($album,$artist_id);
  }else{
    echo "artist DOES NOT exists!";
    $conn->multi_query($new_artist_query)===TRUE; 
    $artist_id = get_artist_id($artist);
    update_artist_id($album,$artist_id);
  }
  //$conn->multi_query($query)===TRUE; 
  //$artist_id = get_artist_id($artist);
  //update_artist_id($album,$artist_id);
 
}catch(Exception $e){
  echo "Error in Inserting Data: ".$conn->error;
}


?>