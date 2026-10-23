<?php 
  include 'includes/db.php'; 
  include 'includes/navbar.php'; 

  //  Handle Return Action
  if (isset($_GET['return_id']) && isset($_GET['book_id'])) {
      $loan_id = (int)$_GET['return_id'];
      $book_id = (int)$_GET['book_id'];
      $today = date('Y-m-d');
      $conn->query("UPDATE Loans SET DateReturned = '$today' WHERE LoanID = $loan_id");
      $conn->query("UPDATE Books SET Status = 'Available' WHERE BookID = $book_id");
      echo "<div class='container'><p class='badge badge-available' style='display:block; text-align:center;'>✓ Book returned and history updated!</p></div>";
  }

  //  Query for ACTIVE LOANS
  $active_sql = "SELECT Loans.*, Books.Title, Friends.FullName 
                 FROM Loans 
                 JOIN Books ON Loans.BookID = Books.BookID 
                 JOIN Friends ON Loans.FriendID = Friends.FriendID 
                 WHERE Loans.DateReturned IS NULL ORDER BY Loans.DueDate ASC";
  $active_res = $conn->query($active_sql);

  //  Query for COMPLETED HISTORY (The Track Record)
  $history_sql = "SELECT Loans.*, Books.Title, Friends.FullName 
                  FROM Loans 
                  JOIN Books ON Loans.BookID = Books.BookID 
                  JOIN Friends ON Loans.FriendID = Friends.FriendID 
                  WHERE Loans.DateReturned IS NOT NULL ORDER BY Loans.DateReturned DESC";
  $history_res = $conn->query($history_sql);
?>

<div style="width: 100%; display: flex; justify-content: center;">
<div class="container">
    <h2 style="display: flex; align-items: center; gap: 10px;">🕒 Active Loans</h2>
    <div class="table-container" style="margin-bottom: 50px;">
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Borrowed By</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($active_res->num_rows > 0): 
                    while($row = $active_res->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo $row['Title']; ?></strong></td>
                        <td><?php echo $row['FullName']; ?></td>
                        <td><?php echo $row['DueDate']; ?></td>
                        <td>
                            <a href="history.php?return_id=<?php echo $row['LoanID']; ?>&book_id=<?php echo $row['BookID']; ?>" 
                               style="background: #fee2e2; color: #b91c1c; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 600;">
                               Confirm Return
                            </a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="4" style="text-align:center; padding: 20px; color: var(--text-muted);">No active loans.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h2 style="display: flex; align-items: center; gap: 10px;">📜 Completed History</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr style="background: #f8fafc;">
                    <th>Book</th>
                    <th>Borrowed By</th>
                    <th>Date Borrowed</th>
                    <th>Date Returned</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($history_res->num_rows > 0): 
                    while($row = $history_res->fetch_assoc()): ?>
                    <tr style="opacity: 0.8;">
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['FullName']; ?></td>
                        <td><?php echo $row['DateBorrowed']; ?></td>
                        <td><?php echo $row['DateReturned']; ?></td>
                        <td><span class="badge badge-available">Returned</span></td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 20px; color: var(--text-muted);">No history yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>