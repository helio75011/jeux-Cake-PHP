<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'Plateforme de Jeux';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>
    <style>
        /* Styles de base pour nos jeux */
        .game-board { margin: 20px 0; }
        .color-R { background-color: #e74c3c; color: white;}
        .color-B { background-color: #3498db; color: white;}
        .color-V { background-color: #2ecc71; color: white;}
        .color-J { background-color: #f1c40f; color: black;}
        .color-O { background-color: #e67e22; color: white;}
        .color-M { background-color: #795548; color: white;}
        .color-box { display: inline-block; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; margin: 2px; }
        /* Filler grid */
        .filler-grid td { width: 30px; height: 30px; padding: 0; border: 1px solid #fff; }
        .filler-cell { display: block; width: 100%; height: 100%; }
        .bg-red { background-color: #e74c3c; }
        .bg-blue { background-color: #3498db; }
        .bg-green { background-color: #2ecc71; }
        .bg-yellow { background-color: #f1c40f; }
        .bg-purple { background-color: #9b59b6; }
        .bg-orange { background-color: #e67e22; }
        /* Labyrinthe grid */
        .maze-row { display: flex; font-family: monospace; white-space: pre; line-height: 1; }
        .maze-cell { width: 20px; height: 20px; text-align: center; }
        .maze-wall { background-color: #333; color: #333; }
        .maze-path { background-color: #eee; }
        .maze-player { background-color: #3498db; color: white; font-weight: bold; border-radius: 50%; }
        .maze-end { background-color: #2ecc71; color: white; font-weight: bold; }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build(['controller' => 'Games', 'action' => 'index']) ?>"><span>Plateforme</span>Jeux</a>
        </div>
        <div class="top-nav-links">
            <a href="<?= $this->Url->build(['controller' => 'Games', 'action' => 'mastermind']) ?>">Mastermind</a>
            <a href="<?= $this->Url->build(['controller' => 'Games', 'action' => 'filler']) ?>">Filler</a>
            <a href="<?= $this->Url->build(['controller' => 'Games', 'action' => 'labyrinthe']) ?>">Labyrinthe</a>
            
            <?php if ($this->request->getAttribute('identity')): ?>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>">Mon Profil</a>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" style="color: #e74c3c;">Déconnexion</a>
            <?php else: ?>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">Connexion</a>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>">Inscription</a>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
