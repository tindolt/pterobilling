@extends('layouts.admin')

@section('styles')
    <noscript>
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    </noscript>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="" method="POST">
                @csrf
    
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="receiverInput">Notification Receiver's Email Address</label>
                            <input type="email" name="contact" value="{{ $contact }}" class="form-control"id="receiverInput" placeholder="Notification Receiver's Email Address" required>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-center">
                        <button type="submit" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Form Messages</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="messages-table" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:25%">Email</th>
                                <th style="width:20%">Name</th>
                                <th style="width:30%">Subject</th>
                                <th style="width:20%">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td><a href="{{ route('admin.page.contact', ['id' => 'contact', 'msg_id' => $message->id]) }}">{{ $message->id }}</a></td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->subject }}</td>
                                    <td>{{ $message->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:25%">Email</th>
                                <th style="width:20%">Name</th>
                                <th style="width:30%">Subject</th>
                                <th style="width:20%">Date</th>
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
            $("#messages-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
