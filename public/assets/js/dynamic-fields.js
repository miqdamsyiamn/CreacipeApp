// Dynamic Field untuk Ingredients
document.getElementById('add-ingredient').addEventListener('click', function () {
  const container = document.getElementById('ingredients-container');
  const div = document.createElement('div');
  div.classList.add('input-group', 'mb-2');
  div.innerHTML = `
      <input type="text" name="ingredients[]" class="form-control" placeholder="Contoh: 1/2 ekor ayam" required>
      <button type="button" class="btn btn-danger remove-ingredient">Hapus</button>`;
  container.appendChild(div);
});

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('remove-ingredient')) {
      e.target.parentElement.remove();
  }
});

// Dynamic Field untuk Steps
document.getElementById('add-step').addEventListener('click', function () {
  const container = document.getElementById('steps-container');
  const div = document.createElement('div');
  div.classList.add('input-group', 'mb-2');
  div.innerHTML = `
      <input type="text" name="steps[]" class="form-control" placeholder="Contoh: Tumis bumbu hingga harum" required>
      <button type="button" class="btn btn-danger remove-step">Hapus</button>`;
  container.appendChild(div);
});

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('remove-step')) {
      e.target.parentElement.remove();
  }
});