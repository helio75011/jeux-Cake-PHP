<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Inscription');
?>
<div class="row">
    <div class="column column-50 column-offset-25">
        <div class="users form content" style="margin-top: 50px;">
            <h2 class="text-center">Inscription</h2>
            <p>Bienvenue sur la plateforme de jeux !</p>
            
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Créer un nouveau compte') ?></legend>
                <?= $this->Form->control('username', ['label' => 'Identifiant souhaité', 'required' => true]) ?>
                <?= $this->Form->control('password', ['label' => 'Mot de passe sécurisé', 'required' => true]) ?>
            </fieldset>
            <div style="text-align: center; margin-top: 20px;">
                <?= $this->Form->submit(__("M'inscrire"), ['class' => 'button', 'style' => 'width: 100%;']); ?>
            </div>
            <?= $this->Form->end() ?>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Déjà parmi nous ?</p>
                <?= $this->Html->link("Aller à la connexion", ['action' => 'login'], ['class' => 'button button-outline']) ?>
            </div>
        </div>
    </div>
</div>