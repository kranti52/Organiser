<?PHP
namespace App\Repository;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\DBAL\Connection;
use App\Entity\UserEntity;
use PHPMentors\DomainKata\Entity\EntityInterface;

class UserRepository {
    private $db;
    public function __construct(Connection $db) {
        $this->db=$db;
    }
    public function find($id) {
        
    }
    
    public function buildUserEntity(Array $paramaters = array())
    {
        $entity = new UserEntity;
        $entity->setProperties($paramaters);
        return $entity;
    }
    
    public function findByLoginId($login_id) {
        $data = $this->db->fetchAssoc('SELECT * FROM user_info WHERE login_id = ?', array($login_id));
        return $data ? $this->buildUserEntity($data) : null;
    }
    
    public function findByUsername($username) {
        $data = $this->db->fetchAssoc('SELECT * FROM user_info WHERE username = ?', array($username));
        return $data ? $this->buildUserEntity($data) : null;
    }
    
    public function save(EntityInterface $user) {
          $userData = array(
            'login_id' => $user->getLoginId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'username' =>  $user->getUsername(),
        );
        if ($user->getId()) {
            $userData['updated_at'] = date("Y-m-d H:i:s", time());
            $userData['created_at'] = $user->getCreatedAt();
            $this->db->update('user_info', $userData, array('id' => $user->getId()));
        } 
        else {
            $userData['updated_at'] = date("Y-m-d H:i:s", time());
            $userData['created_at'] = date("Y-m-d H:i:s", time());
            $this->db->insert('user_info', $userData);
            $id = $this->db->lastInsertId();
            $user->setId($id);
        }
        return null;
    }
    
    
     
}