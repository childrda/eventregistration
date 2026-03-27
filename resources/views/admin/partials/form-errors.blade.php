@if ($errors->any())
    <div class="rounded-lg border border-rose-300 bg-rose-50 p-3 text-sm text-rose-700">
        <ul class="list-disc space-y-1 ps-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

