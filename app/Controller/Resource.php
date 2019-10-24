<?php

namespace App\Controller;

use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;
use Hyperf\Curd\Lifecycle\DeleteBeforeHooks;
use Hyperf\Curd\Lifecycle\EditAfterHooks;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;

/**
 * Class Resource
 * @package App\Controller
 * @Controller()
 * @Middlewares({
 *  @Middleware(\App\Middleware\AppAuthVerify::class)
 * })
 */
class Resource extends Base implements AddAfterHooks, EditAfterHooks, DeleteBeforeHooks, DeleteAfterHooks
{
    use OriginListsModel, GetModel, AddModel, DeleteModel, EditModel;
    protected $model = 'resource';

    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id)
    {
        return true;
    }

    /**
     * Modify post processing
     * @return mixed
     */
    public function __editAfterHooks()
    {
        return true;
    }

    /**
     * Delete pre-processing
     * @return boolean
     */
    public function __deleteBeforeHooks()
    {
        return true;
    }

    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks()
    {
        return true;
    }

    /**
     * Sort Lists
     * @return array
     */
    public function sort()
    {
        if (empty($this->post['data'])) {
            return [
                'error' => 1,
                'msg' => 'error'
            ];
        }

        return Db::transaction(function () {
            foreach ($this->post['data'] as $value) {
                Db::table($this->model)->update($value);
            }
            return true;
        }) ? [
            'error' => 0,
            'msg' => 'success'
        ] : [
            'error' => 1,
            'msg' => 'error'
        ];
    }

    /**
     * Exists Resources Key
     * @return array
     */
    public function validedKey()
    {
        if (empty($this->post['key'])) {
            return [
                'error' => 1,
                'msg' => 'error:require_key'
            ];
        }

        $result = Db::table($this->model)
            ->where('key', '=', $this->post['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $result
        ];
    }
}