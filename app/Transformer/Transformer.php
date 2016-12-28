<?php
/**
 * @User:   Little (2284876299.com)
 * @Date:   2016/12/28
 * @Time:   23:23
 * @Version: 1.0
 * Desc:  转换抽象类
 */

namespace App\Transformer;

abstract class Transformer
{
    /**
     * 对数据进行转换
     * @param $lessons
     * @return array
     */
    public function transformCollection($item)
    {
        return array_map([$this, 'transform'], $item);
    }

    /**
     * @param $item
     * @return mixed
     */
    public abstract function transform($item);
}