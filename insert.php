<?php
include 'connection.php';

$collection = $db->tbl_users;

$post_date['name'] = strip_tags(trim($_POST['name']));
$post_date['email'] = strip_tags(trim($_POST['email']));
$post_date['created_at'] = date('Y-m-d H:i:s');

$insert_user = $collection->insertOne($post_date);

echo $insert_user->getInsertedCount();