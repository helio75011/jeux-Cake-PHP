<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Games Controller
 *
 * @property \App\Model\Table\GamesTable $Games
 */
class GamesController extends AppController
{
    /**
     * Liste des jeux disponibles
     */
    public function index()
    {
        $games = $this->Games->find()->all();
        $this->set(compact('games'));
    }

    /**
     * Mastermind
     */
    public function mastermind()
    {
        $sessionTable = $this->fetchTable('GameSessions');
        $userId = $this->request->getAttribute('identity')->get('id');
        $game = $this->Games->findBySlug('mastermind')->first();

        // Récupère une partie en cours ou en crée une nouvelle
        $session = $sessionTable->find()
            ->where(['user_id' => $userId, 'game_id' => $game->id])
            ->first();

        if (!$session) {
            // Initialisation de la partie
            $colors = ['R', 'B', 'V', 'J', 'O', 'M']; // Rouge, Bleu, Vert, Jaune, Orange, Marron
            $secret = [];
            for ($i = 0; $i < 4; $i++) {
                $secret[] = $colors[array_rand($colors)];
            }

            $session = $sessionTable->newEntity([
                'user_id' => $userId,
                'game_id' => $game->id,
                'state' => [
                    'secret' => $secret,
                    'attempts' => []
                ],
                'pa' => 0 // Non utilisé pour Mastermind
            ]);
            $sessionTable->save($session);
        }

        if ($this->request->is('post')) {
            $guess = $this->request->getData('guess'); // Array de 4 couleurs
            $state = $session->state;
            
            // Logique basique de vérification (Pions bien placés et mal placés)
            $exact = 0;
            $colors_match = 0; // Simplifié pour l'exemple
            foreach ($guess as $k => $c) {
                if ($c === $state['secret'][$k]) {
                    $exact++;
                } elseif (in_array($c, $state['secret'])) {
                    $colors_match++;
                }
            }

            $state['attempts'][] = [
                'guess' => $guess,
                'exact' => $exact,
                'colors_match' => $colors_match
            ];

            $session->state = $state;

            if ($exact === 4) {
                $this->Flash->success('Victoire ! Vous avez trouvé la combinaison secrète.');
                // Enregistrer le score, détruire la session etc.
                // ...
            }

            $sessionTable->save($session);
        }

        $this->set(compact('session'));
    }

    /**
     * Filler
     */
    public function filler()
    {
        $sessionTable = $this->fetchTable('GameSessions');
        $userId = $this->request->getAttribute('identity')->get('id');
        $game = $this->Games->findBySlug('filler')->first();

        $session = $sessionTable->find()
            ->where(['user_id' => $userId, 'game_id' => $game->id])
            ->first();

        if (!$session) {
            // Génération de la grille aléatoire 10x10
            $grid = [];
            $colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
            for ($y = 0; $y < 10; $y++) {
                $row = [];
                for ($x = 0; $x < 10; $x++) {
                    $row[] = $colors[array_rand($colors)];
                }
                $grid[] = $row;
            }

            $session = $sessionTable->newEntity([
                'user_id' => $userId,
                'game_id' => $game->id,
                'state' => [
                    'grid' => $grid,
                    'player1_color' => $grid[9][0], // Coin bas gauche
                    'player2_color' => $grid[0][9], // Coin haut droit
                    'turn' => 1
                ],
                'pa' => 0
            ]);
            $sessionTable->save($session);
        }

        if ($this->request->is('post')) {
            $newColor = $this->request->getData('color');
            $state = $session->state;

            // Algorithme de propagation (Flood-fill) à implémenter ici pour modifier la $state['grid']
            // ...

            $session->state = $state;
            $sessionTable->save($session);
        }

        $this->set(compact('session'));
    }

    /**
     * Labyrinthe
     */
    public function labyrinthe()
    {
        $sessionTable = $this->fetchTable('GameSessions');
        $userId = $this->request->getAttribute('identity')->get('id');
        $game = $this->Games->findBySlug('labyrinthe')->first();

        $session = $sessionTable->find()
            ->where(['user_id' => $userId, 'game_id' => $game->id])
            ->first();

        if (!$session) {
            // Lecture du fichier texte
            $filePath = ROOT . DS . 'resources' . DS . 'labyrinthe' . DS . 'level1.txt';
            $maze = file_exists($filePath) ? file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
            
            // Trouver le point de départ 'S'
            $startX = 0; $startY = 0;
            foreach ($maze as $y => $row) {
                $sPos = strpos($row, 'S');
                if ($sPos !== false) {
                    $startX = $sPos;
                    $startY = $y;
                }
            }

            $session = $sessionTable->newEntity([
                'user_id' => $userId,
                'game_id' => $game->id,
                'state' => [
                    'x' => $startX,
                    'y' => $startY,
                    'maze' => $maze // On garde la carte en state ou on la relit à chaque fois
                ],
                'pa' => 15 // Le joueur commence avec 15 actions
            ]);
            $sessionTable->save($session);
        }

        if ($this->request->is('post')) {
            $direction = $this->request->getData('direction'); // up, down, left, right
            
            if ($session->pa > 0) {
                $state = $session->state;
                $newX = $state['x'];
                $newY = $state['y'];

                if ($direction === 'up') $newY--;
                if ($direction === 'down') $newY++;
                if ($direction === 'left') $newX--;
                if ($direction === 'right') $newX++;

                // Vérifier collision (ex: '#' pour les murs)
                $targetCell = $state['maze'][$newY][$newX] ?? '#';
                if ($targetCell !== '#') {
                    $state['x'] = $newX;
                    $state['y'] = $newY;
                    $session->state = $state;
                    $session->pa -= 1;
                    
                    if ($targetCell === 'E') {
                        $this->Flash->success('Vous avez trouvé la sortie du labyrinthe !');
                    }
                } else {
                    $this->Flash->error('Aïe ! Il y a un mur.');
                    $session->pa -= 1; // Pénalité même si on cogne le mur ?
                }

                $sessionTable->save($session);
            } else {
                $this->Flash->error('Vous n\'avez plus de points d\'action. Attendez un peu...');
            }
            
            return $this->redirect(['action' => 'labyrinthe']);
        }

        $this->set(compact('session'));
    }
}
