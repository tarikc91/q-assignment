<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Contracts\AuthorRepository;

class AuthorsController
{
    /**
     * Constructor
     *
     * @param AuthorRepository $authorRepository
     */
    public function __construct(protected AuthorRepository $authorRepository) {}

    /**
     * Returns authors index page
     *
     * @return View
     */
    public function index(): View
    {
        return view('authors.index', [
            'authors' => $this->authorRepository->all()
        ]);
    }

    /**
     * Shows an author
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        return view('authors.show', [
            'author' => $this->authorRepository->find($id)
        ]);
    }

    /**
     * Deltete an author
     *
     * @param string $id
     * @return Response
     */
    public function delete(string $id): Response
    {
        $message = $this->authorRepository->delete($id) ?
            ['success', 'Author has been deleted.'] :
            ['error', 'Author could not be deleted.'];

        return redirect()
            ->route('authors.index')
            ->with(extract($message));
    }
}
