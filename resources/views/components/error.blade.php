@if($errors->any())
    <div class="col-md-12">
        <br />
        <div class="alert alert-danger">
            <p>The following errors were triggered:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
