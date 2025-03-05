<?php
function getAllLogs($db)
{
    $sql = "SELECT * FROM logs";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllLogPaginated($db, $limit, $offset, $search = '')
{
    $sql = "SELECT * FROM logs";

    if (!empty($search)) {
        $sql .= " WHERE uid LIKE :search 
                  OR created_at LIKE :search 
                  OR updated LIKE :search";
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

function getTotalLogs($db, $search = '')
{
    $sql = "SELECT COUNT(*) as total FROM logs";

    if (!empty($search)) {
        $sql .= " WHERE uid LIKE :search 
        OR created_at LIKE :search 
        OR updated LIKE :search";
    }

    $stmt = $db->prepare($sql);

    if (!empty($search)) {
        $stmt->bindValue(":search", "%$search%", PDO::PARAM_STR);
    }

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}

function getLimitedlLogs($db)
{
    $sql = "SELECT * FROM logs LIMIT 6";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function storeLog($db, $uid)
{
    $sql = "INSERT INTO logs (uid, created_at, updated_at) VALUES (:uid, NOW(), NOW())";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(":uid", $uid);

    return $stmt->execute();
}

function getLogLastUID($db)
{
    $stmt = $db->prepare("SELECT uid FROM logs ORDER BY created_at DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['uid'] : '';
}

function deleteLog($db, $id)
{
    $sql = "DELETE FROM logs WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
