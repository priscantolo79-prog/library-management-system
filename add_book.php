<?php 
include 'includes/db.php'; 
include 'includes/navbar.php'; 

// Logic to handle the form submission
if (isset($_POST['add_book'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $category = $conn->real_escape_string($_POST['category']);

    $sql = "INSERT INTO Books (Title, Author, Category, Status) VALUES ('$title', '$author', '$category', 'Available')";
    if ($conn->query($sql)) {
        header("Location: library.php?success=added");
    }
}
?>

<div style="width: 100%; display: flex; justify-content: center; align-items: center; min-height: 80vh; font-family: 'Segoe UI', sans-serif; background-color: #f8fafc;">
    <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 450px; border: 1px solid #e2e8f0;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #1e293b; margin-bottom: 8px;">Add New Book</h2>
            <p style="color: #64748b; font-size: 0.9rem;">Expand your digital collection</p>
        </div>

        <form action="add_book.php" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 0.85rem;">Book Title</label>
                <input type="text" name="title" required placeholder="e.g. The Pragmatic Programmer" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none; transition: border 0.3s;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 0.85rem;">Author Name</label>
                <input type="text" name="author" required placeholder="e.g. Andy Hunt" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 0.85rem;">Category</label>
                <select name="category" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; background: #fff;">
                    <option value="Tech">Tech</option>
                    <option value="Fiction">Fiction</option>
                    <option value="Romance">Romance</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <button type="submit" name="add_book" style="width: 100%; background: #4f46e5; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem; transition: background 0.3s;">
                ✨ Add to Library
            </button>
        </form>
    </div>
</div>