<?php

require_once "User.php";

$roles = array(
    array('Id'=>1, 'Name'=>'System Administrator', 'Parent'=>0),
    array('Id'=>2, 'Name'=>'Location Manager', 'Parent'=>1),
    array('Id'=>3, 'Name'=>'Supervisor', 'Parent'=>2),
    array('Id'=>4, 'Name'=>'Employee', 'Parent'=>3),
    array('Id'=>5, 'Name'=>'Trainer', 'Parent'=>3)
);

$userArr= array(
    array( "Id"=>1, "Name"=>"Adam Admin", "Role"=>1),
    array( "Id"=>2, "Name"=>"Emily Employee", "Role"=>4),
    array( "Id"=>3, "Name"=>"Sam Supervisor", "Role"=>3),
    array( "Id"=>4, "Name"=>"Mary Manager", "Role"=>2),
    array( "Id"=>5, "Name"=>"Steve Trainer", "Role"=>5)
);


$user = new User();
$user->setRoles(json_encode($roles));
$user->setUsers(json_encode($userArr));
$userId = 1;
$userName="Adam Admin";

if(isset($_POST['id']))
{
    $userId = $_POST['id'];
}
if(isset($_POST['name']))
{
    $userName = $_POST['name'];
}
$subordinates= $user->getSubOrdinates($userId);

$output = sprintf("<strong>Subordinates for UserID: %d, Name: %s: </strong><br> %s",$userId,$userName, $subordinates);
if(empty(json_decode($subordinates)))
{
    $output= sprintf("<strong>There are no subordinates for userID: %d Name: %s</strong>",$userId, $userName);
}
echo $output; exit;
