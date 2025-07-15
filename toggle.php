
<?php
require_once 'config.php';

// Set JSON response header
header('Content-Type: application/json');

// Check for POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    
    $id = (int)$_POST['id'];
    
    // Validate ID
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        exit();
    }
    
    $conn = getConnection();
    
    // Get current status
    $stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $currentStatus = $row['status'];
        $newStatus = $currentStatus == 1 ? 0 : 1;
        
        $stmt->close();
        
        // Update status
        $updateStmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $updateStmt->bind_param("ii", $newStatus, $id);
        
        if ($updateStmt->execute()) {
            $updateStmt->close();
            $conn->close();
            
            // Prepare text and class for response
            $statusText = $newStatus == 1 ? 'Active' : 'Inactive';
            $statusClass = $newStatus == 1 ? 'status-active' : 'status-inactive';
            
            echo json_encode([
                'success' => true,
                'status' => $newStatus,
                'status_text' => $statusText,
                'status_class' => $statusClass
            ]);
        } else {
            $updateStmt->close();
            $conn->close();
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    } else {
        $stmt->close();
        $conn->close();
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>