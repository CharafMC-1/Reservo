<?php

// ---------- SECURITY HEADERS ----------
header("Content-Type: application/json");
header("Content-Security-Policy: default-src 'self'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

// ---------- SESSION START ----------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
$table = isset($_GET['table']) ? $_GET['table'] : '';

// ---------- LOGIN HANDLING ----------
if ($table === 'login' && $method === 'POST') {
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';

    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode(['error' => 'Username and password are required']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied: admin only']);
            exit;
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        echo json_encode(['message' => 'Login successful', 'csrf_token' => $_SESSION['csrf_token']]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
    }
    exit;
}

// ---------- LOGOUT HANDLING ----------
if ($table === 'logout' && $method === 'POST') {
    session_unset();
    session_destroy();
    echo json_encode(['message' => 'Logged out successfully']);
    exit;
}

// ---------- CSRF PROTECTION ----------
if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
    $csrfTokenHeader = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $csrfTokenHeader) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
}

// ---------- ROUTING ----------
switch ($method) {
    case 'GET':
        handleGet($pdo, $table);
        break;
    case 'POST':
        handlePost($pdo, $table, $input);
        break;
    case 'PUT':
        handlePut($pdo, $table, $input);
        break;
    case 'DELETE':
        handleDelete($pdo, $table, $input);
        break;
    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}

// ---------- HANDLERS ----------
function handleGet($pdo, $table) {
    $sql = "SELECT * FROM " . $table;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

function handlePost($pdo, $table, $input) {
    switch ($table) {
        case 'rooms':
            $sql = "INSERT INTO rooms (name, capacity, features, location, availability) VALUES (:name, :capacity, :features, :location, :availability)";
            break;
        case 'mom':
            $sql = "INSERT INTO mom (meeting_id, user_id, action_item, decisions, discussion_points) VALUES (:meeting_id, :user_id, :action_item, :decisions, :discussion_points)";
            break;
        case 'meetings':
            $sql = "INSERT INTO meetings (title, agenda, date_time) VALUES (:title, :agenda, :date_time)";
            break;
        case 'bookings':
            $sql = "INSERT INTO bookings (user_id, room_id, meeting_id, start_time, end_time, time_slot, date) VALUES (:user_id, :room_id, :meeting_id, :start_time, :end_time, :time_slot, :date)";
            break;
        case 'attendance':
            $sql = "INSERT INTO attendance (user_id, meeting_id) VALUES (:user_id, :meeting_id)";
            break;
        case 'users':
            $input['password'] = password_hash($input['password'], PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
            break;
        default:
            echo json_encode(['message' => 'Invalid table']);
            return;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($input);
    echo json_encode(['message' => 'Record created successfully']);
}

function handlePut($pdo, $table, $input) {
    switch ($table) {
        case 'rooms':
            $sql = "UPDATE rooms SET name = :name, capacity = :capacity, features = :features, location = :location, availability = :availability WHERE id = :id";
            break;
        case 'mom':
            $sql = "UPDATE mom SET meeting_id = :meeting_id, user_id = :user_id, action_item = :action_item, decisions = :decisions, discussion_points = :discussion_points WHERE id = :id";
            break;
        case 'meetings':
            $sql = "UPDATE meetings SET title = :title, agenda = :agenda, date_time = :date_time WHERE id = :id";
            break;
        case 'bookings':
            $sql = "UPDATE bookings SET user_id = :user_id, room_id = :room_id, meeting_id = :meeting_id, start_time = :start_time, end_time = :end_time, time_slot = :time_slot, date = :date WHERE id = :id";
            break;
        case 'attendance':
            break;
        case 'users':
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized']);
                return;
            }

            $userId = $_SESSION['user_id'];

            // Check current password
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($input['currentPassword'], $user['password'])) {
                echo json_encode(['error' => 'Current password incorrect']);
                return;
            }

            $params = [
                'username' => $input['username'],
                'id' => $userId
            ];

            $sql = "UPDATE users SET username = :username";

            if (!empty($input['password'])) {
                $sql .= ", password = :password";
                $params['password'] = password_hash($input['password'], PASSWORD_BCRYPT);
            }

            $sql .= " WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            echo json_encode(['message' => 'Record updated successfully']);
            return;

        default:
            echo json_encode(['message' => 'Invalid table']);
            return;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($input);
    echo json_encode(['message' => 'Record updated successfully']);
}

function handleDelete($pdo, $table, $input) {
    if ($table === 'users' && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $input['id']) {
        echo json_encode(['error' => 'You cannot delete your own account while logged in']);
        return;
    } else {
        $sql = "DELETE FROM " . $table . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $input['id']]);
        echo json_encode(['message' => 'Record deleted successfully']);
    }
}
