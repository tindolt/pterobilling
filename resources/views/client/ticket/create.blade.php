@extends('layouts.client')

@section('content')
    <form action="" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body row">
                        @if ($errors->any())
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    Please fix the following error(s):
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if (session('captcha_error'))
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    Please solve the hCaptcha challenge again.
                                </div>
                            </div>
                        @endif
                        <div class="form-group col-12">
                            <label for="subjectInput">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" id="subjectInput" placeholder="Ticket Subject" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="messageInput">Message</label>
                            <textarea type="text" name="message" class="form-control" id="messageInput" placeholder="Please enter your message here..." style="height:200px;" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    @include('layouts.store.hcaptcha')
                    <div class="card-footer row justify-content-center">
                        <a href="{{ route('client.ticket.index') }}" class="btn btn-default btn-sm col-lg-1 col-md-3">Cancel</a>
                        <button type="submit" class="btn btn-success btn-sm col-lg-2 col-md-4 offset-1">Create Ticket</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
