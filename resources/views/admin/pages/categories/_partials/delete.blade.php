{{-- !-- Delete Warning Modal -->  --}}
<form action="{{ route('categories.destroy', $category->id) }}" method="post">
    <div class="modal-body">
        @csrf
        @method('DELETE')
        <h5 class="text-center">Tem certeza que deseja excluir a categoria {{ $category->name }} ?</h5>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">Sim, Excluir Categoria</button>
    </div>
</form>
