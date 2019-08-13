<?php

namespace lumen\curd\lifecycle;

interface ListsCustom
{
    /**
     * Custom paged data return
     * @param array $lists
     * @param int $total
     * @return array
     */
    public function __listsCustomReturn(array $lists, int $total);
}
