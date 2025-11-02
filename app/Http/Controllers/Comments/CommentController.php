<?php declare(strict_types=1);

namespace App\Http\Controllers\Post;

use Careminate\Http\Controllers\AbstractController;
use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use Careminate\Exceptions\NotFoundException;

class CommentController extends AbstractController
{
    public function __construct(
        private PostRepository $postRepository,
        private CommentRepository $commentRepository
    ) {}

    /**
     * Show comments for a post
     */
    public function index(Request $request, int $postId): Response
    {
        $post = $this->postRepository->findOrFail($postId);
        $comments = $this->commentRepository->findByPost($postId);

        return $this->render('posts/show.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    /**
     * Handle new comment submission
     */
    public function store(Request $request, int $postId): Response
    {
        $post = $this->postRepository->findOrFail($postId);

        $author = trim($request->post('author') ?? '');
        $content = trim($request->post('content') ?? '');

        if ($author === '' || $content === '') {
            $request->getSession()->setFlash('error', 'Author and content are required.');
            return redirect('/posts/' . $postId);
        }

        $this->commentRepository->create($postId, $author, $content);

        $request->getSession()->setFlash('success', 'Comment added successfully.');
        return redirect('/posts/' . $postId);
    }

    /**
     * Optional: delete a comment by id
     */
    public function delete(Request $request, int $commentId): Response
    {
        $comment = $this->commentRepository->findById($commentId);

        if (!$comment) {
            $request->getSession()->setFlash('error', 'Comment not found.');
            return redirect('/posts');
        }

        $this->commentRepository->delete($commentId);

        $request->getSession()->setFlash('success', 'Comment deleted successfully.');
        return redirect('/posts/' . $comment->getPostId());
    }
}
