<?php declare (strict_types = 1);

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Repository\PostMapper;
use App\Repository\PostRepository;
use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;

class PostController extends Controller
{
    public function __construct(
        private PostMapper $postMapper,
        private PostRepository $postRepository
    ) {}

    // public function index(): Response
    // {
    //  $posts = $this->postRepository->all();
    //     return view('posts.index', ['posts' => $posts]);
    // }

    /**
     * Display a listing of the posts.
     */
    public function index(): Response
    {
        $posts = Post::all();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): Response
    {
        return view('posts.create');
    }

    // public function store(): Response
    // {
    //     $title     = $this->request->post('title');
    //     $body      = $this->request->post('description'); // match your form field
    //     $imageFile = $this->request->files('image');      // Using the new files() method

    //     // Basic validation
    //     if (! $title || ! $body) {
    //         return redirect('/posts/create'); //->with('error', 'Title and Description are required.');
    //     }

    //     $filename = null;

    //     // Handle image upload
    //     if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
    //         $uploadDir = storage_path('app/public/images/');

    //         if (! is_dir($uploadDir)) {
    //             mkdir($uploadDir, 0755, true);
    //         }

    //         $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
    //         $filename  = uniqid('post_', true) . '.' . $extension;

    //         if (! move_uploaded_file($imageFile['tmp_name'], $uploadDir . $filename)) {
    //             return redirect('/posts/create'); //->with('error', 'Failed to upload image.');
    //         }
    //     } elseif ($imageFile && $imageFile['error'] !== UPLOAD_ERR_NO_FILE) {
    //         return redirect('/posts/create'); //->with('error', 'Image upload failed.');
    //     }

    //     // Create post entity
    //     $post = Post::create($title, $body);
    //     $post->setImage($filename); // make sure Post entity has setImage() method

    //     // Save to database via PostMapper
    //     $this->postMapper->save($post);

    //     // Set success flash message
    //     $this->request->getSession()->setFlash('success', sprintf('Post "%s" created successfully.', $title));

    //     return redirect('/posts'); //->with('success', 'Post created successfully!');
    // }

