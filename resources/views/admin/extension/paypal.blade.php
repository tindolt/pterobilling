@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="col-lg-6">
                            @php
                                $i = 0;
                            @endphp
                            {{--
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="dark_mode" value="yes" class="custom-control-input" @if ($setting[++$i]->value) checked @endif id="darkModeInput">
                                    <label class="custom-control-label" for="darkModeInput">Enable Dark Mode</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="companyNameInput">Company Name</label>
                                <input type="text" name="company_name" value="{{ $setting[$i]->value }}" class="form-control" id="companyNameInput" placeholder="Company Name" required>
                            </div>
                            --}}
                        </div>
                        <div class="col-lg-6">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
