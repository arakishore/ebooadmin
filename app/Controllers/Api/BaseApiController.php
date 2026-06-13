<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseApiController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN');
    }

    public function options()
    {
        return $this->response->setStatusCode(204);
    }

    protected function success($data = [], string $message = 'Data fetched successfully')
    {
        return $this->response->setJSON([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function error(string $message = 'Something went wrong', array $errors = [], int $statusCode = 500)
    {
        return $this->response
            ->setStatusCode($statusCode)
            ->setJSON([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ]);
    }

    protected function imageUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        return base_url($path);
    }
}
