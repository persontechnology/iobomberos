@if (Storage::exists($user->foto))
    <a href="{{ Storage::url($user->foto) }}" class="btn-link" data-toggle="tooltip" data-placement="top" title="Ver foto">
        <img src="{{ Storage::url($user->foto) }}" alt="" class="img-fluid" width="45px;">
    </a>
@else
    <img src="{{ asset('img/user.png') }}" alt="" class="img-fluid" width="45px;">
@endif