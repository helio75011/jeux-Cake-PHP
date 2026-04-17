<?php
$this->assign('title', 'Filler');
?>
<div class="row">
    <div class="column">
        <h2>Filler</h2>
        <p>Tour: <?= h($session->state['turn']) ?> - Choisissez une couleur pour étendre votre territoire.</p>

        <div class="game-board">
            <table class="filler-grid" style="border-collapse: collapse; display: inline-block;">
                <?php foreach ($session->state['grid'] as $y => $row): ?>
                    <tr>
                        <?php foreach ($row as $x => $color): ?>
                            <td>
                                <span class="filler-cell bg-<?= h($color) ?>"></span>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="filler-controls" style="margin-top: 20px;">
            <h3>Votre choix :</h3>
            <?= $this->Form->create(null, ['url' => ['action' => 'filler'], 'style' => 'display: flex; gap: 10px;']) ?>
            
            <?php 
            $colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
            foreach ($colors as $btnColor): 
            ?>
                <button type="submit" name="color" value="<?= $btnColor ?>" class="button bg-<?= $btnColor ?>" style="color: white; border: 2px solid #ccc;">
                    <?= ucfirst($btnColor) ?>
                </button>
            <?php endforeach; ?>
            
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>