<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Myfile extends Model
{
    protected $table='My_files';

    public function rows() {
        return $this->hasMany(MyRow::class);
    }
}
