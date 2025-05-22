@if(session('success'))
    <div class="mx-4 my-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mx-4 my-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
        <ul class="list-disc ml-4">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
