<h1>Tambah Destinasi</h1>

<form method="POST" action="/destinations">
    @csrf

    <input type="text" name="name" placeholder="Nama"><br><br>
    <input type="text" name="description" placeholder="Deskripsi"><br><br>
    <input type="number" name="price" placeholder="Harga"><br><br>

    <button type="submit">Simpan</button>
</form>