<div class="card-body">

    <div class="form-group">
        <label for="">Nome:</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            placeholder="Digite o nome" value="{{ $plan->name ?? old('name') }}">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Descrição:</label>
        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
            placeholder="Digite uma descrição" value="{{ $plan->description ?? old('description') }}">

        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Valor:</label>
        <input type="number" step=".01" name="amount" class="form-control @error('amount') is-invalid @enderror"
            placeholder="Digite o valor" value="{{ $plan->amount / 100 ?? old('amount') }}">

        @error('amount')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>
