@foreach ($user->getRoleNames() as $rol)
    {{ $rol }},
@endforeach