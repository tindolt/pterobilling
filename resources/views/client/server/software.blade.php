@extends('layouts.client')

@section('content')
    <form action="" method="POST">
        @csrf

        <div class="row justify-content-center">
            @foreach ($softwares as $extension => $software)
                <input type="hidden" name="extension" value="{{ $extension }}">
                <div class="col-lg-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ str_replace('Extensions\\', '', $extension) }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                @foreach ($software as $software_name => $versions)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="software" value="{{ $software_name }}">
                                        <label class="form-check-label">{{ $software_name }}</label>
                                        <select name="version" class="form-control">
                                            @foreach ($versions as $version)
                                                <option value="{{ $version }}">{{ $version }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12 row justify-content-center mb-2">
                <button type="submit" class="btn btn-primary">
                    Install Software <i class="fa fa-download"></i>
                </button>
            </div>
        </div>
    </form>
@endsection