
<?php
require_once 'config.php';

// التحقق من وجود بيانات POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // تنظيف البيانات المدخلة
    $name = sanitizeInput($_POST['name']);
    $age = (int)$_POST['age'];
    
    // Validate input data
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    } elseif (strlen($name) < 2) {
        $errors[] = "Name must be more than 1 character";
    } elseif (strlen($name) > 100) {
        $errors[] = "Name is too long";
    }
    
    if ($age < 1 || $age > 120) {
        $errors[] = "Age must be between 1 and 120";
    }
    
    // If no errors, insert data
    if (empty($errors)) {
        $conn = getConnection();
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (name, age, status) VALUES (?, ?, 0)");
        $stmt->bind_param("si", $name, $age);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            
            // Redirect with success message
            header("Location: index.php?success=1");
            exit();
        } else {
            $stmt->close();
            $conn->close();
            
            // Redirect with error message
            header("Location: index.php?error=database");
            exit();
        }
    } else {
        // Redirect with error messages
        $errorMsg = implode(", ", $errors);
        header("Location: index.php?error=" . urlencode($errorMsg));
        exit();
    }
} else {
    // Redirect if request is not POST
    header("Location: index.php");
    exit();
}
?>