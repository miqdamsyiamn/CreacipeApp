// Tambahkan Bahan
document.getElementById('add-bahan').addEventListener('click', function() {
  const container = document.getElementById('bahan-container');
  const div = document.createElement('div');
  div.classList.add('input-group', 'mb-2');
  div.innerHTML = `
  <input type="text" name="ingredients[]" class="form-control" placeholder="Masukkan bahan" required>
  <button type="button" class="btn btn-danger remove-bahan">Hapus</button>`;
  container.appendChild(div);
});

// Hapus Bahan
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-bahan')) {
      e.target.parentElement.remove();
  }
});

// Tambahkan Langkah
document.getElementById('add-langkah').addEventListener('click', function() {
  const container = document.getElementById('langkah-container');
  const div = document.createElement('div');
  div.classList.add('input-group', 'mb-2');
  div.innerHTML = `
  <input type="text" name="steps[]" class="form-control" placeholder="Masukkan langkah" required>
  <button type="button" class="btn btn-danger remove-langkah">Hapus</button>`;
  container.appendChild(div);
});

// Hapus Langkah
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-langkah')) {
      e.target.parentElement.remove();
  }
});