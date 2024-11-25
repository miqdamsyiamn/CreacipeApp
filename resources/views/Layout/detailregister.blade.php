<!-- Modal Detail Registrasi -->
@if(session('user_details'))
<div class="modal fade" id="registrationDetailsModal" tabindex="-1" aria-labelledby="registrationDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class="mb-4">Registrasi Berhasil</h3>
                <p><strong>Nama:</strong> {{ session('user_details.name') }}</p>
                <p><strong>Email:</strong> {{ session('user_details.email') }}</p>
                <p>Silakan tekan tombol <strong>OK</strong> untuk masuk ke halaman login.</p>
                <button type="button" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif
