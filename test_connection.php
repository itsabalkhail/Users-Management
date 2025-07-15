
<?php
require_once 'config.php';

echo "<h2>Database Connection Test</h2>";

try {
    // Test connection
    $conn = getConnection();
    echo "<p style='color: green;'>✅ Successfully connected to database!</p>";
    
    // Test table existence
    $stmt = $conn->prepare("SHOW TABLES LIKE 'users'");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✅ Table 'users' exists!</p>";
        
        // Test table structure
        $stmt2 = $conn->prepare("DESCRIBE users");
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        
        echo "<h3>Table 'users' structure:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Column Name</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        
        while ($row = $result2->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Count existing data
        $stmt3 = $conn->prepare("SELECT COUNT(*) as count FROM users");
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $count = $result3->fetch_assoc()['count'];
        
        echo "<p style='color: blue;'>📊 Number of existing users: <strong>$count</strong></p>";
        
        // Show first 5 users
        $stmt4 = $conn->prepare("SELECT * FROM users LIMIT 5");
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        
        if ($result4->num_rows > 0) {
            echo "<h3>First 5 users:</h3>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Status</th><th>Created At</th></tr>";
            
            while ($row = $result4->fetch_assoc()) {
                $status = $row['status'] == 1 ? 'Active' : 'Inactive';
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . $row['age'] . "</td>";
                echo "<td>" . $status . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
        
    } else {
        echo "<p style='color: red;'>❌ Table 'users' does not exist! Make sure to run the SQL code to create the table.</p>";
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Connection error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Server Information:</h3>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>MySQL Extension:</strong> " . (extension_loaded('mysqli') ? 'Available' : 'Not Available') . "</p>";

// Test database settings
echo "<h3>Database Settings:</h3>";
echo "<p><strong>Host:</strong> " . DB_HOST . "</p>";
echo "<p><strong>Database:</strong> " . DB_NAME . "</p>";
echo "<p><strong>User:</strong> " . DB_USER . "</p>";
?></p>";
        
        // عرض أول 5 مستخدمين
        $stmt4 = $conn->prepare("SELECT * FROM users LIMIT 5");
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        
        if ($result4->num_rows > 0) {
            echo "<h3>أول 5 مستخدمين:</h3>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>الاسم</th><th>العمر</th><th>الحالة</th><th>تاريخ الإنشاء</th></tr>";
            
            while ($row = $result4->fetch_assoc()) {
                $status = $row['status'] == 1 ? 'نشط' : 'غير نشط';
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . $row['age'] . "</td>";
                echo "<td>" . $status . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
        
    } else {
        echo "<p style='color: red;'>❌ جدول users غير موجود! تأكد من تنفيذ الكود SQL لإنشاء الجدول.</p>";
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ خطأ في الاتصال: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>معلومات الخادم:</h3>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>MySQL Extension:</strong> " . (extension_loaded('mysqli') ? 'متاح' : 'غير متاح') . "</p>";

// اختبار إعدادات قاعدة البيانات
echo "<h3>إعدادات قاعدة البيانات:</h3>";
echo "<p><strong>Host:</strong> " . DB_HOST . "</p>";
echo "<p><strong>Database:</strong> " . DB_NAME . "</p>";
echo "<p><strong>User:</strong> " . DB_USER . "</p>";
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f5f5f5;
    }
    
    table {
        background-color: white;
        padding: 10px;
        margin: 10px 0;
    }
    
    th {
        background-color: #007bff;
        color: white;
        padding: 8px;
    }
    
    td {
        padding: 8px;
    }
    
    h2, h3 {
        color: #333;
    }
</style>

<p><a href="index.php">← العودة إلى الصفحة الرئيسية</a></p>