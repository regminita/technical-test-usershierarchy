<?php

/**
 * Created by PhpStorm.
 * User: nita
 * Date: 6/10/2018
 * Time: 5:53 PM
 */
use PHPUnit\Framework\TestCase;
require_once ('./app/User.php');
class UserTest extends TestCase
{

    public function testRolesCanBeSet()
    {
        $user = new User();

        $roles = array(
            array('Id'=>1, 'Name'=>'System Administrator', 'Parent'=>0),
            array('Id'=>2, 'Name'=>'Location Manager', 'Parent'=>1),
            array('Id'=>3, 'Name'=>'Supervisor', 'Parent'=>2),
            array('Id'=>4, 'Name'=>'Employee', 'Parent'=>3),
            array('Id'=>5, 'Name'=>'Trainer', 'Parent'=>3)
        );
       $user->setRoles(json_encode($roles));

       $this->assertEquals($user->getRoles(), json_encode($roles));
    }

    public function testUsersCanBeSet()
    {
        $user = new User();

        $users= array(
            array( "Id"=>1, "Name"=>"Adam Admin", "Role"=>1),
            array( "Id"=>2, "Name"=>"Emily Employee", "Role"=>4),
            array( "Id"=>3, "Name"=>"Sam Supervisor", "Role"=>3),
            array( "Id"=>4, "Name"=>"Mary Manager", "Role"=>2),
            array( "Id"=>5, "Name"=>"Steve Trainer", "Role"=>5)
        );
        $user->setUsers(json_encode($users));
        $this->assertEquals($user->getUsers(), json_encode($users));
    }

    public function testUserRoleIsReturnedByUserid()
    {
        $user = new User();
        $users= array(
            array( "Id"=>1, "Name"=>"Adam Admin", "Role"=>1),
            array( "Id"=>2, "Name"=>"Emily Employee", "Role"=>4),
            array( "Id"=>3, "Name"=>"Sam Supervisor", "Role"=>3),
            array( "Id"=>4, "Name"=>"Mary Manager", "Role"=>2),
            array( "Id"=>5, "Name"=>"Steve Trainer", "Role"=>5)
        );
        $user->setUsers(json_encode($users));

        $this->assertEquals($user->getUserRole(1), '1');
    }

    public function testGetSubordinatesWhenEmployeeIdIsThree()
    {
        $user = new User();
        $users= array(
            array( "Id"=>1, "Name"=>"Adam Admin", "Role"=>1),
            array( "Id"=>2, "Name"=>"Emily Employee", "Role"=>4),
            array( "Id"=>3, "Name"=>"Sam Supervisor", "Role"=>3),
            array( "Id"=>4, "Name"=>"Mary Manager", "Role"=>2),
            array( "Id"=>5, "Name"=>"Steve Trainer", "Role"=>5)
        );

        $roles = array(
            array('Id'=>1, 'Name'=>'System Administrator', 'Parent'=>0),
            array('Id'=>2, 'Name'=>'Location Manager', 'Parent'=>1),
            array('Id'=>3, 'Name'=>'Supervisor', 'Parent'=>2),
            array('Id'=>4, 'Name'=>'Employee', 'Parent'=>3),
            array('Id'=>5, 'Name'=>'Trainer', 'Parent'=>3)
        );

        $employeeId =3;
        $user->setRoles(json_encode($roles));
        $user->setUsers(json_encode($users));
        $resultArray =array(
          array(
              "Id"=>2,
              "Name"=>"Emily Employee",
              "Role"=>4
          ) ,
            array(
                "Id"=>5,
                "Name"=>"Steve Trainer",
                "Role"=>5
            )
        );

        $expectedOutput = json_encode($resultArray);

        $returnValue = $user->getSubOrdinates($employeeId);
        $this->assertEquals($returnValue, $expectedOutput);
    }

    public function testGetSubordinatesWhenEmployeeIdIsOne()
    {
        $user = new User();
        $users= array(
            array( "Id"=>1, "Name"=>"Adam Admin", "Role"=>1),
            array( "Id"=>2, "Name"=>"Emily Employee", "Role"=>4),
            array( "Id"=>3, "Name"=>"Sam Supervisor", "Role"=>3),
            array( "Id"=>4, "Name"=>"Mary Manager", "Role"=>2),
            array( "Id"=>5, "Name"=>"Steve Trainer", "Role"=>5)
        );

        $roles = array(
            array('Id'=>1, 'Name'=>'System Administrator', 'Parent'=>0),
            array('Id'=>2, 'Name'=>'Location Manager', 'Parent'=>1),
            array('Id'=>3, 'Name'=>'Supervisor', 'Parent'=>2),
            array('Id'=>4, 'Name'=>'Employee', 'Parent'=>3),
            array('Id'=>5, 'Name'=>'Trainer', 'Parent'=>3)
        );

        $employeeId =1;
        $user->setRoles(json_encode($roles));
        $user->setUsers(json_encode($users));
        $resultArray =array(
            array(
                "Id"=>4,
                "Name"=>"Mary Manager",
                "Role"=>2
            ),
            array(
                "Id"=>3,
                "Name"=>"Sam Supervisor",
                "Role"=>3
            ),
            array(
                "Id"=>2,
                "Name"=>"Emily Employee",
                "Role"=>4
            ) ,
            array(
                "Id"=>5,
                "Name"=>"Steve Trainer",
                "Role"=>5
            )

        );

        $expectedOutput = json_encode($resultArray);

        $returnValue = $user->getSubOrdinates($employeeId);
        $this->assertEquals($returnValue, $expectedOutput);
    }




}
