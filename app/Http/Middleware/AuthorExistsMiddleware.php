<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Contracts\AuthorRepository;

class AuthorExistsMiddleware
{
    /**
     * Constructor
     *
     * @param AuthorRepository $authorRepository
     */
    public function __construct(private AuthorRepository $authorRepository) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorId = $request->route()->author;

        if(
            $authorId &&
            !$this->authorRepository->find($authorId)) {
            abort(404);
        }

        return $next($request);
    }
}
