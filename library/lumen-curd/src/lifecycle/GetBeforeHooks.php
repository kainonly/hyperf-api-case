<?php

namespace lumen\curd\lifecycle;

interface GetBeforeHooks
{
    /**
     * Get pre-processing of individual data
     * @return boolean
     */
    public function __getBeforeHooks();
}
