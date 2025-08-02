<?php declare(strict_types=1);

use Careminate\Http\Responses\Response;

Response::macro('maintenance', fn() =>
    Response::json(['success' => false, 'message' => 'Service under maintenance.'], 503)
);


Response::macro('uppercase', function (): Response {
    /** @var Response $this */
    return $this->content(strtoupper($this->getContent()));
});

Response::macro('success', function (string $message = '', mixed $data = [], int $status = 200): Response {
    return Response::json([
        'success' => true,
        'message' => $message,
        'data' => $data
    ], $status);
});

Response::macro('error', function (string $message = '', mixed $errors = [], int $status = 400): Response {
    return Response::json([
        'success' => false,
        'message' => $message,
        'errors' => $errors
    ], $status);
});

// Response::macro('success', function ($data, $status = 200) {
//     return Response::json(['success' => true, 'data' => $data], $status);
// });

// Response::macro('error', function ($message, $status = 400) {
//     return Response::json(['success' => false, 'error' => $message], $status);
// });


