<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students'; //table di database, tetap didefinisikan walaupun sudah bentuk plural
    protected $fillable = [
        'name', 'class', 'gender', 'age', 'address'
    ]; //digunakan untuk mass insert dan update
    protected $guarded = 'id';

}
