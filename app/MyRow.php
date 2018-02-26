<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyRow extends Model
{
    protected $table='My_rows';
    protected $fillable=['name','job'];

    public function file() {
        return $this->belongsTo(MyFile::class);
    }
}
