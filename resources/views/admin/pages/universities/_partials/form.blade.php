<div class="card-body">

    <div class="form-group">
        <label for="">Rota:</label>
        <select name="path_id" class="form-control select2 @error('path_id') is-invalid @enderror" style="width: 100%">
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
        <label for="">Nome:</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="UNIR" value="{{ $university->name ?? old('name') }}">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group row">
        <div class="col-sm-6">
            <label for="">Endereço:</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                placeholder="Av São Paulo, 1111" value="{{ $university->address ?? old('address') }}">

            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm=6">
            <label for="">Bairro:</label>
            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror"
                placeholder="Centro" value="{{ $university->district ?? old('district') }}">

            @error('district')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-6">
            <label for="">Cidade:</label>
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                placeholder="Cacoal" value="{{ $university->city ?? old('city') }}">

            @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm-6">
            <label for="inputLogo">Logo da Faculdade:</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror"
                        id="inputLogo" name="avatar">
                    <label class="custom-file-label" for="inputLogo">Selecionar Arquivo</label>
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

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>

@section('js')
    <script>
        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2();
        });
    </script>
@stop
