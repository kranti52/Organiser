<?PHP
namespace App\Usecase;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use App\Repository\UserRepository;

class UserUsecase {
    private $repository;
    public function __construct(UserRepository $user_repository) {
        $this->repository=$user_repository;
    }
    
    public function createUser(array $request)
    {
        $entity = $this->repository->buildUserEntity($request);
        $this->repository->save($entity);
        return $entity->getLoginId();
        
    }
    
    public function getUserByLoginId($id)
    {
        $entity = $this->repository->findByLoginId($id);
        if($entity===null){
            return null;
        }
         $user = array(
            'id' => $entity->getId(),
            'login_id' => $entity->getLoginId(),
            'name' => $entity->getName(),
            'email' => $entity->getEmail(),
            'username' => $entity->getUsername(),
            'created_at' => $entity->getCreatedAt(),
            'updated_at' => $entity->getUpdatedAt(),
            
        );
        $this->repository->save($entity);
        return $entity;
    }
    
    public function getUserByUsername($username)
    {
        $entity = $this->repository->findByUsername($username);
        if($entity===null){
            return null;
        }
        return $user = array(
            'id' => $entity->getId(),
            'login_id' => $entity->getLoginId(),
            'name' => $entity->getName(),
            'email' => $entity->getEmail(),
            'username' => $entity->getUsername(),
            'created_at' => $entity->getCreatedAt(),
            'updated_at' => $entity->getUpdatedAt(),
            
        );
    }
    
    
}