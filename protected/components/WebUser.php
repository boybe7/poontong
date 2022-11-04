<?php
// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

// Store model to not repeat query.
private $_model;

// Return
// access it by Yii::app()->user->username
function getUsername(){
    $user = $this->loadUser(Yii::app()->user->id);
    if(empty($user))
        return false;
    else
        return $user->username;
   // return $user->title." ".$user->firstname." ".$user->lastname;
}
// access it by Yii::app()->user->title
function getTitle(){
    $user = $this->loadUser(Yii::app()->user->id);
    if(empty($user))
        return false;
    else
        return $user->title;
    
}
// access it by Yii::app()->user->firstname
function getName(){
    $user = $this->loadUser(Yii::app()->user->id);
    if(empty($user))
        return false;
    else
        return $user->name;
    
}
// access it by Yii::app()->user->lastname
function getLastName(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->lastname;
    
}

function getSite(){
    $user = $this->loadUser(Yii::app()->user->id);
    if(empty($user))
        return false;
    else
        return $user->site_id;
    
}
// access it by Yii::app()->user->usertype
function getUsertype(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if(Yii::app()->user->id == 0)
    {  
        
        return "guest";     
    }
    else    
         return "user";
}

// This is a function that checks the field 'role'
// in the User model to be equal to 1, that means it's admin
// Yii::app()->user->isGuest
// Yii::app()->user->isAdmin()
// Yii::app()->user->isDoctor()
// Yii::app()->user->isNurse()
// Yii::app()->user->isCashier()
 function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->id);
    if(empty($user))
        return false;
    else
        return UserGroup::model()->findByPk($user->user_group_id)->name == "admin";
    //return UserModule::isAdmin();
  }

function isSuperUser(){
    $user = $this->loadUser(Yii::app()->user->id);
     if(empty($user))
        return false;
    else
        return $user->user_group_id == "2";
}

function isUserV2(){
    $user = $this->loadUser(Yii::app()->user->id);
     if(empty($user))
        return false;
    else
        return $user->department_id == 2;
}

function isUser(){
    $user = $this->loadUser(Yii::app()->user->id);
     if(empty($user))
        return false;
    else
        return $user->user_group_id == "3";
}
function isExecutive(){
    $user = $this->loadUser(Yii::app()->user->id);
     if(empty($user))
        return false;
    else
        return UserGroup::model()->findByPk($user->user_group_id)->group_name == "executive";
}

function getGroup(){
    $user = $this->loadUser(Yii::app()->user->id);
     if(empty($user))
        return false;
    else
        return $user->user_group_id;
}

function getAccess($url){
    $url = str_replace(Yii::app()->getBaseUrl(false), "", $url);
    $str = explode("/", $url);
     $url = $str[1];
     $user_group = Yii::app()->user->getGroup();
    $sql = "SELECT * FROM authen LEFT JOIN  menu ON authen.menu_id=menu.id WHERE url LIKE '%$url%' AND user_group_id='$user_group'";
    // //echo $sql;
     $command = Yii::app()->db->createCommand($sql);
    $result = $command->queryAll();

    $access = !empty($result) && $result[0]["access"]==2 ? true : false;


    return $access;
}



function isAccess($url){
  
    $user_group = Yii::app()->user->getGroup();
    $sql = "SELECT * FROM authen LEFT JOIN  menu ON authen.menu_id=menu.id WHERE url LIKE '%$url%' AND user_group_id='$user_group'";
    // //echo $sql;
    $command = Yii::app()->db->createCommand($sql);
    $result = $command->queryAll();

    $access = !empty($result)  ? true : false;
    $is_admin = !empty(Yii::app()->user) && Yii::app()->user->isAdmin() ? true : false;
    if($url == '/user/index' && $is_admin)
        $access = true;
    return $access;
}


// Load user model.
protected function loadUser($id=null)
{
    if($this->_model===null)
    {
        if($id!==null)
            $this->_model=User::model()->findByPk($id);
     
    }
    return $this->_model;
}

}
?>
