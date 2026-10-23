<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<div id="mySidebar" style="height: 100%; width: 0; position: fixed; z-index: 2000; top: 0; left: 0; background-color: #111827; overflow-x: hidden; transition: 0.4s; padding-top: 60px; font-family: sans-serif; box-shadow: 5px 0 15px rgba(0,0,0,0.3);">
    <a href="javascript:void(0)" onclick="closeNav()" style="position: absolute; top: 10px; right: 25px; font-size: 36px; color: #4b5563; text-decoration: none;">&times;</a>
    
    <div style="padding: 10px 32px; color: #6366f1; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; font-weight: bold;">Navigation</div>
    <a href="index.php" style="padding: 15px 32px; text-decoration: none; font-size: 1.1rem; color: #e2e8f0; display: block; transition: 0.3s;">🏠 Dashboard</a>
    <a href="library.php" style="padding: 15px 32px; text-decoration: none; font-size: 1.1rem; color: #e2e8f0; display: block; transition: 0.3s;">📚 Bookshelf</a>
    <a href="history.php" style="padding: 15px 32px; text-decoration: none; font-size: 1.1rem; color: #e2e8f0; display: block; transition: 0.3s;">📜 Loan History</a>
    
    <div style="padding: 30px 32px 10px; color: #6366f1; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; font-weight: bold;">Management</div>
    <a href="add_book.php" style="padding: 15px 32px; text-decoration: none; font-size: 1.1rem; color: #e2e8f0; display: block;">➕ Add Book</a>
    <a href="add_friend.php" style="padding: 15px 32px; text-decoration: none; font-size: 1.1rem; color: #e2e8f0; display: block;">👤 Add Friend</a>
    <a href="add_category.php" style="padding: 15px 32px; text-decoration: none; font-size: 1.1rem; color: #e2e8f0; display: block;">📁 Add Category</a>
</div>

<nav style="width: 100%; background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 12px 0; font-family: sans-serif; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
        
        <div style="display: flex; align-items: center; gap: 20px;">
            <button onclick="openNav()" style="background: none; border: none; cursor: pointer; display: flex; flex-direction: column; gap: 4px; padding: 5px;">
                <div style="width: 20px; height: 2px; background: #334155;"></div>
                <div style="width: 20px; height: 2px; background: #334155;"></div>
                <div style="width: 20px; height: 2px; background: #334155;"></div>
            </button>
            <a href="index.php" style="text-decoration: none; font-weight: 800; font-size: 1.4rem; color: #4f46e5; letter-spacing: -0.5px;">MyLibrary</a>
        </div>

        <div style="flex-grow: 1; display: flex; justify-content: center; padding: 0 40px;">
            
        </div>

        <div style="display: flex; align-items: center; gap: 10px; color: #64748b; font-size: 0.85rem; white-space: nowrap;">
            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
            Active
        </div>

    </div>
</nav>

<script>
function openNav() { document.getElementById("mySidebar").style.width = "280px"; }
function closeNav() { document.getElementById("mySidebar").style.width = "0"; }
</script>