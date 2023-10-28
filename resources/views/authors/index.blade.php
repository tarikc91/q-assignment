@extends('app')

@section('content')
    <h1 class="font-bold text-xl">List of authors</h1>

    <br>

    @include('partials/alert')

    @if(sizeof($authors))
        <table>
            <tr>
                <th>Id</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Place of birth</th>
                <th>Actions</th>
            </tr>
            @foreach ($authors as $author)
                <tr>
                    <td>{{$author->id ?? '-'}}</td>
                    <td>{{$author->firstName ?? '-'}}</td>
                    <td>{{$author->lastName ?? '-'}}</td>
                    <td>{{$author->birthday?->format('d-m-Y') ?? '-'}}</td>
                    <td>{{$author->gender ?? '-'}}</td>
                    <td>{{$author->placeOfBirth ?? '-'}}</td>
                    <td class="flex space-x-3">
                        <a class="bg-green-400 hover:bg-green-500 px-2 py-1 rounded" href="{{route('authors.show', ['author' => $author->id])}}">Open</a>
                        <form action="{{route('authors.delete', ['author' => $author->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-400 hover:bg-red-500 px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        There are no authors.
    @endif
@endsection