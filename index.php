
<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            direction: ltr;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .toggle-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .toggle-btn:hover {
            background-color: #218838;
        }
        
        .status-active {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>نظام إدارة المستخدمين</h2>
        
        <!-- مؤشر حالة الاتصال -->
        <div class="connection-status">
            <?php
            try {
                $conn = getConnection();
                echo "<div class='alert alert-success'>✅ متصل بقاعدة البيانات بنجاح</div>";
                $conn->close();
            } catch (Exception $e) {
                echo "<div class='alert alert-error'>❌ خطأ في الاتصال: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>
        
        <!-- نموذج إضافة مستخدم جديد -->
        <form method="POST" action="insert.php">
            <div class="form-group">
                <label for="name">الاسم:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="age">العمر:</label>
                <input type="number" id="age" name="age" min="1" max="120" required>
            </div>
            
            <input type="submit" value="إضافة مستخدم">
        </form>

        <!-- عرض البيانات -->
        <h3>قائمة المستخدمين</h3>
        
        <?php
        $conn = getConnection();
        
        // استعلام آمن مع prepared statement
        $stmt = $conn->prepare("SELECT id, name, age, status FROM users ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Status</th><th>Action</th></tr>";
            
            while($row = $result->fetch_assoc()) {
                $statusText = $row['status'] == 1 ? 'Active' : 'Inactive';
                $statusClass = $row['status'] == 1 ? 'status-active' : 'status-inactive';
                
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                echo "<td id='status-" . $row['id'] . "' class='" . $statusClass . "'>" . $statusText . "</td>";
                echo "<td><button class='toggle-btn' onclick='toggleStatus(" . $row['id'] . ")'>Toggle Status</button></td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No users found.</p>";
        }
        
        $stmt->close();
        $conn->close();
        ?>
    </div>

    <script>
        function toggleStatus(id) {
            // إرسال طلب AJAX
            fetch('toggle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // تحديث النص والفئة
                    const statusElement = document.getElementById('status-' + id);
                    statusElement.textContent = data.status_text;
                    statusElement.className = data.status_class;
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Connection error occurred');
            });
        }
    </script>
</body>
</html>