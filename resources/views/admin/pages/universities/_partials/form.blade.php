<div class="card-body">

    <div class="form-group">
        <label for="">Path:</label>
        <select name="path_id" class="form-control select2 @error('path_id') is-invalid @enderror">
            @foreach ($paths as $path)
                <option value="{{ $path->id }}"
                    @isset($university)
                            {{ $university->path_id == $path->id ? 'selected' : '' }}
                        @endisset>
                    {{ $path->name }}
                </option>
            @endforeach
        </select>

        @error('path_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="">University name:</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="Type university name" value="{{ $university->name ?? old('name') }}">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="">Address:</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                value="{{ $university->address ?? old('address') }}">

            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-6">
            <label for="">District:</label>
            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror"
                value="{{ $university->district ?? old('district') }}">

            @error('district')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="">City:</label>
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                value="{{ $university->city ?? old('city') }}">

            @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-6">
            <label for="exampleInputFile">University Logo:</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror"
                        id="exampleInputFile" name="avatar">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
            </div>

            @error('avatar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

</div>

@section('js')
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
        $(function() {
            $('.select2').select2();
        });
    </script>
@stop
