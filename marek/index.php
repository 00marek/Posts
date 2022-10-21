<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Zarządzanie Postami</h1>
        
        



        <?php

 



?>

<h4>
        Wybierz użytkowników lub posty
    </h4>
      

    <form method="post">


        

        
        <input type="submit" name="Dodawanie"
        value="Resetowanie postów do wartości początkowych"/>

        <input type="submit" name="postsList"
        value="Wyświetl posty z bazy danych"/>

        

        <input type="submit" name="postDelete"
        value="Usuń post z bazy danych"/>

        <input type="text" value="Podaj ID posta" name="number" />
        


        
    
      
</form>


    <?php

$delNumber = $_POST['number'];




$url = "https://jsonplaceholder.typicode.com/users";
$dataUsers = file_get_contents($url); 
//$users = json_decode($dataUsers); 

$users = json_decode($dataUsers, true);

//print_r($users); 


echo "<br>";
echo "---";
echo "<br>";

$url = "https://jsonplaceholder.typicode.com/posts";
$dataPosts = file_get_contents($url); 
//$posts = json_decode($dataPosts); 
$post = json_decode($dataPosts, true);




//print_r($posts); 


if(isset($_POST['postsList'])) {
    echo "Posty w bazie danych";

    $mysqlConnection = @mysqli_connect("localhost", "root", "vertrigo") or die(mysql_error());
    mysqli_select_db($mysqlConnection, "Marek") or die(mysql_error());
    
    mysqli_set_charset($mysqlConnection, "utf8");
    
    $query = "
                SELECT postID, userID, userName, Title, Body FROM Posty
            ";
            
            $result = mysqli_query($mysqlConnection, $query);
    
            if (mysqli_num_rows($result) > 0)
            {
                echo "ilość wierszy: ".mysqli_num_rows($result)."<br />";
                echo "ilość pól: ".mysqli_num_fields($result)."<br />";
            
            
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo "<table border='1' cellspacing='0' style='float: left; margin: 10px;'>";
                    echo "<tr><td>Id posta: ".$row['postID']."</td></tr>";
                    echo "<tr><td>Id użytkownika: ".$row['userID']."</td></tr>";
                    echo "<tr><td>Nazwa użytkownika: ".$row['userName']."</td></tr>";
                    echo "<tr><td>Tytuł posta: ".$row['Title']."</td></tr>";
                    echo "<tr><td>Treść posta: ".$row['Body']."</td></tr>";
                    echo "</table>";
                }
            
            
            }
            
    mysqli_query($mysqlConnection, $query);
    mysqli_close($mysqlConnection);


}
    

if(isset($_POST['Dodawanie'])) {
    echo "Zresetowano posty w tabeli";

    $mysqlConnection = @mysqli_connect("localhost", "root", "vertrigo") or die(mysql_error());
    mysqli_select_db($mysqlConnection, "Marek") or die(mysql_error());
    
    mysqli_set_charset($mysqlConnection, "utf8");
    
    $query ="
    
    TRUNCATE TABLE Posty
    
    ";
    
    mysqli_query($mysqlConnection, $query);
    mysqli_close($mysqlConnection);


for($i=0;$i<100; $i++)
    {
        
        $a=$post[$i]["id"];
        $b=$post[$i]["userId"];
        $c=$users[$post[$i]["userId"]-1]["name"];
        $d=$post[$i]["title"];
        $e=$post[$i]["body"];

        $mysqlConnection = @mysqli_connect("localhost", "root", "vertrigo") or die(mysql_error());
        mysqli_select_db($mysqlConnection, "Marek") or die(mysql_error());
        
        mysqli_set_charset($mysqlConnection, "utf8");
        
        $query ="
        
        INSERT INTO Posty (postID, userID, userName, Title, Body)
        VALUES
        ('$a', '$b', '$c', '$d', '$e')
        
        ";
        
        mysqli_query($mysqlConnection, $query) or die(mysql_error);
        mysqli_close($mysqlConnection);
        }   

        
        }
        
        

        if(isset($_POST['postDelete'])) {
            echo "usunięto post z tabeli";
        
            $mysqlConnection = @mysqli_connect("localhost", "root", "vertrigo") or die(mysql_error());
            mysqli_select_db($mysqlConnection, "Marek") or die(mysql_error());
            
            mysqli_set_charset($mysqlConnection, "utf8");
            
            $query ="
            
            DELETE FROM Posty WHERE postID = '$delNumber';
            
            ";
            
            mysqli_query($mysqlConnection, $query);
            mysqli_close($mysqlConnection);
        
        
              
                
                }


?>





    </body>
</html>
