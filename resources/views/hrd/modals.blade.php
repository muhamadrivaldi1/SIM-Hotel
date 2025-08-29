<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployee" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('hrd.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Position</label>
          <select name="position" class="form-select" required>
            <option value="">Select Position</option>
            <option value="Manager">Manager</option>
            <option value="Staff">Staff</option>
            <option value="Supervisor">Supervisor</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Salary</label>
          <input type="number" name="salary" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Employee Modals -->
@foreach($employees as $emp)
<div class="modal fade" id="editEmployee{{ $emp->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('hrd.update', $emp->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Employee - {{ $emp->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" value="{{ $emp->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Position</label>
          <select name="position" class="form-select" required>
            <option value="Manager" {{ $emp->position=='Manager' ? 'selected' : '' }}>Manager</option>
            <option value="Staff" {{ $emp->position=='Staff' ? 'selected' : '' }}>Staff</option>
            <option value="Supervisor" {{ $emp->position=='Supervisor' ? 'selected' : '' }}>Supervisor</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Salary</label>
          <input type="number" name="salary" value="{{ $emp->salary }}" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="Active" {{ $emp->status=='Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $emp->status=='Inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
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
