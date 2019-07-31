<?php

namespace lumen\curd\lifecycle;

interface OriginListsCustom
{
    /**
     * Custom list data return
     * @param array $lists
     * @return array
     */
    public function __originListsCustomReturn(array $lists);
}
