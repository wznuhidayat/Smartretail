<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_product_img extends Model
{
    protected $table = 'product_img';
    protected $primaryKey = 'id_product_image';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_product_img','id_product','img'];
}