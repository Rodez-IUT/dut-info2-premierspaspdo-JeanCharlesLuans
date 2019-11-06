<?php 
	
	// Connection a la BD
$host = 'localhost';
$db = 'my_activities';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
     throw new PDOException($e->getMessage(), (int)$e->getCode());
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>All User</title>
</head>
<body>
	<td>
		<tr> ID </tr>
		<tr> USERNAME </tr>
		<tr> EMAIL </tr>
		<tr> STATUS </tr>
	</td>
	<td>
		<?php

			$stmt = $pdo ->query('SELECT * FROM users JOIN status ON user.status_id = status.id;');

			while ($row = $stmt->fetch()) {
				echo "<tr>". $row['id'] ."</td>";
				echo "<tr>". $row['username'] ."</td>";
				echo "<tr>". $row['email'] ."</td>";
				echo "<tr>". $row['name'] ."</td>";
			}
		 ?>


	</td>

</body>
</html>