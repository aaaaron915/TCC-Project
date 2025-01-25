<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Find the next available ID manually
    $result = $conn->query("SELECT MAX(id) AS max_id FROM products");
    $row = $result->fetch_assoc();
    $next_id = $row['max_id'] ? $row['max_id'] + 1 : 1;

    $stmt = $conn->prepare("INSERT INTO products (id, name, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isdi", $next_id, $name, $price, $stock);

    if ($stmt->execute()) {
        echo "<script>
            alert('Product added successfully!');
            window.location.href = 'main_page.php';
        </script>";
    } else {
        echo "<script>
            alert('Error adding product.');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px -10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .form-container button:hover {
            background: #0056b3;
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
    <h2>Add Product</h2>
    <form method="POST" class="form-container">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <button type="submit">Add</button>
    </form>
    <a href="main_page.php" class="btn">Back to Main Page</a>
</div>

</body>
</html>
