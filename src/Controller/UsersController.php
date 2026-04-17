<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Autorisations sans être connecté
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // On permet l'accès à login et register même si l'utilisateur n'est pas connecté
        if (in_array($this->request->getParam('action'), ['login', 'register'])) {
            if ($this->components()->has('Authentication')) {
                $this->Authentication->addUnauthenticatedActions(['login', 'register']);
            }
        }
    }

    /**
     * Inscription
     */
    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('Votre compte a bien été créé ! Vous pouvez vous connecter.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Impossible de créer votre compte. Veuillez vérifier les champs.');
        }
        $this->set(compact('user'));
    }

    /**
     * Connexion
     */
    public function login()
    {
        // Si l'utilisateur est déjà connecté, on le redirige
        if ($this->request->getAttribute('identity')) {
             return $this->redirect(['controller' => 'Games', 'action' => 'index']);
        }

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            return $this->redirect($this->Authentication->getLoginRedirect() ?? ['controller' => 'Games', 'action' => 'index']);
        }

        // Message d'erreur si la soumission a échoué
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Identifiant ou mot de passe invalide');
        }
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Affichage du profil avec l'historique des scores
     */
    public function profile()
    {
        // Récupérer l'utilisateur connecté
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['action' => 'login']);
        }
        $userId = $identity->get('id');

        // On récupère l'utilisateur en incluant (contain) ses scores et les jeux liés
        $user = $this->Users->get($userId, [
            'contain' => [
                'Scores' => ['Games'],
                'GameSessions' => ['Games']
            ]
        ]);

        $this->set(compact('user'));
    }
}
