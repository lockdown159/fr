<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
session_start();
include_once "../database/database_fr.php";
if(isset($_GET["logout"])&& isset($_SESSION["uuid'"])){
    session_destory();
    unset($_SESSION);
}
$username = "No active user";
    if(isset($_SESSION["uuid"])){
        $username = $_SESSION["username"];
        if(isset($_POST["submit"])){
            $squery = "INSERT INTO list (user_uuid, message, uuid) VALUES (?,?,?)";
            $uuid = uuidv4();
            if($statement = $db->prepare($squery)){
                $statement->bind_param("sss", $_SESSION["uuid"], $_POST["item"], $uuid);
                $statement->execute();
                $statement->close();
        }
    }
}
?>

<html>
    <head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

        <title> First Robotics Volunteer Management System</title>
        <h1> First Robotics Volunteer Management System</h1>
    </head>

    <body>
    <a href= "../fr/login.php">LogIn</a><br/>


    <!-- <a href= "../CRUD/logout.php">Logout</a><br/> -->
    <br/>
    <hr/>

    <?php
    echo '<ul>';
    if(isset($_SESSION["uuid"])){
        $query = "SELECT * FROM list WHERE user_uuid=?";
        if($statement = $db->prepare($query)){
            $statement->bind_param("s", $_SESSION["uuid"]);
            $statement->execute();
            $result = $statement->get_result();
            if($result->num_rows >0){
                while($row   = $result->fetch_assoc()) {
                    echo '<li>' .$row["message"] . '<li>';
                }
            }else{
                echo "No items in list";
            }
        }
        echo '</ul>';
        
        echo '<form action= "" method ="post">
                <input type="text" placeholder="New Item" name="item/>
                <button name="submit"> Add Item</button>
             </form> </br>
                ';
    }
        ?>
    </body>
</html>