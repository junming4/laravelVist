<?php

/**
 * @User:   Little (2284876299.com)
 * @Date:   2016/12/28
 * @Time:   23:26
 * @Version: 1.0
 * Desc:  个人映射
 */
namespace App\Transformer;

class LessonTransformer extends Transformer
{

    /**
     * @param $item
     * @return mixed
     */
    public function transform($lesson)
    {
        return [
            'title' => $lesson['title'],
            'content' => $lesson['body'],
            'is_free' => (boolean)$lesson['free']
        ];
    }
}