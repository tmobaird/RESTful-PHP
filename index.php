<?php
$user_name = "root";
$password = "steelbull";
$database = "coralShop";
$server = "0.0.0.0";
// Create connection
$conn = mysql_connect($server, $user_name, $password);
// Check connection
$db_found = mysql_select_db($database, $conn);
if($db_found){
        //echo "Database Foundi</br>";
}
else {
        //echo "Database Not Found";
}
//Done connecting to database


$type = $_SERVER['REQUEST_METHOD'];
$paths = $_SERVER['REQUEST_URI'];
$resource = explode("/", $paths);

//$queryOne = "SELECT price FROM conchForSale where name=$name";
$resourceNew = next($resource);
if ($resourceNew == 'corals') {
        $name = next($resource);
    if ($type=='GET' && empty($name)) { //All in list
        $answer=mysql_query("SELECT * FROM coralForSale;");
        while($row = mysql_fetch_array($answer)){
                $data = "ID:".$row{'id'}." Name:".$row{'name'}." Price:".$row{'price'};
                $response=deliver_response(200, "Coral found", $data);
                echo $response, "\n";
        }
    }
    elseif($type=='GET' && !empty($name)){ //Getting specific corals
        $answer=mysql_query("SELECT * FROM coralForSale where name='$name';");
        echo $answer;
        if (mysql_num_rows($answer) > 0) {
                while($row = mysql_fetch_array($answer)){
                        $data = "ID:".$row{'id'}." Name:".$row{'name'}." Price:".$row{'price'};
                        $response=deliver_response(200, "Coral found", $data);
                        echo $response, "\n";
                }
        }
        else {
                $response=deliver_response(404, "Coral Not Found", NULL);
                echo $response, "\n";
        }
    }

    elseif($type == 'PUT') {
        //$this->handle_name($method, $name);
        parse_str(file_get_contents("php://input"),$post_vars);
        $price=$post_vars['price'];
        $price = ltrim ($price, '$');
        $first=mysql_query("SELECT * FROM coralForSale WHERE name='$name';");
        if (mysql_num_rows($first) > 0) {
                $response=deliver_response(409, "Coral Has Already Been Added", NULL);
                echo $response, "\n";
        }
        else {
                $data = "Name: $name, Price: $price";
                $sql = "INSERT INTO coralForSale (name, price) VALUES ('$name', '$price')";
                $answer=mysql_query($sql);
                $response=deliver_response(201, "Coral Created", $data);
                echo $response, "\n";
        }
    }
    elseif($type == 'DELETE') {
        //Delete element
        $data = "Name: $name";
        $first=mysql_query("SELECT * FROM coralForSale WHERE name='$name';");
        if (mysql_num_rows($first) > 0) {
                $answer=mysql_query("DELETE FROM coralForSale WHERE name='$name';");
                $response=deliver_response(201, "Coral Deleted", $data);
                echo $response, "\n";
        }
        else {
                echo "That Coral Does Not Exist\n";
        }
    }
    else {
        echo "Invalid Operation Request\n";
    }

}
else {
    // We only handle resources under 'clients'
    header('HTTP/1.1 40$4 Not Found');
    echo "Not Found";
}

//Start of functions
function deliver_response($status, $statusMessage, $data){
        header("HTTP/1.1 $status $statusMessage");
        $response['status']=$status;
        $response['statusMessage']=$statusMessage;
        $response['data']=$data;

        $json_response=json_encode($response);
        return $json_response;
}
?>
