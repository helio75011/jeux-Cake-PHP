<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Games Model
 *
 * @property \App\Model\Table\GameSessionsTable&\Cake\ORM\Association\HasMany $GameSessions
 * @property \App\Model\Table\ScoresTable&\Cake\ORM\Association\HasMany $Scores
 *
 * @method \App\Model\Entity\Game newEmptyEntity()
 * @method \App\Model\Entity\Game newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Game> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Game get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Game findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Game patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Game> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Game|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Game saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Game>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Game>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Game>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Game> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Game>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Game>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Game>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Game> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GamesTable extends Table
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

        $this->setTable('games');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('GameSessions', [
            'foreignKey' => 'game_id',
        ]);
        $this->hasMany('Scores', [
            'foreignKey' => 'game_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['slug']), ['errorField' => 'slug']);

        return $rules;
    }
}
