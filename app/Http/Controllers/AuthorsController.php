<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repositories\Contracts\AuthorRepository;

class AuthorsController
{
    // We are injecting a concrete implementation of the AuthorRepository through the RepositoryServiceProvider
    public function __construct(protected AuthorRepository $authorRepository) {}

    public function index(): View
    {
        $authors = $this->authorRepository->all();

        return view('authors.index', [
            'authors' => $authors
        ]);
    }

    public function show(mixed $id): View
    {
        $author = $this->authorRepository->find($id);

        if($author) {
            return view('authors.show', [
                'author' => $author
            ]);
        }

        abort(404);
    }

    public function delete(mixed $id): RedirectResponse
    {
        $author = $this->authorRepository->find($id);

        if($author) {
            if(!empty($author->books)) {
                session()->flash('error', 'Author can not be deleted because related books exist.');
                return redirect()->route('authors.index');
            }

            if($this->authorRepository->delete($id)) {
                session()->flash('success', 'Author has been deleted.');
            } else {
                session()->flash('error', 'Author was not deleted.');
            }
            return redirect()->route('authors.index');
        }

        session()->flash('error', 'Author does not exist.');
        return redirect()->route('authors.index');
    }
}
