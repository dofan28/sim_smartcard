<?php 
function getAllLogs($db)
{
    $sql = "SELECT * FROM logs";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function storeLog($db, $uid){

    $sql = "INSERT INTO logs (uid, created_at, updated_at) VALUES (:uid, NOW(), NOW())";
    
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":uid", $uid);

    return $stmt->execute();
}

function getLogLastUID($db) {
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