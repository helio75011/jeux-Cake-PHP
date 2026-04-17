<?php
$this->assign('title', 'Mastermind');
?>
<div class="row">
    <div class="column">
        <h2>Mastermind</h2>
        <p>Essayez de deviner la combinaison des 4 couleurs !</p>
        
        <div class="mastermind-board">
            <?php if (!empty($session->state['attempts'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Essai</th>
                            <th>Bien placés</th>
                            <th>Mal placés</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($session->state['attempts'] as $i => $attempt): ?>
                            <tr>
                                <td>
                                    <?php foreach ($attempt['guess'] as $color): ?>
                                        <span class="color-box color-<?= h($color) ?>"><?= h($color) ?></span>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= h($attempt['exact']) ?></td>
                                <td><?= h($attempt['colors_match']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun essai pour le moment.</p>
            <?php endif; ?>

            <div class="mastermind-form">
                <h3>Votre proposition:</h3>
                <?= $this->Form->create(null, ['url' => ['action' => 'mastermind']]) ?>
                <div style="display: flex; gap: 10px;">
                    <?php for($i = 0; $i < 4; $i++): ?>
                        <select name="guess[]" style="width: 100px;">
                            <option value="R">Rouge</option>
                            <option value="B">Bleu</option>
                            <option value="V">Vert</option>
                            <option value="J">Jaune</option>
                            <option value="O">Orange</option>
                            <option value="M">Marron</option>
                        </select>
                    <?php endfor; ?>
                </div>
                <button type="submit" style="margin-top: 15px;">Tenter ma chance</button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>