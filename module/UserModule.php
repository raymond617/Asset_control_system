<?php

require_once('/../functions/connectDB.php');
$pdo = connectDB();

function getProfessorNameM($prof_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT username FROM lts_users where id = ?');
    $stmt->execute(array($prof_id));
    $profName = $stmt->fetchAll();
    return $profName;
}
