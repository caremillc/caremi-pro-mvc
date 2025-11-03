<?php declare (strict_types = 1);
namespace App\Models;

use Careminate\Models\Model;

class Post extends Model
{
    protected static ?string $table = 'posts';
    protected static string $primaryKey = 'id';
    protected array $fillable = ['title', 'body', 'image'];

    // Declare all properties that will be used
    public ?int $id = null;
    public ?string $title = null;
    public ?string $body = null;
    public ?string $image = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
}