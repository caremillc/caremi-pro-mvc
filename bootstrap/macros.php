<?php 

use Careminate\Http\Responses\Response;

Response::macro('maintenance', fn() =>
    Response::json(['success' => false, 'message' => 'Service under maintenance.'], 503)
);

Response::macro('uppercase', function () {
    return $this->setContent(strtoupper($this->getContent()));
});