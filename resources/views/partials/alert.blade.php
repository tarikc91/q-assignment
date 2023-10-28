@if(session('error'))
    <div class="text-red-500 bg-red-100 rounded-lg p-3">
        {{session('error')}}
    </div>
    <br>
@endif

@if(session('success'))
    <div class="text-green-500 bg-green-100 rounded-lg p-3">
        {{session('success')}}
    </div>
    <br>
@endif