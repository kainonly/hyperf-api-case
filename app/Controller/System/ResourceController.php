<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\ResourceRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteBeforeHooks;
use Hyperf\Curd\Lifecycle\EditAfterHooks;
use Hyperf\Curd\Lifecycle\EditBeforeHooks;
use Hyperf\Database\Exception\QueryException;
use Hyperf\Database\Query\Builder;
use Hyperf\DbConnection\Db;
use Hyperf\Extra\Hash\HashInterface;
use Hyperf\Extra\Token\TokenInterface;
use Hyperf\Extra\Utils\UtilsInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

class ResourceController extends BaseController
    implements AddAfterHooks, EditBeforeHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use OriginListsModel, GetModel, AddModel, DeleteModel, EditModel;
    protected string $model = 'resource';
    protected array $origin_lists_order = ['sort', 'asc'];
    protected array $add_validate = [
        'key' => 'required',
        'name' => 'required|json'
    ];
    protected array $edit_validate = [
        'key' => 'required',
        'name' => 'required|json'
    ];
    private string $key;

    public function addAfterHooks(int $id): bool
    {
        $this->clearRedis();
        return true;
    }

    public function editBeforeHooks(): bool
    {
        if (!$this->edit_switch) {
            $data = Db::table($this->model)
                ->where('id', '=', $this->post['id'])
                ->first();

            if (!empty($data)) {
                $this->key = $data->key;
            }
        }
        return true;
    }

    public function editAfterHooks(): bool
    {
        try {
            if (!$this->edit_switch && $this->post['key'] !== $this->key) {
                Db::table($this->model)
                    ->where('parent', '=', $this->key)
                    ->update([
                        'parent' => $this->post['key']
                    ]);
            }
            $this->clearRedis();
            return true;
        } catch (QueryException $exception) {
            $this->edit_after_result = [
                'error' => 1,
                'msg' => $exception->getMessage()
            ];
            return false;
        }
    }

    public function deleteBeforeHooks(): bool
    {
        $queryData = Db::table($this->model)
            ->whereIn('id', $this->post['id'])
            ->first();

        if (empty($queryData)) {
            return false;
        }

        $exists = Db::table($this->model)
            ->where('parent', '=', $queryData->key)
            ->exists();

        if ($exists) {
            $this->delete_before_result = [
                'error' => 1,
                'msg' => 'error:has_child'
            ];
        }
        return !$exists;
    }

    public function deleteAfterHooks(): bool
    {
        $this->clearRedis();
        return true;
    }

    /**
     * Sort Lists
     * @return array
     */
    public function sort(): array
    {
        $this->post = $this->request->post();
        $validator = $this->validation->make($this->post, [
            'data' => 'required|array',
        ]);

        if ($validator->fails()) {
            return [
                'error' => 1,
                'msg' => $validator->errors()
            ];
        }
        
        return Db::transaction(function () {
            foreach ($this->post['data'] as $value) {
                Db::table($this->model)
                    ->where('id', '=', $value['id'])
                    ->update([
                        'sort' => $value['sort']
                    ]);
            }
            $this->clearRedis();
            return true;
        }) ? [
            'error' => 0,
            'msg' => 'success'
        ] : [
            'error' => 1,
            'msg' => 'error'
        ];
    }

    private function clearRedis(): void
    {
        ResourceRedis::create($this->container)->clear();
        RoleRedis::create($this->container)->clear();
    }

    /**
     * Exists Resources Key
     * @return array
     */
    public function validedKey(): array
    {
        $this->post = $this->request->post();
        if (empty($this->post['key'])) {
            return [
                'error' => 1,
                'msg' => 'error:require_key'
            ];
        }

        $exists = Db::table($this->model)
            ->where('key', '=', $this->post['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }
}