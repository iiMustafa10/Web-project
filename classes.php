<?php

abstract class user{
    
    public $id;
    public $name;
    public $email;
    public $phone;
    protected $password;
    public $created_at;
    public $updated_at;
    function __construct($id,$name,$email,$password,$phone,$created_at,$updated_at)
    {
        $this ->id =$id;
        $this ->name =$name;
        $this ->email =$email;
        $this ->phone =$phone;
        $this ->created_at =$created_at;
        $this ->updated_at =$updated_at;
    }
    

        public static function login ($email , $password)
        {
            $user=null; 
             $qry ="SELECT * FROM  USERD WHERE email='$email' AND password='$password'";
             require_once('config.php');
             $cn=mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
             $rslt=mysqli_connect($cn,$qry);
             if ($arr=mysqli_fetch_assoc($rslt)) {
                switch($arr["role"])
                {
                    case 'subscriber';
                    $user= new subscriber($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["created_at"],$arr["updated_at"]);
                    break;
                    case 'admin';
                    $user= new Admin($arr["id"],$arr["name"],$arr["email"],$arr["password"],$arr["phone"],$arr["created_at"],$arr["updated_at"]);
                }
             }
             mysqli_close($cn);
             return $user;
        }

    

}
class subscriber extends user{

    
    public $role = "subscriber";
   
    
    public static function register($name,$email,$password,$phone){
        $qry ="INSERT INTO TABLE USERS (name,email,password,phone)
        VALUES ('$name','$email','$password','$phone')" ;
        require_once('config.php');
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt=mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;


    }
    public function store_post($title , $content,$imagepath,$user_id){
        $qry="INSERT INTO POSTS(tile , content , image,user_id) VALUES '$title','$content','$imagepath',''$user_id";
        require_once('config.php');
        $cn=mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt=mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rslt;
    }
    public function my_posts($user_id)
    {
        $qry="SELECT FROM POSTS WHERE USER_ID=$user_id ORDER BY CREATED_AT DESC";
        require_once('config.php');
        $cn=mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD,DB_NAME);
        $rslt=mysqli_query($cn,$qry);
        $data=mysqli_fetch_all($rslt,MYSQL_ASSOC);
        mysqli_close($cn);
        return $data; 
        
    }


}


class Admin extends user{ 
 
    public $role = "admin";


}