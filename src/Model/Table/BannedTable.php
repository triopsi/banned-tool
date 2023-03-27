<?php
declare(strict_types=1);

namespace BannedTool\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Banned Model
 *
 * @method \BannedTool\Model\Entity\Banned newEmptyEntity()
 * @method \BannedTool\Model\Entity\Banned newEntity(array $data, array $options = [])
 * @method \BannedTool\Model\Entity\Banned[] newEntities(array $data, array $options = [])
 * @method \BannedTool\Model\Entity\Banned get($primaryKey, $options = [])
 * @method \BannedTool\Model\Entity\Banned findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \BannedTool\Model\Entity\Banned patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \BannedTool\Model\Entity\Banned[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BannedTool\Model\Entity\Banned|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \BannedTool\Model\Entity\Banned saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \BannedTool\Model\Entity\Banned[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \BannedTool\Model\Entity\Banned[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \BannedTool\Model\Entity\Banned[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \BannedTool\Model\Entity\Banned[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BannedTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('banned');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('ip_address')
            ->maxLength('ip_address', 255)
            ->requirePresence('ip_address', 'create')
            ->notEmptyString('ip_address');

        return $validator;
    }
}
