<!-- CSS LAZY-LOADING SCRIPTS -->
<script>
    (function() {
        var css = document.createElement('link');
        css.href = 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback';
        css.rel = 'stylesheet';
        document.getElementsByTagName('head')[0].appendChild(css);
    })();
    (function() {
        var css = document.createElement('link');
        css.href = '/plugins/fontawesome-free/css/all.min.css';
        css.rel = 'stylesheet';
        document.getElementsByTagName('head')[0].appendChild(css);
    })();
</script>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<!-- hCaptcha -->
<script src='https://www.hCaptcha.com/1/api.js' async defer></script>

<!-- CUSTOM SCRIPTS -->
@yield('scripts')
