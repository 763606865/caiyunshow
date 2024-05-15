<?php

namespace Database\Seeders;

use App\Models\Evaluation\Evaluation;
use App\Models\Evaluation\Indicator;
use App\Models\Evaluation\Measure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->initEvaluation();
        $this->initIndicator();
        $this->initMeasure();
    }

    private function initEvaluation(): void
    {
        $data = [
            ['code' => 'E20240515', 'name' => '心理测评', 'setting' => ['generate_reports_when_finished' => true]],
            ['code' => 'E20240514', 'name' => '职场测评', 'setting' => ['generate_reports_when_finished' => true]],
            ['code' => 'E20240513', 'name' => '情感测评', 'setting' => ['generate_reports_when_finished' => true]],
            ['code' => 'E20240512', 'name' => '个性测评', 'setting' => ['generate_reports_when_finished' => true]],
        ];
        DB::transaction(static function () use ($data) {
            Evaluation::unguarded(static function () use ($data) {
                foreach ($data as $item) {
                    Evaluation::query()->updateOrCreate([
                        'code' => $item['code']
                    ], $item);
                }
            });
        });
    }

    private function initIndicator(): void
    {
        $data = [
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150001',
                'name' => '反向形成',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150002',
                'name' => '心理预演',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150003',
                'name' => '口欲补偿',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150004',
                'name' => '交往补偿',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150005',
                'name' => '否认',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150006',
                'name' => '认同',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150007',
                'name' => '隔离',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150008',
                'name' => '逞强',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150009',
                'name' => '假性利他',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150010',
                'name' => '理想化',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150011',
                'name' => '回避',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150012',
                'name' => '克制',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
            [
                'evaluation_code' => 'E20240515',
                'code' => 'T202405150013',
                'name' => '仪式抵销',
                'description' => '',
                'suggestions' => [['min' => 0, 'max' => 20, 'description' => '', 'text' => ''],['min' => 20, 'max' => 40, 'description' => '', 'text' => ''],['min' => 40, 'max' => 60, 'description' => '', 'text' => ''],['min' => 60, 'max' => 80, 'description' => '', 'text' => ''],['min' => 80, 'max' => 100, 'description' => '', 'text' => '']]
            ],
        ];
        DB::transaction(static function () use ($data) {
            Indicator::unguarded(static function () use ($data) {
                foreach ($data as $item) {
                    Indicator::query()->updateOrCreate([
                        'code' => $item['code']
                    ], $item);
                }
            });
        });
    }

    private function initMeasure(): void
    {
        $data = [
            [
                'evaluation_code' => 'E20240515',
                'name' => '心理防御测评',
                'description' => '',
                'depth' => 0,
                'children' => [
                    [
                        'name' => '中间型',
                        'description' => '',
                        'depth' => 1,
                        'children' => [
                            'indicator_code' => '',
                            'name' => '反向形成',
                            'description' => '',
                            'depth' => 2
                        ]
                    ]
                ]
            ],
        ];
        DB::transaction(static function () use ($data) {
            Measure::unguarded(static function () use ($data) {
                foreach ($data as $item) {
                    Measure::query()->updateOrCreate([
                        'code' => $item['code']
                    ], $item);
                }
            });
        });
    }
}
