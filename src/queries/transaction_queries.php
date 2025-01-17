<?php

function getAllTransactions($db)
{
    $sql = "SELECT * FROM transactions";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTransactionJoinStudents($db)
{
    $sql = "
     SELECT transactions.id, transactions.student_id, transactions.date, transactions.check_in, transactions.check_out, students.full_name FROM transactions, students WHERE transactions.student_id = students.id
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getLimitedTransactionJoinStudents($db)
{
    $sql = "
     SELECT transactions.id, transactions.student_id, transactions.date, transactions.check_in, transactions.check_out, students.full_name FROM transactions, students WHERE transactions.student_id = students.id LIMIT 4
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function storeTransactions($db, $student_id, $date, $check_in, $check_out)
{
    $sql = "INSERT INTO transactions (student_id, date, check_in, check_out, created_at, updated_at) 
            VALUES (:student_id, :date, :check_in, :check_out, NOW(), NOW())";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':check_in', $check_in);
    $stmt->bindParam(':check_out', $check_out);

    return $stmt->execute();
}

function updateTransactions($db, $id, $studentId, $date, $check_in, $check_out)
{
    $sql = "UPDATE transactions 
            SET student_id = :student_id, date = :date, check_in = :check_in, check_out = :check_out,updated_at = NOW() 
            WHERE id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':student_id', $studentId);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':check_in', $check_in);
    $stmt->bindParam(':check_out', $check_out);

    return $stmt->execute();
}

function deleteTransaction($db, $id)
{
    $sql = "DELETE FROM transactions WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getTransactionById($db, $id)
{
    $sql = "
        SELECT transactions.*, students.uid, students.full_name, students.nis, students.class, students.address, students.status
        FROM transactions
        JOIN students ON transactions.student_id = students.id
        WHERE transactions.id = :id
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function handleTransaction($db, $studentId)
{
    $today = date('Y-m-d');
    $stmt = $db->prepare("SELECT * FROM transactions WHERE student_id = :student_id AND date = :date");
    $stmt->execute(['student_id' => $studentId, 'date' => $today]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createTransaction($db, $studentId)
{
    $stmt = $db->prepare("INSERT INTO transactions (student_id, date, check_in, created_at, updated_at) VALUES (:student_id, :date, :check_in, NOW(), NOW())");
    $stmt->execute([
        'student_id' => $studentId,
        'date' => date('Y-m-d'),
        'check_in' => date('Y-m-d H:i:s')
    ]);
}

function updateCheckout($db, $transactionId)
{
    $stmt = $db->prepare("UPDATE transactions SET check_out = :check_out, updated_at = NOW() WHERE id = :id");
    $stmt->execute([
        'check_out' => date('Y-m-d H:i:s'),
        'id' => $transactionId
    ]);
}
