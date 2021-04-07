@extends('layouts.admin')

@section('content')
    <form action="" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body row">
                        <div class="form-group col-5 offset-lg-1">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="enable" value="yes" class="custom-control-input" @if ($announcement[0]->value) checked @endif id="enableInput">
                                <label class="custom-control-label" for="enableInput">Show Announcement</label>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="themeInput">Theme</label>
                            <select class="form-control" name="theme">
                                <option value="0" @if ($announcement[3]->value == 0) selected @endif>Success</option>
                                <option value="1" @if ($announcement[3]->value == 1) selected @endif>Info</option>
                                <option value="2" @if ($announcement[3]->value == 2) selected @endif>Warning</option>
                                <option value="3" @if ($announcement[3]->value == 3) selected @endif>Danger</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label for="subjectInput">Subject</label>
                            <input type="text" name="subject" value="{{ $announcement[1]->value }}" class="form-control" id="subjectInput" placeholder="Announcement Subject" required>
                        </div>
                        <div class="form-group col-12">
                            <label for="contentInput">Content</label>
                            <textarea type="text" name="content" class="form-control" id="contentInput" placeholder="Announcement Content" style="height:200px;" required>{{ $announcement[2]->value }}</textarea>
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
