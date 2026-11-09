@csrf

<div class="mb-3">
    <label for="nrp" class="form-label">NRP</label>
    <input type="text" id="nrp" name="nrp" inputmode="numeric" maxlength="10" required class="form-control @error('nrp') is-invalid @enderror" value="{{ old('nrp', $mahasiswa->nrp) }}">
    @error('nrp')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" id="nama" name="nama" required class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mahasiswa->nama) }}">
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="departemen_id" class="form-label">Departemen</label>
    <select id="departemen_id" name="departemen_id" required class="form-select @error('departemen_id') is-invalid @enderror">
        <option value="">Pilih departemen</option>
        @foreach ($departemens as $departemen)
            <option value="{{ $departemen->id }}" @selected(old('departemen_id', $mahasiswa->departemen_id) == $departemen->id)>{{ $departemen->nama }}</option>
        @endforeach
    </select>
    @error('departemen_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="angkatan" class="form-label">Angkatan</label>
    <input type="number" id="angkatan" name="angkatan" required min="2000" max="2100" class="form-control @error('angkatan') is-invalid @enderror" value="{{ old('angkatan', $mahasiswa->angkatan) }}">
    @error('angkatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" id="is_active" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $mahasiswa->is_active))>
    <label for="is_active" class="form-check-label">Mahasiswa aktif</label>
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-link">Batal</a>
