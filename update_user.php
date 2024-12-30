<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET name = ?, email = ?, password_hashed = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $password_hashed, $id);

    if ($stmt->execute()) {
        echo "User updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!-- HTML Form to update user -->
<form method="POST">
    User ID: <input type="number" name="id" required><br>
    Name: <input  type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Update User">

</form>
