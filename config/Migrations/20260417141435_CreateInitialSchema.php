<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateInitialSchema extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        // 1. Table users
        $users = $this->table('users');
        $users->addColumn('username', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('created', 'datetime', ['null' => true])
              ->addColumn('modified', 'datetime', ['null' => true])
              ->addIndex(['username'], ['unique' => true])
              ->create();

        // 2. Table games
        $games = $this->table('games');
        $games->addColumn('name', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('slug', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('created', 'datetime', ['null' => true])
              ->addColumn('modified', 'datetime', ['null' => true])
              ->addIndex(['slug'], ['unique' => true])
              ->create();

        // Insertion des 3 jeux par défaut
        $this->execute("INSERT INTO games (name, slug, created, modified) VALUES 
            ('Mastermind', 'mastermind', NOW(), NOW()),
            ('Filler', 'filler', NOW(), NOW()),
            ('Labyrinthe', 'labyrinthe', NOW(), NOW())
        ");

        // 3. Table scores
        $scores = $this->table('scores');
        $scores->addColumn('user_id', 'integer', ['null' => false])
               ->addColumn('game_id', 'integer', ['null' => false])
               ->addColumn('score', 'integer', ['null' => false])
               ->addColumn('created', 'datetime', ['null' => true])
               ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
               ->addForeignKey('game_id', 'games', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
               ->create();

        // 4. Table game_sessions (parties en cours)
        $gameSessions = $this->table('game_sessions');
        $gameSessions->addColumn('user_id', 'integer', ['null' => false])
                     ->addColumn('game_id', 'integer', ['null' => false])
                     ->addColumn('state', 'json', ['null' => true]) // Permet de stocker la grille ou les coordonnées
                     ->addColumn('pa', 'integer', ['default' => 15, 'null' => false]) // Réservé pour Labyrinthe
                     ->addColumn('created', 'datetime', ['null' => true])
                     ->addColumn('modified', 'datetime', ['null' => true])
                     ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
                     ->addForeignKey('game_id', 'games', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
                     ->create();
    }
}
