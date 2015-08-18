<?PHP
namespace App\Entity;

use PHPMentors\DomainKata\Entity\EntityInterface;

class EventEntity implements EntityInterface {
    protected $id = null;
    protected $user_id = null;
    protected $username = null;
    protected $title = null;
    protected $created_at = null;
    protected $updated_at = null;
    protected $title_status = null;
    protected $event_name = null;
    protected $event_status= null;
    protected $description = null;

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
    
    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description= $description;
    }
    
    public function getUserName() {
        return $this->username;
    }
    public function setUserName($username) {
        $this->username= $username;
    }
    
    public function getUserId() {
        return $this->user_id;
    }
    public function setUserId($user_id) {
        $this->user_id= $user_id;
    }
    
    
    
    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title= $title;
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
    
    public function getTitleStatus() {
        return $this->title_status;
    }
    public function setTitleStatus($title_status) {
        $this->title_status= $title_status;
    }
    
    public function getEventName() {
        return $this->event_name;
    }
    public function setEventName($event_name) {
        $this->event_name= $event_name;
    }
    public function getEventStatus() {
        return $this->event_status;
    }
    public function setEventStatus($event_status) {
        $this->event_status= $event_status;
    }
    
    
}