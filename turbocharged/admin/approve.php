<?php
include '../includes/config.php';
$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("UPDATE client SET status = 'Approved' WHERE client_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

header('Location: client_requests.php');
exit;
