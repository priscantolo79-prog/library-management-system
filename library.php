<?php 
// 1. DATABASE CONNECTION FIRST
include 'includes/db.php'; 

// 2. DEFINE VARIABLES
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// 3. INCLUDE THE NAVBAR
include 'includes/navbar.php'; 
?>

<div style="width: 100%; display: flex; flex-direction: column; align-items: center; padding-top: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <div class="container" style="width: 90%; max-width: 1200px;">
        
        <?php if (isset($_GET['error'])): ?>
            <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; border: 1px solid #fecaca; font-weight: bold; margin-bottom: 20px; text-align: center;">
                <?php 
                    if($_GET['error'] == 'limit_reached') echo "⚠️ Limit Reached: This friend already has 3 books. They must return one first!";
                    else echo "❌ Error: Something went wrong with the database.";
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 8px; border: 1px solid #bbf7d0; font-weight: bold; margin-bottom: 20px; text-align: center;">
                ✅ Success: The book has been lent out successfully!
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 2rem; color: #1e293b; margin-bottom: 10px;">Digital Bookshelf</h2>
            <p style="color: #64748b; margin-bottom: 20px;">Browse your collection and manage loans</p>
            
            <form action="library.php" method="GET" style="display: inline-flex; background: #f1f5f9; border-radius: 50px; padding: 5px 20px; border: 1px solid #e2e8f0; width: 100%; max-width: 500px;">
                <input type="text" name="search" placeholder="Search by title or author..." value="<?php echo htmlspecialchars($search); ?>" style="border: none; background: transparent; padding: 10px; width: 100%; outline: none;">
                <button type="submit" style="background: none; border: none; cursor: pointer;">🔍</button>
            </form>
        </div>

        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 25px; width: 100%;">
            <?php
            // Fetch friends once to avoid heavy looping
            $friends_list = [];
            $friends_res = $conn->query("SELECT * FROM Friends ORDER BY FullName ASC");
            if ($friends_res) {
                while($f = $friends_res->fetch_assoc()) { $friends_list[] = $f; }
            }

            // Fetch Books
            $sql = "SELECT * FROM Books WHERE Title LIKE '%$search%' OR Author LIKE '%$search%' ORDER BY Title ASC";
            $res = $conn->query($sql);

            if ($res && $res->num_rows > 0) {
                while($book = $res->fetch_assoc()) {
                    $status_color = ($book['Status'] == 'Available') ? '#10b981' : '#f59e0b';
                    $b_id = $book['BookID'];
                    ?>
                    
                    <div style="flex: 0 1 280px; background: white; padding: 25px; border-radius: 15px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span style="background: <?php echo $status_color; ?>20; color: <?php echo $status_color; ?>; padding: 5px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">
                                <?php echo $book['Status']; ?>
                            </span>
                            <h3 style="margin: 15px 0 5px; font-size: 1.2rem; color: #1e293b;"><?php echo htmlspecialchars($book['Title']); ?></h3>
                            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">by <?php echo htmlspecialchars($book['Author']); ?></p>
                        </div>
                        
                        <?php if($book['Status'] == 'Available'): ?>
                            <button onclick="document.getElementById('modal-<?php echo $b_id; ?>').style.display='flex'" style="width: 100%; background: #4f46e5; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.3s;">Lend Book</button>
                        <?php else: ?>
                            <button disabled style="width: 100%; background: #f1f5f9; color: #94a3b8; border: none; padding: 12px; border-radius: 8px; cursor: not-allowed;">On Loan</button>
                        <?php endif; ?>
                    </div>

                    <div id="modal-<?php echo $b_id; ?>" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15, 23, 42, 0.7); z-index:9999; justify-content:center; align-items:center; backdrop-filter: blur(4px);">
                        <div style="background:white; padding:35px; border-radius:16px; width:90%; max-width:400px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                            <h3 style="margin-bottom:5px; color: #1e293b;">Lend Book</h3>
                            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 25px;">Giving: <strong><?php echo htmlspecialchars($book['Title']); ?></strong></p>
                            
                            <form action="lend_book.php" method="POST">
                                <input type="hidden" name="book_id" value="<?php echo $b_id; ?>">
                                
                                <label style="display:block; margin-bottom:8px; font-weight: 600; font-size: 0.85rem;">Select Friend</label>
                                <select name="friend_id" required style="width:100%; padding:12px; margin-bottom:20px; border-radius:8px; border:1px solid #cbd5e1; background: #f8fafc;">
                                    <?php if(empty($friends_list)): ?>
                                        <option disabled>Please add a friend first!</option>
                                    <?php else: ?>
                                        <?php foreach($friends_list as $friend): ?>
                                            <option value="<?php echo $friend['FriendID']; ?>"><?php echo htmlspecialchars($friend['FullName']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <label style="display:block; margin-bottom:8px; font-weight: 600; font-size: 0.85rem;">Due Date</label>
                                <input type="date" name="due_date" required style="width:100%; padding:12px; margin-bottom:25px; border-radius:8px; border:1px solid #cbd5e1; background: #f8fafc;">

                                <div style="display:flex; gap:12px;">
                                    <button type="button" onclick="document.getElementById('modal-<?php echo $b_id; ?>').style.display='none'" style="flex:1; background:#f1f5f9; border:none; padding:12px; border-radius:8px; font-weight: 600; cursor:pointer;">Cancel</button>
                                    <button type="submit" name="lend_book" style="flex:2; background:#4f46e5; color:white; border:none; padding:12px; border-radius:8px; font-weight: 600; cursor:pointer;">Confirm Loan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<div style='text-align:center; padding:50px; width:100%; color: #94a3b8;'>No books found in your library yet.</div>";
            }
            ?>
        </div>
    </div>
</div>