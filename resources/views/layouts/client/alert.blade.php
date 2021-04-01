@if (is_null(auth()->user()->api_key))
    <div class="alert alert-warning">
        <h5><i class="icon fas fa-exclamation-triangle"></i> You haven't add a panel API key to your account.</h5>
        Please click <a href="{{ route('client.account.show') }}">here</a> to add one so that we can monitor you servers and install server softwares for you.
    </div>
@endif