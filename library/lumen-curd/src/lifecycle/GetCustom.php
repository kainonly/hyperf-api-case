<?php

namespace lumen\curd\lifecycle;

interface GetCustom
{
    /**
     * Customize individual data returns
     * @param mixed $data
     * @return array
     */
    public function __getCustomReturn($data);
}
