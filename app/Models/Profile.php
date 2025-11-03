<?php 
namespace App\Models;

use Careminate\Models\Model;

class Profile extends Model
{
    protected string $table = 'profiles';
    protected array $fillable = ['user_id', 'bio', 'avatar'];
    public function user() { return $this->belongsTo(User::class); }
}