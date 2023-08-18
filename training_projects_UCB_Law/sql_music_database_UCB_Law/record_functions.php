<?php 
function get_artist($artist_id)
{
    $conn = new mysqli("localhost","root","","musicDB");
    $sql = "SELECT id, artist_name FROM music_artist WHERE id ='{$artist_id}';";

    try{
        $result = $conn->query($sql);
        $ret_val = "";
        if($result-> num_rows > 0){
            while($row = $result->fetch_assoc()){
            $ret_val = $row["artist_name"];
            }   
        }
        return $ret_val;
    }catch(Exception $e){
        echo "Error in getting Data: ".$conn->error;
    }
}

function get_artist_id($artist)
{
    echo "Inside get_artist_id";
    $conn = new mysqli("localhost","root","","musicDB");
    $sql = "SELECT id, artist_name FROM music_artist WHERE artist_name='{$artist}';";

    try{
        $result = $conn->query($sql);
        $ret_val = "";
        if($result-> num_rows > 0){
            while($row = $result->fetch_assoc()){
            $ret_val = $row["id"];
            }   
        }
        return $ret_val;
    }catch(Exception $e){
        echo "Error in getting Data: ".$conn->error;
    }
}

/// Potentially Later, rewriting this so that it changes by ID instead of the album
function update_artist_id($album, $artist_id){
    $conn = new mysqli("localhost","root","","musicDB");
    $sql = "UPDATE music_album SET artist_id = $artist_id WHERE album_name = '{$album}';";

    try{
        $conn->multi_query($sql)===TRUE;  
    }catch(Exception $e){
        echo "Error in updating Data: ".$conn->error;
    }
}

function update_artist_id_by_album_id($id, $artist_id){
    $conn = new mysqli("localhost","root","","musicDB");
    $sql = "UPDATE music_album SET artist_id = $artist_id WHERE id = $id;";

    try{
        $conn->multi_query($sql)===TRUE;  
    }catch(Exception $e){
        echo "Error in updating Data: ".$conn->error;
    }
}

function is_artist_recorded($artist_name){
    $conn = new mysqli("localhost","root","","musicDB");
    $sql = "SELECT 1 FROM music_artist WHERE artist_name = '{$artist_name}';";

    try{
        $result = $conn->query($sql);
        if($result-> num_rows > 0){
            return True;
        } else {
            return False;
        }
    }catch(Exception $e){
        echo "Error in updating Data: ".$conn->error;
    }
}

function is_album_and_artist_recorded($artist_name,$album_name){
    
    $conn = new mysqli("localhost","root","","musicDB");
    $artist_id = get_artist_id($artist_name);
    $sql = "SELECT 1 FROM music_album WHERE artist_id = $artist_id AND album_name ='{$album_name}';";
    echo "<br>$sql";
    try{
        $result = $conn->query($sql);
        if($result-> num_rows > 0){
            return True;
        } else {
            return False;
        }
    }catch(Exception $e){
        echo "Error in updating Data: ".$conn->error;
    }
}


?>