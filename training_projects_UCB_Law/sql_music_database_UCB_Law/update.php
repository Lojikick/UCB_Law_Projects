<?php
require __DIR__ . '/record_functions.php';
$conn = new mysqli("localhost","root","","musicDB");
//One additional step? SQL Injection, handled with prepared statements (Look up)
$artist = $conn->real_escape_string($_POST['art']);//Double check with prev project how this was done
$album = $conn->real_escape_string($_POST['alb']);
$id = $conn->real_escape_string($_POST['id']);
//Double check with prev project how this was done
$update_album_query = "UPDATE music_album SET album_name='{$album}' WHERE id='{$id}';";
$update_album_and_artist_query = "INSERT INTO music_artist (artist_name) VALUES ('{$artist}');
                                  UPDATE music_album SET album_name='{$album}' WHERE id = '{$id}';";
//$sql = "ALTER TABLE `musicTab` AUTO_INCREMENT=0;";
//Changes in Music tab should reflect musicstor

//If user inputs a NEW artist, and artist is not currently in database, create new record
//and update accordingly

//If user inputs an already existing artist/artist is the same, just replace with artist id in table

//If user changes album, just change the album

try{
  $artist_exists = is_artist_recorded($artist);
  $artist_and_album_exists = is_album_and_artist_recorded($artist,$album);
  if($artist_and_album_exists){
    echo "Artist and album already exists";
    //Handled it like this to prevent multiple records of the same artist name/ album. Is this alright?
  }elseif($artist_exists){
    echo "Artist already exists, new Album";
    $conn->multi_query($update_album_query)===TRUE; 
  }else{
    //Says that there is an sql syntax error, but the query updated the table as intended?? Show to devin
    echo "Artist doesnt exist, artist table updated";
    $conn->multi_query($update_album_and_artist_query)===TRUE; 
    $artist_id = get_artist_id($artist);
    update_artist_id($album,$artist_id);
  }
}catch(Exception $e){
  echo "Error in Update Data: ".$conn->error;
}
?>