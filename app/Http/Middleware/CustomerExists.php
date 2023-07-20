<?php

namespace App\Http\Middleware;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Traits\Controllers\FormatsErrorResponses;
use Closure;
use Illuminate\Http\Request;

class CustomerExists
{
    use FormatsErrorResponses;

    const ERROR_MESSAGE = 'The requested customer does not exist';

    public function __construct(private CustomerRepositoryInterface $repository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$this->repository->find($request->route('customer'))) {
            throw $this->errorResponse(
                message: self::ERROR_MESSAGE
            );
        }

        return $next($request);
    }
}
