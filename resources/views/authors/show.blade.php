@extends('app')

@section('content')
    <h1 class="font-bold text-xl">{{$author->firstName}} {{$author->lastName}}</h1>

    <b>Id:</b> {{$author->id}} <br>
    <b>Birthday:</b> {{$author->birthday?->format('d-m-Y')}} <br>
    <b>Gender:</b> {{$author->gender}} <br>
    <b>Place of birth:</b> {{$author->placeOfBirth}} <br>
    <b>Biography:</b> {{$author->biography}} <br>

    <br>
    <br>

    @include('partials/alert')

    @if(sizeof($author->books))
        <h2 class="font-bold text-lg">Books of the author</h2>
        <br>
        <table>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Isbn</th>
                <th>Release date</th>
                <th>Format</th>
                <th>Number of pages</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            @foreach ($author->books as $book)
                <tr>
                    <td>{{$book->id ?? '-'}}</td>
                    <td>{{$book->title ?? '-'}}</td>
                    <td>{{$book->isbn ?? '-'}}</td>
                    <td>{{$book->releaseDate?->format('d-m-Y') ?? '-'}}</td>
                    <td>{{$book->format ?? '-'}}</td>
                    <td>{{$book->numberOfPages ?? '-'}}</td>
                    <td>{{$book->description ?? '-'}}</td>
                    <td>
                        <form action="{{route('books.delete', ['book' => $book->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-400 hover:bg-red-500 px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        There are no books for the author.
    @endif
@endsection