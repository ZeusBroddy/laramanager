<div class="card-body">
    <div class="form-group">
        <label for="">Tipo:</label>
        <select name="type" class="form-control select2 @error('type') is-invalid @enderror">
            <option value="income">Receita</option>
            <option value="expense"
                @isset($entry)
                {{ $entry->type == 'expense' ? 'selected' : '' }}
            @endisset>
                Despesa</option>
        </select>

        @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Categoria:</label>
        <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @isset($university)
                        {{ $entry->category_id == $category->id ? 'selected' : '' }}
                    @endisset>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="">Descrição:</label>
        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
            placeholder="Digite a descrição" value="{{ $entry->description ?? old('description') }}">

        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="">Valor:</label>
            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                placeholder="Digite o valor" value="{{ $entry->amount ?? old('amount') }}">

            @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-6">
            <label for="">Data:</label>
            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                value="{{ $entry->date ?? old('date') }}">

            @error('date')
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
