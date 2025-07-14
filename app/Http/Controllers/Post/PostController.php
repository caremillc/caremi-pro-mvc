<?php 
namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Careminate\Http\Responses\Response;

class PostController extends Controller
{ 
    public function __construct(){}
    
    public function index()
    { 
        echo 'all posts';
        die;
        return redirect('posts/index.html.twig');     
    }

    public function create(): Response
    {
        return redirect('posts/create.html.twig');
    }

    public function store(): Response
    {
         return redirect("/posts");
    }

   public function show(int $id): Response
    {
       return redirect('posts/show.html.twig');  
    }

    public function edit(int $id): Response
    {
       return redirect('posts/edit.html.twig');  
    }


   public function update(int $id): Response
    {
        return redirect("/posts");
    }

    public function destroy(int $id): Response
    {
        return redirect('/posts');
    }
}
