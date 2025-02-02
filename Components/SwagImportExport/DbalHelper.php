<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shopware\Components\SwagImportExport;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Enlight_Event_EventManager as EventManager;
use Shopware\Components\Model\ModelManager;

class DbalHelper
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(Connection $connection, ModelManager $modelManager, EventManager $eventManager)
    {
        $this->connection = $connection;
        $this->modelManager = $modelManager;
        $this->eventManager = $eventManager;
    }

    /**
     * @return DbalHelper
     */
    public static function create()
    {
        return new self(
            Shopware()->Container()->get('dbal_connection'),
            Shopware()->Container()->get('models'),
            Shopware()->Container()->get('events')
        );
    }

    /**
     * @param class-string $entity
     *
     * @return QueryBuilder
     */
    public function getQueryBuilderForEntity(array $data, $entity, $primaryId)
    {
        $metaData = $this->modelManager->getClassMetadata($entity);
        $table = $metaData->table['name'];

        $builder = $this->getQueryBuilder();
        if ($primaryId) {
            $id = $builder->createNamedParameter($primaryId, \PDO::PARAM_INT);
            $builder->update($table);
            //update article id in case we don't have any field for update
            $builder->set('id', $id);
            $builder->where('id = ' . $id);
        } else {
            $builder->insert($table);
        }

        foreach ($data as $field => $value) {
            if (!\array_key_exists($field, $metaData->fieldMappings)) {
                continue;
            }

            $value = $this->eventManager->filter(
                'Shopware_Components_SwagImportExport_DbalHelper_GetQueryBuilderForEntity_Value',
                $value,
                [
                    'subject' => $this,
                    'field' => $field,
                ]
            );

            if (!\array_key_exists('columnName', $metaData->fieldMappings[$field])) {
                continue;
            }

            $key = $this->connection->quoteIdentifier($metaData->fieldMappings[$field]['columnName']);

            $value = $this->getNamedParameter($value, $field, $metaData, $builder);
            if ($primaryId) {
                $builder->set($key, $value);
            } else {
                $builder->setValue($key, $value);
            }
        }

        return $builder;
    }

    /**
     * @return QueryBuilder
     */
    protected function getQueryBuilder()
    {
        return new QueryBuilder($this->connection);
    }

    /**
     * @param string $value
     * @param string $key
     *
     * @return string
     */
    protected function getNamedParameter($value, $key, ClassMetadata $metaData, QueryBuilder $builder)
    {
        $pdoTypeMapping = [
            'string' => \PDO::PARAM_STR,
            'text' => \PDO::PARAM_STR,
            'date' => \PDO::PARAM_STR,
            'datetime' => \PDO::PARAM_STR,
            'boolean' => \PDO::PARAM_INT,
            'integer' => \PDO::PARAM_INT,
            'decimal' => \PDO::PARAM_STR,
            'float' => \PDO::PARAM_STR,
        ];

        $nullAble = \array_key_exists('nullable', $metaData->fieldMappings[$key]) ? $metaData->fieldMappings[$key]['nullable'] : false;

        // Check if nullable
        if (!isset($value) && $nullAble) {
            return $builder->createNamedParameter(null, \PDO::PARAM_NULL);
        }

        $type = $metaData->fieldMappings[$key]['type'];
        if (!\array_key_exists($type, $pdoTypeMapping)) {
            throw new \RuntimeException(\sprintf('Type %s not found', $type));
        }

        return $builder->createNamedParameter($value, $pdoTypeMapping[$type]);
    }
}
