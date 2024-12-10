<?php
    require 'connection.php';
    function selectCategory($conn){
        $query = "SELECT category_id, name FROM tbl_categories";
        $result = $conn->query($query);
        if($result->num_rows > 0){
            return $result;
        }
    }
    
    function addNewMenu($conn, $name , $description, $category_id, $price){
        $query = "INSERT INTO tbl_menu (name, description, category_id, price) VALUES (?, ? , ? , ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssid',$name, $description, $category_id, $price );
        $stmt->execute();
        if($stmt->affected_rows > 0){
            header("location: index.php");
            exit();
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['submit'])){
        $name = $_POST['name'];
        $category_id = $_POST['Category'];
        $price = floatval($_POST['Price']);
        $description = $_POST['Description'];

        addNewMenu($conn, $name, $description, $category_id, $price);
       
    }


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-roboto">
    <div class="container mx-auto p-4">
        <form method="post" class="bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Add Menu</h1>

            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter item name">
            </div>
            <div class="mb-6">
                <label for="Category" class="block text-gray-700 font-bold mb-2">Category</label>
                <select id="Category" name="Category" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select category</option>
                        <?php $category = selectCategory($conn);
                            while($row = $category->fetch_assoc()) : ?>
                            <option value="<?= $row['category_id'] ?>" ><?= $row['name'] ?></option>
                        <?php endwhile ?> 
                </select>
            </div>
            <div class="mb-6">
                <label for="Price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" id="Price" name="Price" step="any" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter item price">
            </div>
            <div class="mb-6">
                <label for="Description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea id="Description" name="Description" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter item description"></textarea>
            </div>
            <div class="flex justify-between">
                <button type="submit" name="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Menu</button>
                <a href="index.php" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Cancel</a>
            </div>
        </form>
    
</body>
</html>