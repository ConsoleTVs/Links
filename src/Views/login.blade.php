@extends(config('links.layout'))

@section('title', "Login - Links - Automatic links statistics")

@section('content')

            <div class="row">
                <div class="col-sm-12 col-md-4 offset-md-4">
                    <center>
                        <h1>Login to Links</h1>
                    </center>
                    <br>
                    <div class="card">
                        <div class="card-block">
                            <center>
                                <form method='POST'>
                                    {{ csrf_field() }}
                                    <div class="form-group"><br>
                                        <input type="password" class="form-control" id="password" name='password' aria-describedby="passwordTip" placeholder="Enter password">
                                        @if(session('msg'))
                                            <small id="passwordTip" class="form-text text-muted">{{ session('msg') }}</small>
                                        @endif
                                        <br>
                                        <button type="submit" class="btn btn-primary">Login to Links</button>
                                    </div>
                                </form>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
@endsection
