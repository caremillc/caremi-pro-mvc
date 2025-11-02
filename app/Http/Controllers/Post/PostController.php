<?php declare (strict_types = 1);

namespace App\Http\Controllers\Post;

use App\Entity\Post;
use App\Http\Controllers\Controller;
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

    public function index(): Response
    {
        $posts = $this->postRepository->all();
        return view('posts.index', ['posts' => $posts]);
    }

    public function create(): Response
    {
        return view('posts.create');
    }

    public function store(): Response
    {
        $title     = $this->request->post('title');
        $body      = $this->request->post('description'); // match your form field
        $imageFile = $this->request->files('image');      // Using the new files() method

        // Basic validation
        if (! $title || ! $body) {
            return redirect('/posts/create'); //->with('error', 'Title and Description are required.');
        }

        $filename = null;

        // Handle image upload
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $uploadDir = storage_path('app/public/images/');

            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
            $filename  = uniqid('post_', true) . '.' . $extension;

            if (! move_uploaded_file($imageFile['tmp_name'], $uploadDir . $filename)) {
                return redirect('/posts/create'); //->with('error', 'Failed to upload image.');
            }
        } elseif ($imageFile && $imageFile['error'] !== UPLOAD_ERR_NO_FILE) {
            return redirect('/posts/create'); //->with('error', 'Image upload failed.');
        }

        // Create post entity
        $post = Post::create($title, $body);
        $post->setImage($filename); // make sure Post entity has setImage() method

        // Save to database via PostMapper
        $this->postMapper->save($post);

        // Set success flash message
        $this->request->getSession()->setFlash('success', sprintf('Post "%s" created successfully.', $title));

        return redirect('/posts'); //->with('success', 'Post created successfully!');
    }

    public function show(int $id): Response
    {
        $post = $this->postRepository->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit(int $id): Response
    {
        $post = $this->postRepository->findOrFail($id);
        return view('posts.edit', compact('post'));
    }

   

     public function update(int $id): Response
    {
        // 1️⃣ Fetch existing post
        $post = $this->postRepository->findOrFail($id);

        // 2️⃣ Extract form inputs
        $title       = trim($this->request->post('title'));
        $body        = trim($this->request->post('description'));
        $imageFile   = $this->request->file('image');
        $removeImage = $this->request->post('remove_image') === '1';

        // 3️⃣ Determine image directory
        $storagePath = storage_path('app/public/images');

        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0775, true);
        }

        // 4️⃣ Start with existing image
        $imageName = $post->getImage();

        // 5️⃣ Handle removal if flagged
        if ($removeImage && $imageName) {
            $existingPath = $storagePath . '/' . $imageName;
            if (is_file($existingPath)) {
                unlink($existingPath);
            }
            $imageName = null;
        }

        // 6️⃣ Handle new upload
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            // Delete old image if exists
            if ($imageName) {
                $existingPath = $storagePath . '/' . $imageName;
                if (is_file($existingPath)) {
                    unlink($existingPath);
                }
            }

            // Generate new unique name
            $ext = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('post_', true) . '.' . $ext;

            // Move file
            $destination = $storagePath . '/' . $imageName;
            move_uploaded_file($imageFile['tmp_name'], $destination);
        }

        // 7️⃣ Update database
        $this->postRepository->update($id, $title, $body, $imageName);

        // 8️⃣ Flash message
        $this->request->getSession()->setFlash('success', "Post \"{$title}\" updated successfully!");

        // 9️⃣ Redirect back to show page
        return redirect('/posts/' . $id. '/show');
    }

    public function destroy(int $id): Response
    {
        $this->postRepository->delete($id);

        $this->request->getSession()->setFlash('success', 'Post deleted successfully!');
        return Response::redirect('/posts');
    }

    
}
