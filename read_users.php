<?php
include 'db.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Name: " . $row['name'] . " - Email: " . $row['email'] . " - Verified: " . $row['is_email_verified'] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
