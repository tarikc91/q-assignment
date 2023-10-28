<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CreateBookRequest;
use App\Repositories\Contracts\BookRepository;
use App\Repositories\Contracts\AuthorRepository;

class BooksController
{
    public function __construct(protected AuthorRepository $authorRepository, protected BookRepository $bookRepository) {}

    public function create(): View
    {
        $authors = $this->authorRepository->all();

        return view('books.create', [
            'authors' => $authors
        ]);
    }

    public function store(CreateBookRequest $request): RedirectResponse
    {
        $this->bookRepository->create($request->all());

        session()->flash('success', 'A new book is created.');

        return redirect()->route('authors.show', ['author' => $request->author_id]);
    }

    public function delete(mixed $id): RedirectResponse
    {
        if($this->bookRepository->delete($id)) {
            session()->flash('success', 'Book has been deleted.');
        } else {
            session()->flash('error', 'Book was not deleted.');
        }

        return redirect()->back();
    }
}
