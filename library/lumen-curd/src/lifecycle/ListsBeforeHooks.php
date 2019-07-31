<?php

namespace lumen\curd\lifecycle;

interface ListsBeforeHooks
{
    /**
     * Paging data acquisition preprocessing
     * @return boolean
     */
    public function __listsBeforeHooks();
}
