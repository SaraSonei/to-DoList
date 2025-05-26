<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>
<body class="bg-gradient-primary">
<div class="container" style="width: 40%">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form method="POST" action="/register">
                            @csrf

                            <x-form-field>
                                <x-form-label for="firstName">First Name</x-form-label>
                                <x-form-input name="firstName" type="text" id="firstName" placeholder="Douglas" required/>
                                <x-form-error name="firstName"/>
                            </x-form-field>
                            <x-form-field>
                                <x-form-label for="lastName">Last Name</x-form-label>
                                <x-form-input name="lastName" type="text" id="lastName" placeholder="McGee" required/>
                                <x-form-error name="lastName"/>
                            </x-form-field>
                            <x-form-field>
                                <x-form-label for="email">Email</x-form-label>
                                <x-form-input name="email" type="email"  id="email" placeholder="sample@sampledomain.com" required/>
                                <x-form-error name="email"/>
                            </x-form-field>
                            <x-form-field>
                                <x-form-label for="password">Password</x-form-label>
                                <x-form-input name="password" type="password" id="password" placeholder="Enter Password" required/>
                                <x-form-error name="password"/>
                            </x-form-field>
                            <x-form-field>
                                <x-form-label for="password_confirmation">Repeat Password</x-form-label>
                                <x-form-input name="password_confirmation" type="password" id="password_confirmation" placeholder="Repeat Password" required/>
                                <x-form-error name="password_confirmation"/>
                            </x-form-field>
                            <hr>
                            <x-form-button>Register Account</x-form-button>
                            <x-form-button type="button" class="btn btn-secondary" >Cancel</x-form-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{ asset('js/sb-admin-2.min.js')}}"></script>
</body>
</html>
