@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>

                        <script>
                            // Wait for 3 seconds and then reload the page
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        </script> 

                    @endif
                    <form class="form-horizontal" action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="file">CSV File:</label>
                          <div class="col-sm-10">
                            <input type="file" name="file" accept=".csv" requiredclass="form-control" id="file" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="phone">Phone No:</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone no" required>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="period">SMS Period:</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" id="period" min="0" name="period" placeholder="Enter the period minute.Ex: 60" required>
                            </div>
                          </div>
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10"><br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
