<?php
    require 'connection.php';

    function fetchMenu($conn, $id){
        $query = "SELECT 
        tbl_menu.*,
        tbl_categories.name as category_name
        FROM tbl_menu
        INNER JOIN tbl_categories ON tbl_menu.category_id = tbl_categories.category_id WHERE menu_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return  $result->fetch_assoc();
    }

    function updateMenu($conn, $name, $category, $price, $description, $id){
       $sqlQuery = "UPDATE tbl_menu SET name = ?, category_id = ?, price = ?, description = ? WHERE menu_id = ?";
       $stmt = $conn->prepare($sqlQuery);
       $stmt->bind_param("sidsi", $name, $category, $price, $description, $id);
       $result = $stmt->execute();
       if($result){
           header("Location:index.php");
           exit();
       }

    }

    function selectCategory($conn, $id){
        $query = "SELECT category_id, name FROM tbl_categories WHERE category_id <> ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return $result;
        }
        return null;
    }   
    

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $menu_id = $_GET['id'];
        $row = fetchMenu($conn, $menu_id);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['updateMenu'])){
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $id = $_GET['id'];

        updateMenu($conn, $name, $category, $price, $description, $id);

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
                <input type="text" id="name" name="name" value="<?= $row['name'] ?>" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter name">
            </div>
            <div class="mb-6">
                <label for="Category" class="block text-gray-700 font-bold mb-2">Category</label>
                <select id="Category" name="category" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="<?= $row['category_id'] ?>" ><?= $row['category_name'] ?></option>
                        <?php $category = selectCategory($conn, $row['category_id']);
                            while($categoryRow = $category->fetch_assoc()) : ?>
                            <option value="<?= $categoryRow['category_id'] ?>" ><?= $categoryRow['name'] ?></option>
                        <?php endwhile ?> 
                </select>
            </div>
            <div class="mb-6">
                <label for="Price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" id="Price" name="price" value="<?= $row['price'] ?>" step="any" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter item price">
            </div>
            <div class="mb-6">
                <label for="Description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea id="Description" name="description" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter description"><?= $row['description'] ?></textarea>
            </div>
            <div class="flex justify-between">
                <button type="submit"  name="updateMenu" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Save changes</button>
                <a href="index.php" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Cancel</a>
            </div>
        </form>
    
</body>
</html>