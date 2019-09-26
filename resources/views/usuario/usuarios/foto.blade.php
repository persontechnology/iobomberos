<div class="d-flex align-items-center">
    @if (Storage::exists($user->foto))
    <div class="mr-3">
        <div class="card-img-actions">
            <a href="{{ Storage::url($user->foto) }}" 
                data-toggle="lightbox" data-gallery="img-gallery">
                <img src="{{ Storage::url($user->foto) }}" alt="" class="rounded-circle" width="52" height="52">
                <span class="card-img-actions-overlay card-img">
                    <i class="icon-plus3"></i>
                </span>
            </a>
        </div>
    </div>
    @else
        <img src="{{ asset('img/user.png') }}" alt="" class="img-fluid" width="45px;">
    @endif
</div>