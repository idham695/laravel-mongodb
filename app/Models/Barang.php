<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticatable;

class Barang extends Authenticatable
{
    protected $collection = 'barangs';
    protected $primaryKey = '_id';
}