    /**
     * Store a newly created post in storage.
     */
    public function store(): Response
    {
        // Validate the request data
        $data = $this->request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'required|image|max:2048', // 2MB max
        ]);

        try {
            // Handle file upload
            $imagePath = $this->uploadTo($this->request->file('image'));

            // Create the post
             Post::create([
                'title' => $data['title'],
                'body'  => $data['body'],
                'image' => $imagePath,
            ]);

            // Redirect to the post show page with success message
            return redirect('/posts');
            // return redirect('/posts/' . $post->id);
            // ->with('success', 'Post created successfully!');

        } catch (\Exception $e) {
            // Redirect back with error message
            return back();
            // ->withInput()
            // ->with('error', 'Error creating post: ' . $e->getMessage());
        }
    }

    /**
     * Handle image upload
     */
    private function uploadTo($uploadedFile): string
    {
        if (! $uploadedFile || $uploadedFile['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('File upload failed');
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType     = mime_content_type($uploadedFile['tmp_name']);

        if (! in_array($fileType, $allowedTypes)) {
            throw new \Exception('Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.');
        }

        // Validate file size (2MB)
        if ($uploadedFile['size'] > 2 * 1024 * 1024) {
            throw new \Exception('File too large. Maximum size is 2MB.');
        }

        // Create uploads directory if it doesn't exist
        $uploadDir = storage_path('app/public/images/');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        $filename  = uniqid() . '_' . time() . '.' . $extension;
        $filePath  = $uploadDir . $filename;

        // Move uploaded file
        if (! move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
            throw new \Exception('Failed to save uploaded file.');
        }

        // Return the path to store in database (relative to web root)
        return $filename;
    }

    // public function show(int $id): Response
    // {
    //     $post = $this->postRepository->findOrFail($id);
    //     return view('posts.show', compact('post'));
    // }

    /**
     * Display the specified post.
     */
    public function show(int $id): Response
    {
        $post = Post::find($id);

        if (! $post) {
            echo "$post not found";
        }

        return view('posts.show', ['post' => $post]);
    }

    // public function edit(int $id): Response
    // {
    //     $post = $this->postRepository->findOrFail($id);
    //     return view('posts.edit', compact('post'));
    // }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(int $id): Response
    {
        $post = Post::find($id);

        if (! $post) {
            echo "$post not found";
            // return view('errors.404')->withStatus(404);
        }

        return view('posts.edit', ['post' => $post]);
    }

    // public function update(int $id): Response
    // {
    //     // 1️⃣ Fetch existing post
    //     $post = $this->postRepository->findOrFail($id);

    //     // 2️⃣ Extract form inputs
    //     $title       = trim($this->request->post('title'));
    //     $body        = trim($this->request->post('description'));
    //     $imageFile   = $this->request->file('image');
    //     $removeImage = $this->request->post('remove_image') === '1';

    //     // 3️⃣ Determine image directory
    //     $storagePath = storage_path('app/public/images');

    //     if (! is_dir($storagePath)) {
    //         mkdir($storagePath, 0775, true);
    //     }

    //     // 4️⃣ Start with existing image
    //     $imageName = $post->getImage();

    //     // 5️⃣ Handle removal if flagged
    //     if ($removeImage && $imageName) {
    //         $existingPath = $storagePath . '/' . $imageName;
    //         if (is_file($existingPath)) {
    //             unlink($existingPath);
    //         }
    //         $imageName = null;
    //     }

    //     // 6️⃣ Handle new upload
    //     if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
    //         // Delete old image if exists
    //         if ($imageName) {
    //             $existingPath = $storagePath . '/' . $imageName;
    //             if (is_file($existingPath)) {
    //                 unlink($existingPath);
    //             }
    //         }

    //         // Generate new unique name
    //         $ext       = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
    //         $imageName = uniqid('post_', true) . '.' . $ext;

    //         // Move file
    //         $destination = $storagePath . '/' . $imageName;
    //         move_uploaded_file($imageFile['tmp_name'], $destination);
    //     }

    //     // 7️⃣ Update database
    //     $this->postRepository->update($id, $title, $body, $imageName);

    //     // 8️⃣ Flash message
    //     $this->request->getSession()->setFlash('success', "Post \"{$title}\" updated successfully!");

    //     // 9️⃣ Redirect back to show page
    //     return redirect('/posts/' . $id . '/show');
    // }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, int $id): Response
    {
        $post = Post::find($id);

        if (! $post) {
            echo "$post not found";
            // return view('errors.404')->withStatus(404);
        }

        // Validate the request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'nullable|string|max:255',
        ]);

        // Update the post
        $post->update([
            'title' => $data['title'],
            'body'  => $data['body'],
            'image' => $data['image'] ?? null,
        ]);

        // Redirect to the post show page with success message
        return redirect('/posts/' . $post->id);
        // ->with('success', 'Post updated successfully!');
    }

    // public function destroy(int $id): Response
    // {
    //     $this->postRepository->delete($id);

    //     $this->request->getSession()->setFlash('success', 'Post deleted successfully!');
    //     return Response::redirect('/posts');
    // }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(int $id): Response
    {
        $post = Post::find($id);

        if (! $post) {
            echo "$post not found";
            // return view('errors.404')->withStatus(404);
        }

        $post->delete();

        // Redirect to posts index with success message
        return redirect('/posts');
        // ->with('success', 'Post deleted successfully!');
    }

    /**
     * Search posts by title or body content
     */
    public function search(Request $request): Response
    {
        $query = $request->get('q');

        if (! $query) {
            return redirect('/posts');
        }

        // This would require adding a search method to your QueryBuilder
        // For now, we'll get all and filter (not efficient for large datasets)
        $allPosts = Post::all();
        $posts    = array_filter($allPosts, function ($post) use ($query) {
            return stripos($post->title, $query) !== false ||
            stripos($post->body, $query) !== false;
        });

        return view('posts.index', [
            'posts'       => $posts,
            'searchQuery' => $query,
        ]);
    }

    /**
     * API endpoint to get all posts (JSON)
     */
    public function apiIndex(): Response
    {
        $posts = Post::all();

        return response()->json([
            'success' => true,
            'data'    => $posts,
            'count'   => count($posts),
        ]);
    }

    /**
     * API endpoint to get a single post (JSON)
     */
    public function apiShow(int $id): Response
    {
        $post = Post::find($id);

        if (! $post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $post,
        ]);
    }
}
