<?php

function getAllStudents($db)
{
    $sql = "SELECT * FROM students";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStudents($db, $limit, $offset, $search = '')
{
    $sql = "SELECT * FROM students";

    if (!empty($search)) {
        $sql .= " WHERE uid LIKE :search 
                  OR nis LIKE :search 
                  OR email LIKE :search 
                  OR full_name LIKE :search 
                  OR class LIKE :search 
                  OR address LIKE :search 
                  OR phone LIKE :search 
                  OR status LIKE :search";
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);

    if (!empty($search)) {
        $stmt->bindValue(":search", "%$search%", PDO::PARAM_STR);
    }

    $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalStudents($db, $search = '')
{
    $sql = "SELECT COUNT(*) as total FROM students";

    if (!empty($search)) {
        $sql .= " WHERE uid LIKE :search 
                  OR nis LIKE :search 
                  OR email LIKE :search 
                  OR full_name LIKE :search 
                  OR class LIKE :search 
                  OR address LIKE :search 
                  OR phone LIKE :search 
                  OR status LIKE :search";
    }

    $stmt = $db->prepare($sql);

    if (!empty($search)) {
        $stmt->bindValue(":search", "%$search%", PDO::PARAM_STR);
    }

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}


function getLimitedStudents($db)
{
    $sql = "SELECT * FROM students LIMIT 4";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function storeStudent($db, $uid, $nis, $email, $full_name, $class, $address, $phone, $status)
{
    $sql = "INSERT INTO students (uid, nis, email, full_name, class, address, phone, status, created_at, updated_at) 
            VALUES (:uid, :nis, :email, :full_name, :class, :address, :phone, :status, NOW(), NOW())";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':uid', $uid);
    $stmt->bindParam(':nis', $nis);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':status', $status);

    return $stmt->execute();
}

function updateStudent($db, $id, $uid, $nis, $email, $full_name, $class, $address, $phone, $status)
{
    $sql = "UPDATE students 
            SET uid = :uid, nis = :nis, full_name = :full_name, email = :email, class = :class, 
                address = :address, phone = :phone, status = :status, updated_at = NOW() 
            WHERE id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':uid', $uid);
    $stmt->bindParam(':nis', $nis);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
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

function getStudentByUID($db, $uid)
{
    $stmt = $db->prepare("SELECT * FROM students WHERE uid = :uid AND status = 'active'");
    $stmt->execute(['uid' => $uid]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
