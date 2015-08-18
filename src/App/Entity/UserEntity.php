<?PHP
namespace App\Entity;

use PHPMentors\DomainKata\Entity\EntityInterface;

class UserEntity implements EntityInterface {
    protected $id = null;
    protected $name = null;
    protected $email = null;
    protected $username = null;
    protected $profile_pic_url = null;
    protected $created_at = null;
    protected $updated_at = null;
    protected $login_id = null;

    public function setProperties($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id= $id;
    }
    
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name= $name;
    }
    
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email= $email;
    }
    
    public function getUsername() {
        return $this->username;
    }
    public function setUsername($username) {
        $this->username= $username;
    }
    
    public function getProfilePicUrl() {
        return $this->profile_pic_url;
    }
    public function setProfilePicUrl($profile_pic_url) {
        $this->profile_pic_url= $profile_pic_url;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    public function setCreatedAt($created_at) {
        $this->created_at= $created_at;
    }
    
    public function getUpdatedAt() {
        return $this->created_at;
    }
    public function setUpdatedAt($updated_at) {
        $this->updated_at= $updated_at;
    }
    
    public function getLoginId() {
        return $this->login_id;
    }
    public function setLoginId($login_id) {
        $this->login_id= $login_id;
    }
    
    
}