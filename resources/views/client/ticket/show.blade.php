@extends('layouts.client')

@inject('ticket_model', 'App\Models\TicketContent')
@inject('client_model', 'App\Models\Client')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Ticket Information</h5>
                </div>
                <div class="card-body row">
                    <div class="col-lg-4 col-md-8 mb-1">
                        <h6 class="card-title">Subject</h6>
                        <p class="card-text">{{ $ticket->subject }}</p>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-1">
                        <h6 class="card-title">Status</h6>
                        <p class="card-text">
                            @switch($ticket->status)
                                @case(0)
                                    <span class="badge bg-success">Resolved</span>
                                    @break
                                @case(1)
                                    <span class="badge bg-info">Open</span>
                                    @break
                                @case(2)
                                    <span class="badge bg-warning">Pending</span>
                                    @break
                                @case(3)
                                    <span class="badge bg-danger">Closed</span>
                                    @break
                            @endswitch
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-1">
                        <h6 class="card-title">Created Date</h6>
                        <p class="card-text">{{ $ticket->created_at }}</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-1">
                        <h6 class="card-title">Updated Date</h6>
                        <p class="card-text">{{ $ticket->updated_at }}</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-1">
                        <a href="{{ route('client.ticket.index') }}" class="card-link"><i class="fas fa-arrow-left text-sm"></i> View All Tickets</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="direct-chat-messages">
                        @foreach ($ticket_model->where('ticket_id', $ticket->id)->get() as $ticket_content)
                            @if ($ticket_content->replier_id == auth()->user()->id)
                                <div class="direct-chat-msg right">
                                    <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-right">{{ auth()->user()->email }}</span>
                                        <span class="direct-chat-timestamp float-left">{{ $ticket_content->created_at }}</span>
                            @else
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-left">{{ $client_model->find($ticket_content->replier_id)->value('email') }}</span>
                                        <span class="direct-chat-timestamp float-right">{{ $ticket_content->created_at }}</span>
                            @endif
                                </div>
                                <div class="direct-chat-text">
                                    {{ $ticket_content->message }}
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-header">
                        <h5 class="card-title m-0">Add Reply</h5>
                    </div>
                    <div class="card-body row">
                        <div class="form-group col-12">
                            <label for="messageInput">Message</label>
                            <textarea type="text" name="message" class="form-control" id="messageInput" placeholder="Please enter your message here..." style="height:200px;" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    @include('layouts.store.hcaptcha')
                    <div class="card-footer row justify-content-center">
                        <button type="submit" class="btn btn-primary btn-sm col-lg-1 col-md-3">Reply</button>
                        <button type="submit" name="solved" value="true" form="solvedForm" class="btn btn-success btn-sm col-lg-2 col-md-4 offset-1">Mark Solved</button>
                    </div>
                </form>
                <form action="" method="POST" id="solvedForm"> @csrf </form>
            </div>
        </div>
    </div>
@endsection
