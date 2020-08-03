<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students'; //table di database, tetap didefinisikan walaupun sudah bentuk plural
    protected $fillable = [
        'name', 'class_id', 'gender', 'age', 'address'
    ]; //digunakan untuk mass insert dan update
    protected $guarded = 'id';

}
