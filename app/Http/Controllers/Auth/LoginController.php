<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repository\UserRepository;
use Careminate\Authentication\SessionAuthentication;
use Careminate\Http\Responses\Response;

class LoginController extends Controller
{
    public function __construct(
        private SessionAuthentication $auth,
        private UserRepository $userRepository
    ) {}

    public function loginForm(): Response
    {
        return view('auth/login.html.twig');
    }

     public function login(): Response
    {
        $email    = $this->request->input('email');
        $password = $this->request->input('password');

        // ✅ Check if user exists before attempting authentication
        $user = $this->userRepository->findByEmail($email);
        if (! $user) {
            //flash('error', 'User does not exist');
            $this->request->getSession()->setFlash('error', sprintf('User "%s" does not exist', $email)); // step 2

            return redirect('/login');
        }

        // ✅ Attempt to authenticate the user
        if (! $this->auth->authenticate($email, $password)) {
            // flash('error', 'Invalid credentials');
            $this->request->getSession()->setFlash('error', sprintf('Invalid credentials')); // step 2

            return redirect('/login');
        }

        //flash('success', 'You are now logged in');
        $this->request->getSession()->setFlash('success', sprintf('You are now logged in')); // step 2
        return view('admin/dashboard.html.twig', ['user' => $user]);
    }

     public function logout(): Response
    {
        // Log the user out
        $this->auth->logout();

        // Set a logout session message
        $this->request->getSession()->setFlash('success', sprintf('Bye..see you soon!')); // step 2

        // Redirect to login page
        return redirect('/login');
    }
}
