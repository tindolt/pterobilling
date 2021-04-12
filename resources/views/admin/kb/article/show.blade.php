@extends('layouts.admin')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-6">
                        <label for="subjectInput">Subject</label>
                        <input type="text" name="subject" value="{{ $article->subject }}" form="saveForm" class="form-control" id="subjectInput" placeholder="Subject" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="orderInput">Order (The smaller, the higher display priority)</label>
                        <input type="number" name="order" value="{{ $article->order }}" form="saveForm" class="form-control" id="orderInput" placeholder="Order" required>
                    </div>
                    <div class="form-group col-12">
                        <textarea type="text" name="content" form="saveForm" id="contentInput" placeholder="Article Content" style="height:200px;" required>{!! $article->content !!}</textarea>
                    </div>
                </div>
                <div class="card-footer row justify-content-center">
                    <a href="{{ route('admin.kb.show', ['id' => $category->id]) }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Save</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2">Delete</button>
                    <form action="{{ route('admin.kb.article.delete', ['id' => $id, 'article_id' => $article->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
    </div>
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
