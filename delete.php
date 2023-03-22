<?php
include 'connection.php';
$collection = $db->tbl_users;

$user_id = $_POST['user_id'];
$delete_user = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]);
echo $delete_user->getDeletedCount();