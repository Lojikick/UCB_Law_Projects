<?php
$conn = new mysqli("localhost","root","","musicDB");
$id = $conn->real_escape_string($_POST['id']);//Double check with prev project how this was done
//Include checks for if user puts in artist not in
$sql = "DELETE FROM music_album WHERE id='{$id}';";
      //Mark the Item in the table as False
      //Delete the item from the main table
    
//"DELETE FROM musicTab WHERE id='{$id}';
        //CREATE TABLE tempMusic AS SELECT id, artist, album FROM musicTab;
        //DELETE FROM musicTab;
        //ALTER TABLE `musicTab` AUTO_INCREMENT=0;
        //INSERT INTO musicTab (artist, album) SELECT artist, album FROM tempMusic ORDER BY id ASC;
        //SELECT * FROM musicTab;
        //";
        //Dont worry about ID incrementation
        //Just there behind the scenes, don't care what is there, dont maintain it
        //Maintain the data in the the table by marking if the user interacts with it or not
        
try{
  $conn->multi_query($sql)===TRUE;
}catch(Exception $e){
  echo "Error in Deleting Data: ".$conn->error;
}
#To take care of Indexing error:
#Create a new table as a backup of main table
#Delete all data from main table
#Reset identity column(Numbers)
#Re-Insert Data from backup table to main table
?>
