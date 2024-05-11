<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ev_evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('名称');
            $table->string('code')->comment('测评编码');
            $table->text('setting')->nullable()->comment('配置');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('测评');
        });
        Schema::create('ev_indicators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->string('code', 40)->unique()->collation('utf8mb4_bin')->comment('编码');
            $table->string('name')->comment('指标名称');
            $table->text('description')->comment('指标说明');
            $table->decimal('z_score')->comment('均值');
            $table->decimal('sd_score')->comment('标准差');
            $table->mediumText('suggestions')->nullable()->comment('建议文案');
            $table->unsignedInteger('weight')->default(0)->index()->comment('排序');
            $table->string('note')->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('指标库');
        });
        Schema::create('ev_measures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->comment('创建人ID');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->unsignedBigInteger('parent_id')->nullable()->index()->comment('父指标ID');
            $table->unsignedBigInteger('indicator_id')->nullable()->index()->comment('指标库ID');
            $table->string('indicator_code', 40)->nullable()->index()->comment('指标库编码');
            $table->string('name')->comment('名称');
            $table->text('description')->comment('说明');
            $table->decimal('z_score')->comment('均值');
            $table->decimal('sd_score')->comment('标准差');
            $table->mediumText('suggestions')->nullable()->comment('建议文案');
            $table->boolean('auto_ratio')->default(false)->comment('自动平均分配下一级权重');
            $table->decimal('ratio')->default(0)->comment('权重');
            $table->unsignedInteger('weight')->default(0)->index()->comment('排序');
            $table->string('note')->nullable()->comment('备注');
            $table->string('path')->index()->comment('层级路径：1/2/3/');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('指标/组');
        });
        Schema::create('ev_norms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->comment('创建人ID');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->unsignedBigInteger('measure_id')->index()->comment('标组ID');
            $table->string('name')->comment('名称');
            $table->mediumText('measures')->comment('指标：json格式');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('计算公式');
        });
        Schema::create('ev_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->comment('创建人ID');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->text('title')->comment('标题');
            $table->string('type', 64)->comment('类型');
            $table->mediumText('extra')->comment('辅助内容：images/videos');
            $table->mediumText('attribute')->comment('属性设置：json格式');
            $table->string('note')->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('题库/目');
        });
        // 用于统计指标库试题数量
        Schema::create('ev_indicators_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('indicator_id')->index()->comment('指标库ID');
            $table->unsignedBigInteger('question_id')->comment('题目ID');
            $table->unique(['question_id', 'indicator_id']);
            $table->comment('指标库-题目关联表');
        });
        Schema::create('ev_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creator_id')->comment('创建人ID');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->unsignedBigInteger('measure_id')->index()->comment('指标组ID');
            $table->string('name')->comment('名称');
            $table->unsignedInteger('estimated_time')->comment('预计用时（分钟）');
            $table->string('note')->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('套卷');
        });
        Schema::create('ev_exams_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('exam_id')->index()->comment('套卷ID');
            $table->unsignedBigInteger('question_id')->comment('题目ID');
            $table->unique(['question_id', 'exam_id']);
            $table->comment('套卷-题目关联表');
        });
        Schema::create('ev_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->unsignedBigInteger('measure_id')->index()->comment('指标组ID');
            $table->string('name')->comment('名称');
            $table->unsignedDecimal('price', 10, 2)->comment('价格');
            $table->unsignedInteger('sales_count')->default(0)->comment('销售次数');
            $table->text('description')->comment('描述');
            $table->unsignedInteger('exacted_time')->comment('限制用时（分钟）');
            $table->boolean('open_response')->default(false)->comment('是否开放作答');
            $table->unsignedTinyInteger('mode')->comment('模式：1-集中测评，2-随来随测');
            $table->string('token')->unique()->collation('utf8mb4_bin');
            $table->dateTime('starts_at')->nullable()->comment('开始时间');
            $table->dateTime('ends_at')->nullable()->comment('结束时间');
            $table->text('memo')->nullable()->comment('备注');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('测评项目');
            $table->index(['starts_at', 'ends_at']);
        });
        Schema::create('ev_projects_exams', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->index()->comment('项目ID');
            $table->unsignedBigInteger('exam_id')->comment('套卷ID');
            $table->unsignedBigInteger('norm_id')->comment('公式ID');
            $table->unique(['project_id', 'exam_id', 'norm_id']);
            $table->comment('项目-套卷关联表');
        });
        Schema::create('ev_respondents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->unsignedBigInteger('product_id')->index()->comment('产品ID');
            $table->unsignedBigInteger('project_id')->index()->comment('测评项目ID');
            $table->string('name')->comment('姓名');
            $table->string('mobile', 20)->comment('手机号');
            $table->string('email')->comment('邮箱');
            $table->string('source', 64)->comment('来源');
            $table->string('token', 128)->unique()->collation('utf8mb4_bin');
            $table->string('last_sign_in_ip', 40)->nullable()->comment('最后登录IP');
            $table->dateTime('last_sign_in_at')->nullable()->comment('最后登录时间');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['mobile', 'project_id']);
            $table->comment('受测人');
        });
        Schema::create('ev_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evaluation_id')->index()->comment('测评ID');
            $table->unsignedBigInteger('product_id')->index()->comment('产品ID');
            $table->unsignedBigInteger('project_id')->index()->comment('测评项目ID');
            $table->unsignedBigInteger('respondent_id')->index()->comment('受测人ID');
            $table->unsignedTinyInteger('status')->comment('作答状态：10-未登录，20-进行中，30-已完成');
            $table->unsignedDecimal('score', 8, 2)->nullable()->comment('得分');
            $table->unsignedInteger('questions_count')->default(0)->comment('题目数');
            $table->unsignedInteger('answered_count')->default(0)->comment('作答数');
            $table->unsignedInteger('duration_in_seconds')->nullable()->comment('用时');
            $table->text('metadata')->nullable()->comment('元数据');
            $table->mediumText('answer')->nullable()->comment('答案信息：json格式');
            $table->mediumText('exam')->nullable()->comment('套卷信息：json格式');
            $table->dateTime('started_at')->nullable()->comment('开始时间');
            $table->dateTime('ended_at')->nullable()->comment('结束时间');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('回收答案');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ev_evaluations');
        Schema::dropIfExists('ev_answers');
        Schema::dropIfExists('ev_respondents');
        Schema::dropIfExists('ev_projects');
        Schema::dropIfExists('ev_projects_exams');
        Schema::dropIfExists('ev_exams_questions');
        Schema::dropIfExists('ev_exams');
        Schema::dropIfExists('ev_indicators_questions');
        Schema::dropIfExists('ev_questions');
        Schema::dropIfExists('ev_norms');
        Schema::dropIfExists('ev_measures');
        Schema::dropIfExists('ev_indicators');
    }
};
