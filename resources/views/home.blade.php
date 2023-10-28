@extends('app')

@section('content')
<div>
    <h1 class="font-bold text-xl">What would you like to do?</h1>
</div>
<br>
<a href="{{route('authors.index')}}">Go to authors -></a>
<br>
<a href="{{route('books.create')}}">Add a book -></a>
@endsection