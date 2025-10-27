<?php declare (strict_types = 1);
namespace App\Http\Controllers\Post;

use App\Entity\Post;
use App\Repository\PostMapper;
use App\Repository\PostRepository;
use App\Http\Controllers\Controller;
use Careminate\Http\Responses\Response;
use Careminate\Http\Responses\RedirectResponse;

class PostController extends Controller
{
    public function __construct(
        private PostMapper $postMapper,
        private PostRepository $postRepository
    ) {}

    public function index(): Response
    {
        $posts = "All Posts";

        return view('posts/index.html.twig', compact('posts'));
    }

    public function create(): Response
    {
        // Your logic here
        return view('posts/create.html.twig');
    }

    public function store():  Response
    {
        $title = $this->request->post('title');
        $body  = $this->request->post('body');

        $post = Post::create($title, $body);

        $this->postMapper->save($post);

        return new Response('/posts');
    }

    public function show(int $id): Response
    {
        $post = $this->postRepository->findById($id);
        return view('posts/show.html.twig', compact('post'));
    }

    public function edit(int $id): Response
    {
        // Your logic here
        $postId = "<h1>Edit Post with ID: $id</h1>";
        return view('posts/edit.html.twig', compact('postId'));
    }

    public function update(int $id): Response
    {
        // Your logic here
        return new Response("<h1>Update Post with ID: $id</h1>");
    }

    public function delete(int $id): Response
    {
        // Your logic here
        return new Response("<h1>Delete Post with ID: $id</h1>");
    }
}
