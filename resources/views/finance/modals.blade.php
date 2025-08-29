<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransaction" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('finance.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add Transaction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Transaction Type</label>
          <select name="transaction_type" class="form-select" required>
            <option value="">-- Select Type --</option>
            <option value="Income">Income</option>
            <option value="Expense">Expense</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Amount</label>
          <input type="number" name="amount" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <input type="text" name="description" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Date</label>
          <input type="date" name="date" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Transaction Modals -->
@foreach($finances as $finance)
<div class="modal fade" id="editTransaction{{ $finance->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('finance.update', $finance->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Transaction - {{ $finance->description }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Transaction Type</label>
          <select name="transaction_type" class="form-select" required>
            <option value="Income" {{ $finance->transaction_type=='Income' ? 'selected' : '' }}>Income</option>
            <option value="Expense" {{ $finance->transaction_type=='Expense' ? 'selected' : '' }}>Expense</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Amount</label>
          <input type="number" name="amount" value="{{ $finance->amount }}" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <input type="text" name="description" value="{{ $finance->description }}" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Date</label>
          <input type="date" name="date" value="{{ $finance->date }}" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
@endforeach
