<h1>Edit Destinasi</h1>

<form method="POST" action="{{ url('/destinations/' . $destination->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $destination->name }}"><br><br>
    <input type="text" name="description" value="{{ $destination->description }}"><br><br>
    <input type="number" name="price" value="{{ $destination->price }}"><br><br>

    <button type="submit">Update</button>
</form>