@extends('layouts.admin')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-lg-6">
                        <label for="nameInput">Category Name</label>
                        <input type="text" name="name" form="saveForm" value="{{ $category->name }}" class="form-control" id="nameInput" placeholder="Category Name" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="orderInput">Order (The smaller, the higher display priority)</label>
                        <input type="number" name="order" min="0" form="saveForm" value="{{ $category->order }}" class="form-control" id="orderInput" placeholder="Order" required>
                    </div>
                </div>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="saveForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                    <form action="" method="POST" id="saveForm">@csrf</form>
                    <form action="{{ route('admin.kb.delete', ['id' => $category->id]) }}" method="POST" id="deleteForm">@csrf</form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Support Articles in this category</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.kb.article.create', ['id' => $id]) }}" class="btn btn-success btn-sm float-right">Create Support Article <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="articles-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:10%">Order</th>
                                <th style="width:10%">ID</th>
                                <th style="width:80%">Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td>{{ $article->order }}</td>
                                    <td><a href="{{ route('admin.kb.article.show', ['id' => $id, 'article_id' => $article->id]) }}">{{ $article->id }}</a></td>
                                    <td>{{ $article->subject }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:10%">Order</th>
                                <th style="width:10%">ID</th>
                                <th style="width:80%">Subject</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            var css = document.createElement('link');
            css.href = '/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css';
            css.rel = 'stylesheet';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>

    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function () {
            $("#articles-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
