<?php
/**
 * Author: Abel Halo <zxz054321@163.com>
 */

namespace App\Foundation;

use Illuminate\Config\Repository;

class Config extends Repository
{
    public function merge(array $arr)
    {
        $this->items = array_replace_recursive($this->items, $arr);
    }
}