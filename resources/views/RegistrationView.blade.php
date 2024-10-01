@extends('Layout')
@section('content')
    <h2>Registration Form</h2>
    <form action="javascript:;" id="registerForm" method="POST" enctype="multipart/form-data">
        <h1>Registration Form</h1>
        <label for="timezone">Timezone:</label>
        <select name="timezone" id="timezone">
            @foreach ($timezones as $tz)
                <option value="{{ $tz }}">{{ $tz }}</option>
            @endforeach
        </select>

        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname">

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="hobbies">Select your hobbies:</label>
        <label for="reading">
            <input type="checkbox" id="reading" name="hobbies[]" value="Reading">
            Reading
        </label><br>

        <label for="gaming">
            <input type="checkbox" id="gaming" name="hobbies[]" value="Gaming">
            Gaming</label><br>

        <label for="hiking">
            <input type="checkbox" id="hiking" name="hobbies[]" value="Hiking">
            Hiking</label><br>

        <label for="photography">
            <input type="checkbox" id="photography" name="hobbies[]" value="Photography">
            Photography</label><br>

        <label for="cooking">
            <input type="checkbox" id="cooking" name="hobbies[]" value="Cooking">
            Cooking</label><br>

        <button type="submit" class="button">Register</button>
    </form>
@endsection
@section('js')
    <script>
        $('#registerForm').submit(function() {
            var formValues = $(this).serialize();
            // console.log(formValues);
            $.ajax({
                'type': 'POST',
                'url': "{{ route('register.save') }}",
                'data': formValues,
                success: function(res) {
                    console.log(res);
                    if (res.status) {
                        Swal.fire({
                            title: "Success!",
                            text: res.message,
                            icon: "success"
                        }).then(function() {
                            window.location.href = "{{ route('register.list') }}";
                        });;
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: res.message,
                            icon: "error"
                        });
                    }

                },
                error: function(err) {
                    console.log(err);
                    Swal.fire({
                        title: "Warning!",
                        text: err.text,
                        icon: "warning"
                    });
                }
            });

        });
    </script>
@endsection
