<!-- Modal Revenue Externe -->
<div class="modal fade" id="modalrevenue" tabindex="-1" aria-labelledby="modalrevenueLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalrevenueLabel">Revenue Externe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Body -->
      <div class="modal-body">
        <form id="revenueForm" method="post" action="{{ route('caisse.store') }}">
          @csrf

          <!-- Montant -->
          <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
<input type="number" 
       class="form-control" 
       id="montant" 
       name="montant" 
       min="1" 
       max="9999999999999999.99" 
       step="0.01" 
       value="{{ old('montant') }}" 
       required>

            @error('montant')
              <div class="alert alert-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Motif -->
          <div class="mb-3">
            <label for="motif" class="form-label">Motif</label>
            <input type="text" maxlength="15" class="form-control" id="motif" name="motif" value="{{ old('motif') }}" required>
            @error('motif')
              <div class="alert alert-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Date -->
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
            @error('date')
              <div class="alert alert-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <!-- Hidden user_id -->
          <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        </form>
      </div>
      
      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="revenueForm" class="btn btn-primary">Enregistrer</button>
      </div>

    </div>
  </div>
</div>

<!-- Script pour réouvrir le modal si erreurs -->
@if ($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', function () {
      var myModal = new bootstrap.Modal(document.getElementById('modalrevenue'));
      myModal.show();
  });
</script>
@endif
