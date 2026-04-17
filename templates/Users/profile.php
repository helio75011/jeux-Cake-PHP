<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Profil Administrateur');
?>
<div class="row">
    <div class="column column-80 column-offset-10">
        <div class="users view content" style="margin-top: 30px;">
            <h2>Profil de : <?= h($user->username) ?></h2>
            <p>
                Vous nous avez rejoint le : 
                <strong><?= $user->created ? h($user->created->format('d/m/Y à H:i')) : 'Date inconnue' ?></strong>
            </p>
            
            <hr>
            
            <div class="row">
                <!-- Colonne Mes Parties en cours -->
                <div class="column column-50">
                    <h3>Mes Parties en cours</h3>
                    <?php if (!empty($user->game_sessions)) : ?>
                        <ul style="list-style-type: none; padding: 0;">
                            <?php foreach ($user->game_sessions as $session) : ?>
                                <li style="background-color: #f4f6f8; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                    <strong><?= h($session->game->name) ?></strong> 
                                    <br>
                                    <small>Dernière activité : <?= h($session->modified->format('d/m/Y H:i')) ?></small>
                                    <br>
                                    <?= $this->Html->link('Reprendre la partie ->', 
                                        ['controller' => 'Games', 'action' => $session->game->slug],
                                        ['class' => 'button button-clear button-small']
                                    ) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>Vous n'avez aucune partie en cours.</p>
                    <?php endif; ?>
                </div>

                <!-- Colonne Historique des scores -->
                <div class="column column-50">
                    <h3>Historique de mes scores</h3>
                    <?php if (!empty($user->scores)) : ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Jeu</th>
                                    <th>Mon Score</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user->scores as $score) : ?>
                                <tr>
                                    <td><?= h($score->game->name) ?></td>
                                    <td><strong><?= h($score->score) ?></strong></td>
                                    <td><?= h($score->created->format('d/m/Y H:i')) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p>Aucun score enregistré pour l'instant.</p>
                        <p><?= $this->Html->link('Jouer à un jeu', ['controller' => 'Games', 'action' => 'index']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>