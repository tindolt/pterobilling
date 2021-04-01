@isset($alerts)
    @if ($alerts->any())
        <div class="alert alert-danger">
            @foreach ($alerts->all() as $alert)
                <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $alert->title }}</h5>
                {{ $alert->message }}
            @endforeach
        </div>
    @endif
@endisset
