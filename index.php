<?php 
include 'includes/db.php'; 
include 'includes/navbar.php'; 

// 1. Fetch Stats
$total_books = $conn->query("SELECT COUNT(*) as count FROM Books")->fetch_assoc()['count'];
$total_friends = $conn->query("SELECT COUNT(*) as count FROM Friends")->fetch_assoc()['count'];
$loaned_books = $conn->query("SELECT COUNT(*) as count FROM Books WHERE Status = 'Borrowed'")->fetch_assoc()['count'];
$available_books = $total_books - $loaned_books;

// 2. Fetch Recent Activity (Last 5 loans)
$recent_loans = $conn->query("SELECT Books.Title, Friends.FullName, Loans.DateBorrowed 
                             FROM Loans 
                             JOIN Books ON Loans.BookID = Books.BookID 
                             JOIN Friends ON Loans.FriendID = Friends.FriendID 
                             ORDER BY Loans.DateBorrowed DESC LIMIT 5");
?>

<div style="width: 100%; display: flex; flex-direction: column; align-items: center; padding: 40px 0; font-family: 'Segoe UI', sans-serif; background-color: #f8fafc; min-height: 100vh;">
    
    <div class="container" style="width: 90%; max-width: 1000px;">
        
        <div style="margin-bottom: 30px;">
            <h2 style="color: #1e293b; margin-bottom: 5px;">Library Dashboard</h2>
            <p style="color: #64748b;">Overview of your collection and active loans.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
            
            <div style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <p style="color: #64748b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Books</p>
                <h3 style="font-size: 2rem; color: #1e293b; margin: 10px 0;"><?php echo $total_books; ?></h3>
            </div>

            <div style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <p style="color: #10b981; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Available</p>
                <h3 style="font-size: 2rem; color: #1e293b; margin: 10px 0;"><?php echo $available_books; ?></h3>
            </div>

            <div style="background: white; padding: 25px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <p style="color: #f59e0b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">On Loan</p>
                <h3 style="font-size: 2rem; color: #1e293b; margin: 10px 0;"><?php echo $loaned_books; ?></h3>
            </div>

            <div style="background: white; padding: 25px