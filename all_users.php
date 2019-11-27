<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All users</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<?php

$host = 'localhost';
$port = '3306';
$db = 'my_activities';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo $e->getMessage() ;
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

?>

<h1>All Users</h1>

<form action="all_users.php" method="get">
    Choix d'une lettre : <br/>
    <input type="text" name="lettre"> <br/>
    Choix d'un status : <br/>
    <select name="status">
        <option value="2">Active account</option>
        <option value="1">Waiting for account validation</option>
    </select> <br/>

    <input type="submit" name="Envoie">

</form>

<?php
    
    if(isset($_GET["lettre"]) && isset($_GET["status"])) {
        $start_latter = $_GET["lettre"];
        $status_id = (int)$_GET["status"];
        $stmt = $pdo->prepare("select users.id as user_id, username,    email, s.name as status
                from users
                join status s
                on users.status_id = s.id
                where username like ? and status_id = ?
                order by username");
        $stmt->execute([$start_latter."%", $status_id]);




    } else {

    	$sql = "select users.id as user_id, username, email, s.name as status
                from users
                join status s
                on users.status_id = s.id
                order by users.id";

        $stmt = $pdo->query($sql);
        
    }
    	
    		
    
?>
<table>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Email</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $stmt->fetch()) { ?>
    <tr>
        <td><?php echo $row['user_id']?></td>
        <td><?php echo $row['username']?></td>
        <td><?php echo $row['email']?></td>
        <td><?php echo $row['status']?></td>
    </tr>
    <?php } ?>
</table>


</body>
</html>