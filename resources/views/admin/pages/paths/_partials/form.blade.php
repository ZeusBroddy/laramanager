<div class="card-body">

    <div class="form-group">
        <label for="">Path name:</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="Type path name" value="{{ $path->name ?? old('name') }}">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>
