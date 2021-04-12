@if (is_null(config('app.panel_api_key')))
    <div class="alert alert-danger">
        <h5><i class="icon fas fa-exclamation-triangle"></i> You haven't add a panel application API key to the store settings.</h5>
        Please click <a href="{{ route('admin.setting.show') }}">here</a> to add one so that PteroBilling can create panel users and servers.
    </div>
@endif
