<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Http\Requests\CreateBookRequest;
use App\Repositories\Contracts\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Contracts\AuthorRepository;

class BooksController
{
    /**
     * Constructor for BooksController
     *
     * @param AuthorRepository $authorRepository
     * @param BookRepository $bookRepository
     */
    public function __construct(
        protected AuthorRepository $authorRepository,
        protected BookRepository $bookRepository
    ) {}

    /**
     * Returns a view to create a new book
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.create', [
            'authors' => $this->authorRepository->all()
        ]);
    }

    /**
     * Stores a new book
     *
     * @param CreateBookRequest $request
     * @return Response
     */
    public function store(CreateBookRequest $request): Response
    {
        $this->bookRepository->create($request->all());

        return redirect()
            ->route('authors.show', [
                'author' => $request->author_id
            ])
            ->with('success', 'A new book is created.');
    }

    /**
     * Deletes a book
     *
     * @param string $id
     * @return Response
     */
    public function delete(string $id): Response
    {
        $this->bookRepository->delete($id);

        return redirect()
            ->back()
            ->with('success', 'Book has been deleted.');
    }
}
