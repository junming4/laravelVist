<?php
/**
 * @User:   Little (2284876299.com)
 * @Date:   2016/12/29
 * @Time:   21:20
 * @Version: 1.0
 * Desc:
 */

namespace App\Api\Transformer;


use App\Lesson;
use League\Fractal\TransformerAbstract;

class LessonTransformer extends TransformerAbstract
{

    /**
     * @param $item
     * @return mixed
     */
    public function transform(Lesson $lesson)
    {
        return [
            'title' => $lesson['title'],
            'content' => $lesson['body'],
            'is_free' => (boolean)$lesson['free']
        ];
    }

}