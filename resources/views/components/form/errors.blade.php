@if (count($errors))
    <div class="alert alert-danger" role="alert">
        <h6 class="alert-heading mb-1">خطا!</h6>
        @foreach ($errors->all() as $error)
            {{ $error }}
            <br>
        @endforeach
    </div>
@endif