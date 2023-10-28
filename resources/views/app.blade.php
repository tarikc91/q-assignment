<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
            }
            .topnav {
                overflow: hidden;
                background-color: #333;
            }
            .topnav a {
                float: left;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }
            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }
            .topnav a.active {
                background-color: #04AA6D;
                color: white;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
        </style>

        <title>Q Assignment</title>
    </head>
    <body>
        <div class="topnav flex justify-between items-center">
            <div>
                <a class="@if(request()->routeIs('home')) active @endif" href="{{route('home')}}">Home</a>
                @if(isset($authUser) && $authUser->isLoggedIn())
                    <a class="@if(request()->routeIs('authors.*')) active @endif" href="{{route('authors.index')}}">Authors</a>
                    <a class="@if(request()->routeIs('books.*')) active @endif" href="{{route('books.create')}}">Add Book</a>
                @endif
            </div>

            @if(isset($authUser) && $authUser->isLoggedIn())
                <div class="flex items-center mr-10">
                    <div class="text-white mr-3">{{$authUser->firstName}} {{$authUser->lastName}}</div>

                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gray-400 hover:bg-gray-500 px-2 py-1 rounded">Logout</button>
                    </form>
                </div>
            @endif
        </div>
        <div class="p-10">
            @yield('content')
        </div>
    </body>
</html>
