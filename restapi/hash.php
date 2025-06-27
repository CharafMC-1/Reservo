<?php
include 'db.php';

// Get all users
$stmt = $pdo->query("SELECT ID, password FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $id = $user['ID'];
    $password = $user['password'];

    // Skip if already hashed (starts with $2y$)
    if (strpos($password, '$2y$') === 0) {
        continue;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $update = $pdo->prepare("UPDATE users SET password = :hashed WHERE ID = :id");
    $update->execute([
        'hashed' => $hashed,
        'id' => $id
    ]);

    echo "Updated user ID $id<br>";
}

echo "Done hashing passwords.";
?>
