<?php
/**
 * Created by PhpStorm.
 * User: nita
 * Date: 7/10/2018
 * Time: 10:33 AM
 */

class User
{
    public $users=array();
    public $roles= array();

    public function __construct()
    {
    }

    public function setUsers($users)
    {
        $this->users= json_decode($users, true);
    }

    function setRoles($roles)
    {
        $this->roles = json_decode($roles, true);

    }

    public function getUsers()
    {
        return json_encode($this->users);
    }

    public function getRoles()
    {
        return json_encode($this->roles);
    }

    /**
     * @desc get all the subordinates of the given user
     * @param $userid
     * @return string
     */
    public function getSubOrdinates($userid)
    {
        $subordinates=array();

        //get userrole from array
        $userRole=  $this->getUserRole($userid);

       //get all the roles reporting to that role
        $getSubordinateRoles= $this->getSubordinateRoleTreeByParentId($this->roles, $userRole);

        $tRoles = [];
        $chRole=array();

        foreach($getSubordinateRoles as $sRole)
        {
            $tRoles[]= $sRole['Id'];
            //if child branch exists, iterate child  branch
            if(array_key_exists('children', $sRole))
            {
               $chRole= $this->getChildSubordinates($sRole['children']);
            }
        }
        $allRSubordinates= array_merge($tRoles, $chRole);

        foreach($allRSubordinates as $s)
        {   //get users who belongs to those roles
            foreach($this->users as $u)
            {
                if($u['Role']==$s)
                {
                    $subordinates[]=$u;
                }
            }
        }
       // echo "<pre>"; print_r($subordinates);

        return json_encode($subordinates);
    }

    /**
     * @desc get user role based on userid
     * @param $userid
     * @return mixed
     */
    public function getUserRole($userid)
    {
        foreach($this->users as $user)
        {
            if($user['Id']==$userid)
            {
                return $user['Role'];
            }
        }
    }


    /**
     * @desc create hierarchy tree for roles
     * @param array $roles
     * @param int $parentId
     * @return array
     */
    function getSubordinateRoleTreeByParentId(array $roles, $parentId=0) {

        $hierarchy=array();
        foreach ($roles as $role) {

            if ($role['Parent'] == $parentId) {
                //echo $role['Id'];
                $children = $this->getSubordinateRoleTreeByParentId($roles, $role['Id']);
                //echo "<pre>"; print_r($children);
                if ($children) {
                    $role['children'] = $children;

                }
                //echo "<pre>"; print_r($role);
                $hierarchy[] = $role;
            }
        }

        //var_dump($hierarchy);
        return $hierarchy;
    }

    /**
     * @desc iterate recursively to get all the children in the subordinate tree
     * @param array $array
     * @param array $flattened
     * @return array
     */
    function getChildSubordinates(array $array, $flattened=[]) {

        foreach ($array as $key => $value) {
            $flattened[] = $value['Id'];
            if (is_array($value) && array_key_exists('children', $value)){


                $flattened= $this->getChildSubordinates($value['children'], $flattened);
            }

        }
        return $flattened;
    }


}


