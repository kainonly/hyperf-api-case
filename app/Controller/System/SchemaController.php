<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Service\SchemaService;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Exception;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use stdClass;

class SchemaController extends BaseController
{
    use ListsModel, OriginListsModel, GetModel, AddModel, EditModel, DeleteModel;

    protected static string $model = 'schema';
    protected static array $addValidate = [
        'name' => 'required|array',
        'table' => 'required',
        'type' => 'required',
    ];
    protected static array $editValidate = [
        'name' => 'required_if:switch,0|array',
        'table' => 'required_if:switch,0',
        'type' => 'required_if:switch,0',
    ];
    /**
     * @Inject()
     * @var SchemaService
     */
    private SchemaService $schema;

    public function addBeforeHook(stdClass $ctx): bool
    {
        $this->before($ctx->body);
        return true;
    }

    public function addAfterHook(stdClass $ctx): bool
    {
        $now = time();
        $body = $ctx->body;
        $result = Db::table('column')->insert([
            [
                'schema' => $body['table'],
                'column' => 'id',
                'datatype' => 'system',
                'name' => json_encode([
                    'zh_cn' => '主键',
                    'en_us' => 'Primary key'
                ], JSON_UNESCAPED_UNICODE),
                'description' => json_encode([
                    'zh_cn' => '系统默认字段',
                    'en_us' => ''
                ], JSON_UNESCAPED_UNICODE),
                'sort' => 0,
                'create_time' => $now,
                'update_time' => $now
            ],
            [
                'schema' => $body['table'],
                'column' => 'create_time',
                'datatype' => 'system',
                'name' => json_encode([
                    'zh_cn' => '创建时间',
                    'en_us' => 'Create Time'
                ], JSON_UNESCAPED_UNICODE),
                'description' => json_encode([
                    'zh_cn' => '系统默认字段',
                    'en_us' => ''
                ], JSON_UNESCAPED_UNICODE),
                'sort' => 0,
                'create_time' => $now,
                'update_time' => $now
            ],
            [
                'schema' => $body['table'],
                'column' => 'update_time',
                'datatype' => 'system',
                'name' => json_encode([
                    'zh_cn' => '更新时间',
                    'en_us' => 'Update Time'
                ], JSON_UNESCAPED_UNICODE),
                'description' => json_encode([
                    'zh_cn' => '系统默认字段',
                    'en_us' => ''
                ], JSON_UNESCAPED_UNICODE),
                'sort' => 0,
                'create_time' => $now,
                'update_time' => $now
            ]
        ]);
        return $result > 0;
    }

    public function editBeforeHook(stdClass $ctx): bool
    {
        if (!$ctx->switch) {
            $this->before($ctx->body);
        }
        return true;
    }

    private function before(array &$body): void
    {
        $body['name'] = json_encode($body['name'], JSON_UNESCAPED_UNICODE);
        $body['description'] = json_encode((object)$body['description'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 发布数据表
     * @return array
     * @throws Exception
     */
    public function publish(): array
    {
        $body = $this->curd->should([
            'table' => 'required',
        ]);

        $manager = $this->schema->manager();
        $name = $this->schema->table($body['table']);
        if ($manager->tablesExist($name)) {
            $version = time();
            $manager->renameTable($name, $name . '_' . $version);
            Db::name('schema_history')->insert([
                'schema' => $body['table'],
                'remark' => $body['remark'] ?? '',
                'version' => $version
            ]);
        }
        $lists = Db::table('column')
            ->where('schema', '=', $body['table'])
            ->where('status', '=', 1)
            ->orderBy('sort')
            ->select();
        $table = new Table($name);
        foreach ($lists as $value) {
            $column = $value['column'];
            $datatype = $value['datatype'];
            $extra = json_decode($value['extra']);
            if ($column === 'id') {
                $table->addColumn('id', Types::BIGINT, [
                    'unsigned' => true,
                    'autoincrement' => true
                ]);
                continue;
            }
            if ($column === 'create_time') {
                $table->addColumn('create_time', Types::BIGINT, [
                    'unsigned' => true,
                    'default' => 0
                ]);
                continue;
            }
            if ($column === 'update_time') {
                $table->addColumn('update_time', Types::BIGINT, [
                    'unsigned' => true,
                    'default' => 0
                ]);
                continue;
            }
            $type = null;
            $option = [];
            if (!$extra->required) {
                $option['notnull'] = false;
            }
            if (!$extra->default) {
                $option['default'] = $extra->default;
            }
            switch ($datatype) {
                case 'string':
                    $type = Types::TEXT;
                    if (!$extra->is_text) {
                        $type = Types::STRING;
                        $option['length'] = 200;
                    }
                    break;
                case 'i18n':
                    $type = Types::JSON;
                    $option = [
                        'default' => '{}'
                    ];
                    break;
                case 'richtext':
                    $type = Types::TEXT;
                    break;
                case 'number':
                    $type = Types::BIGINT;
                    if ($extra->is_sort) {
                        $type = Types::SMALLINT;
                        $option['unsigned'] = true;
                    }
                    break;
                case 'status':
                    $type = Types::BOOLEAN;
                    $option['unsigned'] = true;
                    break;
                case 'datetime':
                case 'date':
                    $type = Types::BIGINT;
                    $option['unsigned'] = true;
                    break;
                case 'picture':
                case 'video':
                    $type = Types::JSON;
                    break;
                case 'assoc':
                case 'enmu':
                    $type = Types::STRING;
                    $option['length'] = 200;
                    break;
            }
            $table->addColumn($column, $type, $option);
        }
        $table->setPrimaryKey(['id']);
        $manager->createTable($table);
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }

    /**
     * 发布历史
     * @return array
     * @throws Exception
     */
    public function history(): array
    {
        $body = $this->curd->should([
            'table' => 'required'
        ]);

        $lists = Db::table('schema_history')
            ->where('schema', '=', $body['table'])
            ->orderBy('version', 'desc')
            ->select();

        return [
            'error' => 0,
            'data' => $lists
        ];
    }

    /**
     * 表结构详情
     * @return array
     * @throws Exception
     */
    public function table(): array
    {
        $body = $this->curd->should([
            'table' => 'required'
        ]);

        $manager = $this->schema->manager();
        $name = $this->schema->table($body['table']);
        $table = $manager->listTableDetails($name);

        return [
            'error' => 0,
            'data' => [
                'columns' => array_values(
                    array_map(static fn($v) => [
                        'name' => $v->getName(),
                        'type' => $v->getType()->getName(),
                        'length' => $v->getLength(),
                        'autoincrement' => $v->getAutoincrement(),
                        'unsigned' => $v->getUnsigned(),
                        'notnull' => $v->getNotnull(),
                        'default' => $v->getDefault(),
                        'comment' => $v->getComment()
                    ], $table->getColumns())
                ),
                'indexs' => array_values(
                    array_map(static fn($v) => [
                        'name' => $v->getName(),
                        'columns' => $v->getColumns(),
                        'unique' => $v->isUnique(),
                        'primary' => $v->isPrimary()
                    ], $table->getIndexes())
                )
            ]
        ];
    }

    /**
     * 判断表存在
     * @return array
     */
    public function validedTable(): array
    {
        $body = $this->request->post();
        if (empty($body['table'])) {
            return [
                'error' => 1,
                'msg' => '请求参数必须存在[table]值'
            ];
        }

        $exists = Db::table(static::$model)
            ->where('table', '=', $body['table'])
            ->exists();

        return [
            'error' => 0,
            'data' => [
                'exists' => $exists
            ]
        ];
    }
}