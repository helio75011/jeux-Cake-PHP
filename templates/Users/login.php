<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Connexion');
?>
<div class="row">
    <div class="column column-50 column-offset-25">
        <div class="users form content" style="margin-top: 50px;">
            <h2 class="text-center">Connexion</h2>
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Veuillez saisir votre identifiant et mot de passe') ?></legend>
                <?= $this->Form->control('username', ['label' => 'Identifiant', 'required' => true]) ?>
                <?= $this->Form->control('password', ['label' => 'Mot de passe', 'required' => true]) ?>
            </fieldset>
            <div style="text-align: center; margin-top: 20px;">
                <?= $this->Form->submit(__('Se connecter'), ['class' => 'button', 'style' => 'width: 100%;']); ?>
            </div>
            <?= $this->Form->end() ?>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Pas encore inscrit ?</p>
                <?= $this->Html->link("Créer un compte", ['action' => 'register'], ['class' => 'button button-outline']) ?>
            </div>
        </div>
    </div>
</div>