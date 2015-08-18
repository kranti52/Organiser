<?PHP
namespace App\Entity;

use PHPMentors\DomainKata\Entity\EntityInterface;

class NotesEntity implements EntityInterface {
    protected $notes_id = null;
    protected $user_id = null;
    protected $user_username = null;
    protected $title = null;
    protected $created_at = null;
    protected $updated_at = null;
    protected $status = null;
    protected $content = null;

    public function setProperties($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function getNotesId() {
        return $this->notes_id;
    }
    public function setNotesId($notes_id) {
        $this->notes_id= $notes_id;
    }
    
    public function getContent() {
        return $this->content;
    }
    public function setContent($content) {
        $this->content= $content;
    }
    
    public function getUserName() {
        return $this->user_username;
    }
    public function setUserName($user_username) {
        $this->user_username= $user_username;
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
    
    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status= $status;
    }
    
    
}