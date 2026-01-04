<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form action="{{ route('student.register') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="text" name="name" placeholder="Full Name" required><br><br>

    <input type="text" name="phone" placeholder="Phone Number" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="file" name="college_id" accept="image/*" required><br><br>

    <button type="submit">Submit</button>

</form>

</body>
</html>
