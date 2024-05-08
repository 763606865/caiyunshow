<?php

namespace App\Api\Tool\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StateOpenController extends Controller
{
    /**
     * 监听video
     *
     * GET /api/tool/state_open/video_listener
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postVideoListener(Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'id' => ['required', 'string'],
            'data' => ['required'],
            'header' => ['required']
        ], [], [
            'id' => '文件id',
            'data' => '请求体',
            'header' => '请求头'
        ]);
        $response = RequestService::getInstance()->setHost('https://lms.ouchn.cn')->post('/api/course/activities-read/'.$validated['id'], $validated['data'], $validated['header']);
        return api_response($response);
    }
}
