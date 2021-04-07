@extends('layouts.admin')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
    </noscript>
@endsection

@section('content')
    <form action="" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body row">
                        <div class="form-group col-12">
                            <textarea type="text" name="content" id="contentInput" placeholder="Page Body" style="height:200px;" required>{!! $content !!}</textarea>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-center">
                        <button type="submit" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        (function() {
            var css = document.createElement('link');
            css.href = '/plugins/summernote/summernote-bs4.min.css';
            css.rel = 'stylesheet';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>

    <script src="/plugins/summernote/summernote-bs4.min.js"></script>

    <script>$(function () { $('#contentInput').summernote() })</script>
@endsection
