@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf

                    <div class="card-body row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enable" value="yes" class="custom-control-input" @if ($affiliate_settings[0]->value) checked @endif id="enableInput">
                                    <label class="custom-control-label" for="enableInput">Enable Affiliate Program</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="conversionInput">Conversion (%)</label>
                                <input type="number" name="conversion" value="{{ $affiliate_settings[1]->value }}" class="form-control" id="conversionInput" placeholder="Conversion Rate" required>
                            </div>
                        </div>
                        <div class="col-lg-6 offset-lg-1">
                            <div class="form-group">
                                <div class="alert alert-info">
                                    For example, when a client purchases a $10-product and the conversion rate is 50%, his/her referer will receive <b>$10 * 50% = $5</b>. This only applies to the first purchase of the client.
                                </div>
                            </div>
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
