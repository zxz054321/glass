<?php
/**
 * Author: Abel Halo <zxz054321@163.com>
 */

namespace App\Foundation;

abstract class Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    abstract public function up();

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    abstract public function down();

    /**
     * @return \Illuminate\Database\Schema\Builder
     */
    protected function schema()
    {
        return app('capsule')->schema();
    }
}