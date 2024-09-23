<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Registration Page</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ 'css/app.css' }}" rel="stylesheet">
    <style>
    .step {
        display: none;
    }

    .active {
        display: block;
    }
    </style>
</head>

<body class="hold-transition login-page opqone" style="max-height: 1000px !important;">
    <div class="row loginbodybackg">
        <div class="logincustomize signinlocktwo">
            <div class="boxsignin">
                <div class="card signincardctz">

                    <div class="container">
                        <div class="row">
                            <div id="tab1" class="col-sm step_color active" style="width: 260px;height:65px;">
                                <span class="step_icon col-sm ng-scope">1</span>
                                <span class="step_name"> Enregistrement utilisateur</span>
                            </div>
                            <div id="tab2" class="col-sm step_color" style="width: 260px;height: 65px;">
                                <span class="step_icon ng-scope">2</span>
                                <span class=" step_name">Informations contact</span>
                            </div>
                            <div id="tab3" class="col-sm step_color" style="width: 260px;height: 65px;">
                                <span class="step_icon ng-scope">3</span>
                                <span class="step_name  ng-binding">Mot de passe</span>
                            </div>
                        </div>
                    </div>




                    <div class="card-body login-card-body">
                        <!--p class="login-box-msg">{{ __('auth.login.title') }}</p-->
                        <div class="row">
                            <div class="col-12" id="formContainer">
                                <div id="step1" class="step active ">
                                    <h2> 1 Enregistrement</h2>

                                    <div style='display:none; color:red' id='checkmail'>Le mail saisi ne correspond pas
                                        au matricule.</div>


                                    <div class="row form-group">
                                        <label class="col-sm" style="text-align:right;" for="matricule">Matricule
                                            :</label>
                                        <input class="col-sm form-control" id="matricule" name="matricule" required>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm" style="text-align:right;" for="email_init">Email: </label>
                                        <input class="col-sm form-control" type="email_init" id="email_init"
                                            name="email_init" required>
                                    </div>
                                    <div class="button">
                                        <button type="submit" class="next btn btn-primary btn submit-color"
                                            data-step="1" class="next" data-step="1">
                                            Suivant</button>
                                    </div>
                                </div>
                                <div id="step2" class="step">

                                    <!--h3>Étape 2: Un code est envoyé à votre email, veuillez le saisir </h>
                                
                               
                                <label for="code">Code de confirmation:</label>
                                <input type="text" id="code" name="code" required>

                                <button class="previous" data-step="2">Précédent</button>
                                <button class="next" data-step="2">Suivant</button3-->


                                    <h3>Étape 2: Un code est envoyé à votre email, veuillez le saisir</h3>
                                    <div style='display:none; color:red' id='checkcode'>Le code saisi n'est pas valide.
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm" style="text-align: right;" for="code">Email :</label>
                                        <input type="text" class="col-sm form-control" id="code" name="code" required>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm" style="text-align: right;" for="phone">Telephone
                                            :</label>
                                        <input type="tel" id="phone" class="col-sm form-control" name="phone" required>
                                    </div>
                                    <div class="button">
                                        <button class="previous btn btn-primary btn submit-color"
                                            data-step="2">Precedent</button>
                                        <button class="next btn btn-primary btn submit-color"
                                            data-step="2">Suivant</button>
                                    </div>
                                </div>
                                <div id="step3" class="step">
                                    <h2> 3 Mot de passe </h2>
                                    <form method="post" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row form-group">
                                            <label class="col-sm" style="text-align: right;" for="name">Nom
                                                :</label>
                                            <input type="text" name="name" id="name" class="col-sm form-control 
                                             @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                                placeholder="Full name" readonly>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                                            </div>@error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-sm" style="text-align: right;" for="email">email:</label>
                                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                                class="col-sm form-control @error('email') is-invalid @enderror"
                                                placeholder="Email" readonly>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="row form-group">
                                            <label class="col-sm" style="text-align: right;" for="password">Mot de passe
                                                :</label>
                                            <input type="password" name="password"
                                                class="col-sm form-control @error('password') is-invalid @enderror"
                                                placeholder="Mot de passe">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                                            </div>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="row form-group">
                                            <label class="col-sm form-control" style="text-align: right;"
                                                for="confirm_password">Confirmez le mot
                                                de passe :</label>
                                            <input type="password" class="col-sm form-control" id="confirm_password"
                                                name="confirm_password" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-8">
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                                    <label for="agreeTerms">
                                                    J'accepte les termes et conditions générales d'utilisation <a href="#">termes</a>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-4">
                                                <!--button type="submit"
                                                    id="submit" class="btn btn-primary btn-block" disabled='disabled'>Enregistrer</button-->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <div class="button-container">
                                            <button class="previous btn btn-primary btn submit-color"
                                                data-step="3">Precedent</button>
                                            <button type="submit" class="btn btn-primary btn submit-color"
                                                id="submitForm">Soumettre</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ 'js/app.js' }}" defer></script>

            <!--script>
            $(document).ready(function() {
                $(".step").hide();
                $("#step1").show();
                $("#tab1").addClass('active');
                $(".next").click(function() {
                    var currentStep = $(this).data("step");
                    $("#step" + currentStep).hide();
                    $("#step" + (currentStep + 1)).show();
                    $("#tab1").removeClass('active');
                    $("#tab" + (currentStep + 1)).addClass('active');
                    if (currentStep == 2) {
                        $("#tab2").removeClass('active');
                    }
                });
                $(".previous").click(function() {
                    var currentStep = $(this).data("step");
                    $("#step" + currentStep).hide();
                    $("#step" + (currentStep - 1)).show();

<script src="{{ 'js/app.js' }}" defer></script>
<script>
        $(document).ready(function() {
            // Cache toutes les étapes sauf la première
            $(".step").hide();
            $("#step1").show();

            // Bouton "Suivant"
            $(".next").click(function() {
                var currentStep = $(this).data("step");
               
                if(currentStep==1){
                  
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });

                  $.ajax({
                        type:'GET',
                        url:"{{ route('checkemail') }}",
                        data:{email:$('#email_init').val(),matricule:$('#matricule').val()},
                        success:function(data){
                          if(data.nb_elemnt==1){
                            $("#step" + currentStep).hide();  // Cache l'étape actuelle
                            $("#step" + (currentStep + 1)).show();  // Affiche l'étape suivante
                            $('#name').val(data.intitule);
                          }else{
                            $('#checkmail').css("display", "block");
                          }
                         
                          
                        }
                      });
                }else if(currentStep==2){
                  
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });

                  $.ajax({
                        type:'GET',
                        url:"{{ route('checkcode') }}",
                        data:{email:$('#email_init').val(),code:$('#code').val()},
                        success:function(data){
                          if(data==1){
                            $("#step" + currentStep).hide();  // Cache l'étape actuelle
                            $("#step" + (currentStep + 1)).show();  // Affiche l'étape suivante
                            $('#email').val($('#email_init').val());
                          }else{
                            $('#checkcode').css("display", "block");
                          }
                         
                          
                        }
                      });
                }else if(currentStep==3){
                  
                 
                }
               
                    $("#tab" + (currentStep)).removeClass('active');
                    $("#tab" + (currentStep - 1)).addClass('active');
                });
                $("#submitForm").click(function(e) {
                    e.preventDefault();
                    var password = $("#password").val();
                    var confirmPassword = $("#confirm_password").val();
                    if (password !== confirmPassword) {
                        alert("Les mots de passe ne correspondent pas.");
                    } else {
                        alert("Formulaire soumis avec succes !");
                    }
                });
            });
            </script-->


            <script>
            $(document).ready(function() {
                // Cache toutes les étapes sauf la première
                $(".step").hide();
                $("#step3").show();

                // Bouton "Suivant"
                $(".next").click(function() {
                    var currentStep = $(this).data("step");

                    if (currentStep == 1) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'GET',
                            url: "{{ route('checkemail') }}",
                            data: {
                                email: $('#email_init').val(),
                                matricule: $('#matricule').val()
                            },
                            success: function(data) {
                                if (data.nb_elemnt == 1) {
                                    $("#step" + currentStep)
                                        .hide(); // Cache l'étape actuelle
                                    $("#step" + (currentStep + 1))
                                        .show(); // Affiche l'étape suivante
                                    $('#name').val(data.intitule);
                                } else {
                                    $('#checkmail').css("display", "block");
                                }
                            }
                        });
                    } else if (currentStep == 2) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'GET',
                            url: "{{ route('checkcode') }}",
                            data: {
                                email: $('#email_init').val(),
                                code: $('#code').val()
                            },
                            success: function(data) {
                                if (data == 1) {
                                    $("#step" + currentStep)
                                        .hide(); // Cache l'étape actuelle
                                    $("#step" + (currentStep + 1))
                                        .show(); // Affiche l'étape suivante
                                    $('#email').val($('#email_init').val());
                                } else {
                                    $('#checkcode').css("display", "block");
                                }
                            }
                        });
                    } else if (currentStep == 3) {

                    }

                });

                // Bouton "Précédent"
                $(".previous").click(function() {
                    var currentStep = $(this).data("step");
                    $("#step" + currentStep).hide(); // Cache l'étape actuelle
                    $("#step" + (currentStep - 1)).show(); // Affiche l'étape précédente
                });
                $("#submitForm").click(function(e) {
                    e.preventDefault();

                    var password = $("#password").val();
                    var password_confirmation = $("#password_confirmation").val();

                    if (password !== password_confirmation) {
                        $('#checkpassword').css("display", "block");
                    } else {
                        $("#form").submit();
                    }
                });
                // Validation lors de la soumission du formulaire

            });
               
        if($('#agreeTerms').change(function() {
            if ($(this).is(':checked')) { 
                $('#submit').prop( "disabled", false );
            } else {
                $('#submit').prop( "disabled",  true);
            }
        }));
    </script>
            @error('password')
            <script>
            $(document).ready(function() {

                $("#step1").hide();
                $("#step3").show();
            });
            </script>
            @enderror

            @error('email')
            <script>
            $(document).ready(function() {
                $("#step3").show();
                $("#step1").hide();
            });
            </script>
            @enderror

            @error('name')
            <script>
            $(document).ready(function() {
                $("#step3").show();
                $("#step1").hide();
            });
            </script>
            @enderror
</body>

</html>