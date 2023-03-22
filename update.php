<?php
include 'connection.php';

$collection = $db->tbl_users;

$user_id = $_POST['user_id'];
$post_data['name'] = strip_tags(trim($_POST['name']));
$post_data['email'] = strip_tags(trim($_POST['email']));

$insert_user = $collection->updateOne(
                              [ '_id' => new MongoDB\BSON\ObjectId($user_id) ],
                              [ '$set' => $post_data]
                           );

echo $insert_user->getMatchedCount();