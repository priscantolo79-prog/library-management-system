<?php
include 'includes/db.php';

if (isset($_POST['lend_book'])) {
    // Sanitize inputs
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $friend_id = $conn->real_escape_string($_POST['friend_id']);
    $due_date = $conn->real_escape_string($_POST['due_date']);

    // --- THE LIMIT RULE ---
    // Count how many books this friend currently has (where DateReturned is NULL)
    $check_query = "SELECT COUNT(*) as active_loans FROM Loans WHERE FriendID = '$friend_id' AND DateReturned IS NULL";
    $result = $conn->query($check_query);
    $data = $result->fetch_assoc();

    if ($data['active_loans'] >= 3) {
        // BLOCKED: Friend already has 3 books
        header("Location: library.php?error=limit_reached");
        exit();
    } else {
        // PROCEED: Friend is under the limit
        $conn->begin_transaction(); // Ensure both updates happen together

        try {
            // 1. Insert into Loans
            $conn->query("INSERT INTO Loans (BookID, FriendID, DateBorrowed, DueDate) 
                          VALUES ('$book_id', '$friend_id', NOW(), '$due_date')");
            
            // 2. Update Book Status
            $conn->query("UPDATE Books SET Status = 'Borrowed' WHERE BookID = '$book_id'");

            $conn->commit();
            header("Location: library.php?success=lent");
        } catch (Exception $e) {
            $conn->rollback();
            header("Location: library.php?error=db_error");
        }
    }
} else {
    header("Location: library.php");
}
?>