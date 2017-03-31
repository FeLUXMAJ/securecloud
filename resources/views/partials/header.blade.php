<md-toolbar>

    <div class="md-title">
        <a href="/">
            <md-icon>cloud_circle</md-icon>
            SecureCloud
        </a>
    </div>

    @if( Route::currentRouteName() == 'cloud-home' )
        <file-search></file-search>
    @endif

    <div id="toolbar-links">

        <a href="/about">About</a>

        @if(\Illuminate\Support\Facades\Auth::check())

            /

            <a href="/logout">Logout</a>

        @endif

    </div>

</md-toolbar>