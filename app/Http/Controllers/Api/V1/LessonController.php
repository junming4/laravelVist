<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Lesson;
use App\Transformer\LessonTransformer;
use Illuminate\Http\Request;

class LessonController extends ApiController
{
    protected $lessonTransformer;

    public function __construct(LessonTransformer $lessonTransformer)
    {
        $this->lessonTransformer = $lessonTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lessons = Lesson::all();

        if(!$lessons) return $this->responseNotFound('数据为空');

        return $this->response([
            'msg' => 'success',
            'code' => 200,
            'data' => $this->lessonTransformer->transformCollection($lessons->toArray())
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $lessons = Lesson::findOrFail($id);

        if(!$lessons) return $this->responseNotFound('数据为空!');

        return $this->response([
            'msg' => 'success',
            'code' => 200,
            'data' => $this->lessonTransformer->transform($lessons)
        ]);

    }

}
