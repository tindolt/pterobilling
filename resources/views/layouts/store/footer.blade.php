<footer class="main-footer">
    <div class="container">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            @if (config('page.status')) <a {!! to_page('status') !!}>System Status</a> | @endif<a {!! to_page('terms') !!}>Terms of Service</a> | <a {!! to_page('privacy') !!}>Privacy Policy</a>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; {{ date('Y') }} <a {!! to_page('home') !!}>{{ config('app.company_name') }}</a>.</strong> Powered by <a href="https://github.com/pterobilling/pterobilling">PteroBilling</a>.
    </div>
</footer>
