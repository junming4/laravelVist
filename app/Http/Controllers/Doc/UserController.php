<?php

namespace App\Http\Controllers\Doc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
 * @package
 * @category
 *
 * @SWG\Resource(
 *   apiVersion="1.0.0",
 *   swaggerVersion="1.2",
 *   basePath="http://www.9.com",
 *   resourcePath="/Doc",
 *   description="一个测试类",
 *   @SWG\Produces("application/json")
 * )
 */
class UserController extends Controller
{
    /**
     * @SWG\Api(path="/test",
     *   @SWG\Operation(
     *     method="GET",
     *     summary="一个测试方法index",
     *     notes="",
     *     type="Article",
     *     nickname="getUserByName",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="username",
     *       description="姓名",
     *       required=false,
     *       type="string",
     *       paramType="query",
     *       allowMultiple=false
     *     ),
     *      @SWG\Parameter(
     *       name="id[1]",
     *       description="id中的一个",
     *       required=true,
     *       type="string",
     *       paramType="query",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=400, message="Invalid username supplied"),
     *     @SWG\ResponseMessage(code=404, message="User not found")
     *   )
     * )
     *
     */
    public function index(){
        header('Content-Type:application/json; charset=utf-8');
        $arr=['id'=>1,'name'=>'姓名','sex'=>'男','status'=>1];
        exit(json_encode(array('Article'=>$arr)));
    }
}
