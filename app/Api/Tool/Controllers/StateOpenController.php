<?php

namespace App\Api\Tool\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendStateOpenRequestJob;
use App\Services\RequestService;
use App\Services\StateOpenRequestService;
use Carbon\Carbon;
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
        $response = RequestService::getInstance()->setHost('https://lms.ouchn.cn')->post('/api/course/activities-read/' . $validated['id'], $validated['data'], $validated['header']);
        return api_response($response);
    }

    /**
     * 批量监听video
     *
     * GET /api/tool/state_open/video_listener/bulk
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postBulkVideoListener(Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'data' => ['required', 'array'],
            'data.\*.id' => ['required', 'array'],
            'data.\*.minute' => ['required', 'integer'],
            'data.\*.second' => ['required', 'integer'],
            'header' => ['required', 'array'],
            'header.cookie' => ['required', 'string']
        ], [], [
            'data' => '请求体',
            'header' => '请求头'
        ]);
        $header = $validated['header'];
        $group = 0;
        collect($validated['data'])->chunk(10)->each(function ($records) use (&$group, $header) {
            foreach ($records as $key => $item) {
                $header['referer'] = 'https://lms.ouchn.cn/course/' . $item['id'] . '/learning-activity/full-screen';
                $duration = (60 * (int)$item['minute']) + (int)$item['second'];
                $postData = [
                    'start' => 0,
                    'end' => $duration,
                    'duration' => $duration
                ];
                // php artisan queue:work --queue=send_state_open_request --tries=2 --max-time=360 --backoff=120
                SendStateOpenRequestJob::dispatch($item['id'], $postData, $header)->onQueue('send_state_open_request')->delay(now()->addSeconds($key * 2)->addMinutes($group * 5));
            }
            $group++;
        });

        return api_response();
    }
}
