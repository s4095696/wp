<?php
function get_recent_pets($limit = 5) {
    $conn = connect_db();
    $sql = "SELECT * FROM pets ORDER BY created_at DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $pets = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();

    return $pets;
}
