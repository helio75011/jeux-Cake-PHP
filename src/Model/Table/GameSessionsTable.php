<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GameSessions Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\GamesTable&\Cake\ORM\Association\BelongsTo $Games
 *
 * @method \App\Model\Entity\GameSession newEmptyEntity()
 * @method \App\Model\Entity\GameSession newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\GameSession> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GameSession get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\GameSession findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\GameSession patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\GameSession> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GameSession|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\GameSession saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\GameSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GameSession>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GameSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GameSession> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GameSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GameSession>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GameSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GameSession> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GameSessionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('game_sessions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Games', [
            'foreignKey' => 'game_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('game_id')
            ->notEmptyString('game_id');

        $validator
            ->scalar('state')
            ->maxLength('state', 4294967295)
            ->allowEmptyString('state');

        $validator
            ->integer('pa')
            ->notEmptyString('pa');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['game_id'], 'Games'), ['errorField' => 'game_id']);

        return $rules;
    }
}
