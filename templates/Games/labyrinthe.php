<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GameSession $session
 */
$this->assign('title', 'Labyrinthe');
?>

<div class="row">
    <div class="column">
        <h2>Labyrinthe</h2>
        <p>Points d'Action (PA) : <strong><?= h($session->pa) ?> / 15</strong> <em>(+5 PA par minute)</em></p>

        <?php if ($session->pa > 0): ?>
            <div class="game-board">
                <p>Trouvez la sortie 'E'.</p>
                <div class="maze">
                    <?php
                    $maze = $session->state['maze'];
                    $playerX = $session->state['x'];
                    $playerY = $session->state['y'];

                    foreach ($maze as $y => $row): ?>
                        <div class="maze-row">
                            <?php
                            $chars = str_split($row);
                            foreach ($chars as $x => $char): 
                                $class = 'maze-cell maze-path';
                                if ($char === '#') $class = 'maze-cell maze-wall';
                                if ($char === 'E') $class = 'maze-cell maze-end';
                                
                                $displayChar = ($char === '#') ? ' ' : $char;
                                
                                if ($x === $playerX && $y === $playerY) {
                                    $class = 'maze-cell maze-player';
                                    $displayChar = '@';
                                }
                                ?>
                                <div class="<?= $class ?>"><?= h($displayChar) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="maze-controls" style="margin-top: 20px; max-width: 250px;">
                    <?= $this->Form->create(null, ['url' => ['action' => 'labyrinthe']]) ?>
                    <table style="text-align: center; border: none;">
                        <tr>
                            <td style="border: none;"></td>
                            <td style="border: none;"><button type="submit" name="direction" value="up">Haut</button></td>
                            <td style="border: none;"></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><button type="submit" name="direction" value="left">Gauche</button></td>
                            <td style="border: none;"><button type="submit" name="direction" value="down">Bas</button></td>
                            <td style="border: none;"><button type="submit" name="direction" value="right">Droite</button></td>
                        </tr>
                    </table>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        <?php else: ?>
            <div class="message error">
                Vous n'avez plus de points d'action ! Revenez dans quelques minutes.
            </div>
            <p><a href="<?= $this->Url->build(['action' => 'labyrinthe']) ?>" class="button">Rafraîchir</a></p>
        <?php endif; ?>
    </div>
</div>
