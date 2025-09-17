<!-- Modal -->
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
          <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="number" class="form-control" id="montant" name="montant" required>
          </div>

          <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          
          <div class="mb-3">
            <label for="motif" class="form-label">Motif</label>
            <input type="text" class="form-control" id="motif" name="motif" required>
          </div>
          
          <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
          </div>
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