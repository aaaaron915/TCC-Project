<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Reset and renumber the IDs
        $conn->query("SET @count = 0");
        $conn->query("UPDATE products SET id = (@count := @count + 1)");
        $conn->query("ALTER TABLE products AUTO_INCREMENT = 1");

        echo "<script>
            alert('Product deleted successfully!');
            window.location.href = 'main_page.php';
        </script>";
    } else {
        echo "<script>
            alert('Error deleting product.');
        </script>";
    }
}
// Fetch products for dropdown selection
$sql = "SELECT id, name FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .form-container button:hover {
            background: #c9302c;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Delete Product</h2>

    <form method="POST" class="form-container" onsubmit="return confirm('Are you sure you want to delete this product?')">
        <select name="id" required>
            <option value="">Select Product</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Delete</button>
    </form>
    <a href="main_page.php" class="btn">Back to Main Page</a>
</div>

</body>
</html>