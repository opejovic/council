@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new thread</div>

                    <div class="card-body">
                        <form method="POST" action="/threads">
                            @csrf

                            <div class="form-group">
                                <label for="title">Thread title</label>
                                <input class="form-control" type="text" name="title" id="title">
                            </div>

                            <div class="form-group">
                                <label for="title">Thread body</label>
                                <textarea class="form-control" name="body" id="body" rows="8"></textarea>
                            </div>

                            <div class="form-group">
                                <button class="form-control btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
