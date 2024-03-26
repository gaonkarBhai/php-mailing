<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap & jquery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login | PMS-CCT</title>
</head>

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://img.freepik.com/free-vector/access-control-system-abstract-concept_335657-3180.jpg" class="img-fluid" alt="login image" width="550px">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <div>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form1Example13">Email address</label>
                            <input type="email" id="email" class="form-control form-control-lg" placeholder="abc123@gmail.com" name="email" required />
                        </div>
                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form1Example23">Password</label>
                            <input type="password" id="password" class="form-control form-control-lg" placeholder="12345" name="password" required />
                        </div>
                        <!-- Submit button -->
                        <button type="submit" onclick="loginUser()" class="btn btn-primary btn-lg btn-block">LOGIN</button>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function loginUser() {
            let email = $("#email").val();
            let password = $("#password").val();
            $.ajax({
                url: 'logAuth.php',
                type: 'POST',
                data: {
                    email: email,
                    password: password
                },
                dataType: 'json', // Expect a JSON response
                success: function(response) {
                    if (response.success) {
                        window.location.href = "/tutorials/cct/login/dashboard.php";
                    } else {
                        alert(response.message); // Display the error message
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    console.log('Response:', jqXHR.responseText); // Log the full response text
                }
            });
        }
    </script>
</body>

</html>