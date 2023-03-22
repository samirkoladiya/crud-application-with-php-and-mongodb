<?php
include 'connection.php';
$tbl_user = $db->tbl_users;

$search = trim($_POST["search"]["value"]);

$length = intval($_POST['length']);
$start 	= intval($_POST['start']);

if(isset($_POST["order"]))
{  
    $sortField = $_POST['order']['0']['column'];
    if($sortField==0)
    {
    	$sortField = 'name';
    }
    else if($sortField==1)
    {
    	$sortField = 'email';
    }
    else
    {
    	$sortField = 'created_at';
    }
	$sortOrder = ($_POST['order']['0']['dir']=='asc') ? '1' : '-1';
}  
else  
{  
    $sortField = 'created_at';
	$sortOrder = '-1';
}

$recordsTotal = count(iterator_to_array($tbl_user->find()));

if($search)
{  
   	$fetch_data = $tbl_user->find([
									'$or' => [
										["email" => new \MongoDB\BSON\Regex($search)],
										["name" => new \MongoDB\BSON\Regex($search)]
									]
								],
								[
								'sort' => [$sortField => intval($sortOrder)], 
								'limit' => $length,
								'skip' => $start,
							]);
   	$recordsFiltered = count(iterator_to_array( $tbl_user->find([
							'$or' => [
								["email" => new \MongoDB\BSON\Regex($search)],
								["name" => new \MongoDB\BSON\Regex($search)]
							]
						]) ));
}
else
{
	$fetch_data = $tbl_user->find([],[
								'sort' => [$sortField => intval($sortOrder)], 
								'limit' => $length,
								'skip' => $start,
							]);
	$recordsFiltered 	= $recordsTotal;
}

$data = array();

foreach($fetch_data as $row)
{  
    $sub_array = array();
    
    $sub_array[] = $row->name;
    $sub_array[] = $row->email;
    $sub_array[] = '<a class="btn btn-primary" href="edit.php?id='.$row->_id.'">Edit</a>';
    $sub_array[] = '<a class="btn btn-primary" href="javascript:void(0)" onclick="delete_user(\''.$row->_id.'\');">Delete</a>';
 
	$data[] = $sub_array;
}  

$output = array(
    "draw"            => intval($_POST["draw"]),
    "recordsTotal"    => $recordsTotal,
    "recordsFiltered" => $recordsFiltered,
    "data"            => $data
);

echo json_encode($output);