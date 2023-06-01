<li class="pb-3 mb-4 border-bottom">
    <div class="text-center">
        <div class="mt-4 mb-3">
            <img src="{{$currentUser->photo_path}}" id="img-preview-edit" class="rounded-circle img-thumbnail profile-img" alt="User">
        </div>
        <p class="mb-1 normal-line-height logged-user-name text-uppercase text-truncate hr-default-text">{{$currentUser->first_name}} {{$currentUser->last_name}}</p>
        <p class="mb-0 normal-line-height logged-user-title hr-default-text">
            {{ count($currentUser->departments()->get()) > 0 ? $currentUser->departments()->first()->name : "" }}
        </p>
    </div>
</li>
