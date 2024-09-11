<?php
header('Content-Type: application/json');

// Database connection details
$host = 'localhost';
$db   = 'ticket_booking';
$user = 'your_mysql_username';
$pass = 'your_mysql_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Prepare data for insertion
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $event = $_POST['event'];
    $date = $_POST['date'];
    $tickets = $_POST['tickets'];

    // Prepare SQL and bind parameters
    $stmt = $pdo->prepare("INSERT INTO bookings (name, email, phone, event, date, tickets) VALUES (:name, :email, :phone, :event, :date, :tickets)");
    
    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':event', $event);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':tickets', $tickets);

    // Execute the prepared statement
    $stmt->execute();

    // Send a success response
    echo json_encode(['success' => true, 'message' => 'Booking successful!']);
} catch (PDOException $e) {
    // If there's an error, send it back to the client
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}