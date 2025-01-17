<?php

function getAllStudents($db)
{
    $sql = "SELECT * FROM students";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLimitedStudents($db)
{
    $sql = "SELECT * FROM students LIMIT 4";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function storeStudent($db, $uid, $nis, $full_name, $class, $address, $status)
{
    $sql = "INSERT INTO students (uid, nis, full_name, class, address, status, created_at, updated_at) 
            VALUES (:uid, :nis, :full_name, :class, :address, :status, NOW(), NOW())";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':uid', $uid);
    $stmt->bindParam(':nis', $nis);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':status', $status);

    return $stmt->execute();
}

function updateStudent($db, $id, $uid, $nis, $full_name, $class, $address, $status)
{
    $sql = "UPDATE students 
            SET uid = :uid, nis = :nis, full_name = :full_name, class = :class, 
                address = :address, status = :status, updated_at = NOW() 
            WHERE id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':uid', $uid);
    $stmt->bindParam(':nis', $nis);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':status', $status);

    return $stmt->execute();
}

function deleteStudent($db, $id)
{
    $sql = "DELETE FROM students WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

function getStudentById($db, $id)
{
    $sql = "SELECT * FROM students WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}

function getStudentByUID($db, $uid) {
    $stmt = $db->prepare("SELECT * FROM students WHERE uid = :uid AND status = 'active'");
    $stmt->execute(['uid' => $uid]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}