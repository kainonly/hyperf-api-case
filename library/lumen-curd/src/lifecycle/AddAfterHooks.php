<?php

namespace lumen\curd\lifecycle;

interface AddAfterHooks
{
    /**
     * Add post processing
     * @param string|int $id
     * @return mixed
     */
    public function __addAfterHooks($id);
}
