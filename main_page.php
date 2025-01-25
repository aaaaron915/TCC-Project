<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
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
            width: 600px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .nav-buttons a {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }

        .nav-buttons a:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Inventory Management</h2>
    <div class="nav-buttons">
        <a href="add_product.php">Add Product</a>
        <a href="edit_product.php">Edit Product</a>
        <a href="dlt_product.php">Delete Product</a>
        <a href="logout.php">Logout</a>
    </div>

    <h2>Product List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>\${$row['price']}</td>
                        <td>{$row['stock']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No products available</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
