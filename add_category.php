<?php 
include 'includes/db.php'; 
include 'includes/navbar.php'; 

// 1. Handle the form submission
if (isset($_POST['add_cat'])) {
    $cat_name = $conn->real_escape_string($_POST['category_name']);
    
    // Check if it already exists to prevent duplicates
    $check = $conn->query("SELECT * FROM Categories WHERE CategoryName = '$cat_name'");
    if ($check->num_rows == 0) {
        $sql = "INSERT INTO Categories (CategoryName) VALUES ('$cat_name')";
        $conn->query($sql);
        header("Location: add_category.php?success=1");
        exit();
    } else {
        header("Location: add_category.php?error=exists");
        exit();
    }
}
?>

<div style="width: 100%; display: flex; justify-content: center; align-items: center; min-height: 85vh; font-family: 'Segoe UI', sans-serif; background-color: #f8fafc; padding: 20px 0;">
    <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 450px; border: 1px solid #e2e8f0;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #1e293b; margin-bottom: 8px;">Manage Categories</h2>
            <p style="color: #64748b; font-size: 0.9rem;">Organize your books by genre or topic</p>
        </div>

        <form action="add_category.php" method="POST" style="margin-bottom: 30px;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 0.85rem;">New Category Name</label>
                <input type="text" name="category_name" required placeholder="e.g. Science Fiction" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
            </div>

            <button type="submit" name="add_cat" style="width: 100%; background: #6366f1; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s;">
                ➕ Create Category
            </button>
        </form>

        <div style="border-top: 1px solid #f1f5f9; pt: 20px;">
            <h4 style="font-size: 0.85rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 15px;">Existing Categories</h4>
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <?php
                $res = $conn->query("SELECT * FROM Categories ORDER BY CategoryName ASC");
                if ($res && $res->num_rows > 0) {
                    while($cat = $res->fetch_assoc()) {
                        echo "<span style='background: #f1f5f9; color: #475569; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; border: 1px solid #e2e8f0;'>{$cat['CategoryName']}</span>";
                    }
                } else {
                    echo "<p style='color: #cbd5e1; font-size: 0.85rem;'>No categories added yet.</p>";
                }
                ?>
            </div>
        </div>

    </div>
</div>