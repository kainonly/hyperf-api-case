<?php

namespace lumen\curd\lifecycle;

interface DeleteAfterHooks
{
    /**
     * Delete post processing
     * @return mixed
     */
    public function __deleteAfterHooks();
}
