<?php
/**
 * @User:   Little (2284876299.com)
 * @Date:   2016/12/29
 * @Time:   21:09
 * @Version: 1.0
 * Desc:
 */

namespace App\Api\Controllers;


use App\Api\Transformer\LessonTransformer;
use App\Lesson;

class LessonController extends BaseController
{
    public function index()
    {
        $lesson = Lesson::all();

        return $this->response->collection($lesson, new LessonTransformer())->setStatusCode(200);
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson){
            return $this->response->errorNotFound('This is an error.', 404);
        }

        return $this->response->item($lesson, new  LessonTransformer());

    }

}