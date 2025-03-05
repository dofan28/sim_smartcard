<?php

function getAllTransactionTransports($db)
{
    $sql = "SELECT * FROM transactions";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTransactionTransportJoinStudents($db)
{
    $sql = "
        SELECT transactions.id, transactions.student_id, transactions.date, 
               transactions.check_in, transactions.check_out, students.full_name 
        FROM transactions 
        JOIN students ON transactions.student_id = students.id
        WHERE transactions.type_transaction = 'transportation'
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTransactionTransportJoinStudentPaginated($db, $limit, $offset, $search = '')
{
    $sql = "
    SELECT transactions.id, transactions.student_id, transactions.date, 
           transactions.check_in, transactions.check_out, students.full_name 
    FROM transactions 
    JOIN students ON transactions.student_id = students.id
    WHERE transactions.type_transaction = 'transportation'
    ";

    if (!empty($search)) {
        $sql .= " AND (
                   transactions.id LIKE :search 
                   OR transactions.date LIKE :search
                   OR transactions.check_in LIKE :search
                   OR transactions.check_out LIKE :search
                   OR students.uid LIKE :search 
                   OR students.nis LIKE :search 
                   OR students.email LIKE :search 
                   OR students.full_name LIKE :search 
                   OR students.class LIKE :search 
                   OR students.address LIKE :search 
                   OR students.phone LIKE :search 
                   OR students.status LIKE :search
               )";
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);

    if (!empty($search)) {
        $searchTerm = "%$search%";
        $stmt->bindParam(":search", $searchTerm, PDO::PARAM_STR);
    }

    $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalTransactionTransports($db, $search = '')
{
    $sql = "
    SELECT COUNT(*) as total 
    FROM transactions
    JOIN students ON transactions.student_id = students.id
    WHERE transactions.type_transaction = 'transportation'
    ";

    if (!empty($search)) {
        $sql .= " AND (
                   transactions.id LIKE :search 
                   OR transactions.date LIKE :search
                   OR transactions.check_in LIKE :search
                   OR transactions.check_out LIKE :search
                   OR students.uid LIKE :search 
                   OR students.nis LIKE :search 
                   OR students.email LIKE :search 
                   OR students.full_name LIKE :search 
                   OR students.class LIKE :search 
                   OR students.address LIKE :search 
                   OR students.phone LIKE :search 
                   OR students.status LIKE :search
               )";
    }

    $stmt = $db->prepare($sql);

    if (!empty($search)) {
        $searchTerm = "%$search%";
        $stmt->bindParam(":search", $searchTerm, PDO::PARAM_STR);
    }

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}


function storeTransactionTransports($db, $student_id, $date, $check_in, $check_out)
{
    $sql = "INSERT INTO transactions (student_id, type_transaction, date, check_in, check_out, created_at, updated_at) 
            VALUES (:student_id, 'transportation', :date, :check_in, :check_out, NOW(), NOW())";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':check_in', $check_in);
    $stmt->bindParam(':check_out', $check_out);

    return $stmt->execute();
}

function updateTransactionTransports($db, $id, $studentId, $date, $check_in, $check_out)
{
    $sql = "UPDATE transactions 
            SET student_id = :student_id, type_transaction = 'transportation',date = :date, check_in = :check_in, check_out = :check_out,updated_at = NOW() 
            WHERE id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':student_id', $studentId);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':check_in', $check_in);
    $stmt->bindParam(':check_out', $check_out);

    return $stmt->execute();
}

function deleteTransactionTransports($db, $id)
{
    $sql = "DELETE FROM transactions WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getTransactionTransportById($db, $id)
{
    $sql = "
        SELECT transactions.*, students.uid, students.full_name, students.nis, students.email, students.class, students.address,  students.phone, students.status
        FROM transactions
        JOIN students ON transactions.student_id = students.id
        WHERE transactions.id = :id
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function handleTransactionTransport($db, $studentId)
{
    $today = date('Y-m-d');
    $stmt = $db->prepare("SELECT * FROM transactions WHERE student_id = :student_id AND type_transaction = 'transportation' AND date = :date");
    $stmt->execute(['student_id' => $studentId, 'date' => $today]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createTransactionTransport($db, $studentId)
{
    $stmt = $db->prepare("INSERT INTO transactions (student_id, type_transaction, date, check_in, created_at, updated_at) VALUES (:student_id, :type_transaction, :date, :check_in, NOW(), NOW())");
    $stmt->execute([
        'student_id' => $studentId,
        'type_transaction' => 'transportation',
        'date' => date('Y-m-d'),
        'check_in' => date('Y-m-d H:i:s')
    ]);

    // Ambil ID dari data yang baru saja dimasukkan
    $lastId = $db->lastInsertId();

    // Ambil kembali data berdasarkan ID terakhir
    $stmt = $db->prepare("SELECT * FROM transactions WHERE id = :id");
    $stmt->execute(['id' => $lastId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCheckout($db, $transactionId)
{
    $stmt = $db->prepare("UPDATE transactions SET check_out = :check_out, updated_at = NOW() WHERE id = :id");
    $stmt->execute([
        'check_out' => date('Y-m-d H:i:s'),
        'id' => $transactionId
    ]);


    $stmt = $db->prepare("SELECT * FROM transactions WHERE id = :id");
    $stmt->execute(['id' => $transactionId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
