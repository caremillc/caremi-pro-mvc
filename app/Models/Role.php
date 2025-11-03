<?php 
namespace App\Models;

use Careminate\Models\Model;

class Role extends Model
{
    protected string $table = 'roles';
    protected array $fillable = ['name'];
}