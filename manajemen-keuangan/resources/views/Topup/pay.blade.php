<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            window.location.href = '/topup/success'; // Jika sukses, arahkan ke halaman sukses
        },
        onPending: function(result){
            alert("Pending!"); // Tampilkan alert jika status pembayaran pending
            window.location.href = '/topup/create?account_id=1'; // Kembali ke halaman daftar topup
        },
        onError: function(result){
            alert("Failed!"); // Tampilkan alert jika status pembayaran gagal
            window.location.href = '/topup/create?account_id=1'; // Kembali ke halaman daftar topup
        }
    });
</script>
