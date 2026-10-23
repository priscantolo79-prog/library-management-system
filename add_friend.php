<?php 
include 'includes/db.php'; 
include 'includes/navbar.php'; 

if (isset($_POST['add_friend'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "INSERT INTO Friends (Name, Email) VALUES ('$name', '$email')";
    if ($conn->query($sql)) {
        header("Location: library.php?success=friend_added");
    }
}
?>

<div style="width: 100%; display: flex; justify-content: center; align-items: center; min-height: 80vh; font-family: 'Segoe UI', sans-serif; background-color: #f8fafc;">
    <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 450px; border: 1px solid #e2e8f0;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #1e293b; margin-bottom: 8px;">Register a Friend</h2>
            <p style="color: #64748b; font-size: 0.9rem;">Who's borrowing your books today?</p>
        </div>

        <form action="add_friend.php" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 0.85rem;">Full Name</label>
                <input type="text" name="name" required placeholder="e.g. Jane Doe" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 0.85rem;">Email Address</label>
                <input type="email" name="email" required placeholder="jane@example.com" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
            </div>

            <button type="submit" name="add_friend" style="width: 100%; background: #10b981; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;">
                🤝 Add Friend
            </button>
        </form>
    </div>
</div>