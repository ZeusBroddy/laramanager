<div class="card-body">
    <div class="form-group">
        <label for="">Nome:</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="Digite o nome" value="{{ $path->name ?? old('name') }}">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>
