<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Registration Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

   
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
   .step { display: none; }
   .active { display: block; }
</style>


</head>

<body class="hold-transition register-page">
<div class="register-box">

    <div class="register-logo">
        <a href="{{ url('/home') }}"><b>{{ config('app.name') }}</b></a>
    </div>

    <div class="card" style="width:800px">
        <div class="card-body " >
           

          
               
        <div id="formContainer" >
        <!-- Étape 1 -->
        <div id="step1" class="step active">
            <h3>Étape 1: Veuillez saisir votre matricule et votre email</h3>
            <div style='display:none; color:red' id='checkmail'>Le mail saisi ne correspond pas au matricule.</div>
            <label for="matricule">Matricule :</label>
            <input type="text" id="matricule" name="matricule" required>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            
            <button class="next" data-step="1">Suivant</button>
        </div>

        <!-- Étape 2 -->
        <div id="step2" class="step">
        <h3>Étape 2: Un code est envoyé à votre email, veuillez le saisir</h3>
            <div style='display:none; color:red' id='checkcode'>Le code saisi n'est pas valide.</div>
            <label for="code">Code de confirmation:</label>
            <input type="text" id="code" name="code" required>
         
            <button class="previous" data-step="2">Précédent</button>
            <button class="next" data-step="2">Suivant</button>
        </div>

        <!-- Étape 3 -->
        <div id="step3" class="step">
        <button class="previous" data-step="3">Précédent</button>
        <form method="post" action="{{ route('register') }}" id='form'>
        @csrf
            <h3>Étape 3: Saisie des Mots de passe</h3>
            <div style='display:none; color:red' id='checkpassword'>Les mots de passe ne sont pas identiques.</div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <label for="password_confirmation">Confirmez le mot de passe :</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
           
            <button id="submitForm" type='submit'>Soumettre</button>
            </form>
        </div>
    </div>
    </div>
            <a href="{{ route('login') }}" class="text-center">{{ __('auth.registration.have_membership') }}</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->

    <!-- /.form-box -->
</div>
<!-- /.register-box -->


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
                        data:{email:$('#email').val(),matricule:$('#matricule').val()},
                        success:function(data){
                          if(data==1){
                            $("#step" + currentStep).hide();  // Cache l'étape actuelle
                            $("#step" + (currentStep + 1)).show();  // Affiche l'étape suivante
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
                        data:{email:$('#email').val(),code:$('#code').val()},
                        success:function(data){
                          if(data==1){
                            $("#step" + currentStep).hide();  // Cache l'étape actuelle
                            $("#step" + (currentStep + 1)).show();  // Affiche l'étape suivante
                          }else{
                            $('#checkcode').css("display", "block");
                          }
                         
                          
                        }
                      });
                }else if(currentStep==3){
                  
                 
                }
               
            });

            // Bouton "Précédent"
            $(".previous").click(function() {
                var currentStep = $(this).data("step");
                $("#step" + currentStep).hide();  // Cache l'étape actuelle
                $("#step" + (currentStep - 1)).show();  // Affiche l'étape précédente
            });
            $("#submitForm").click(function(e) {
                      e.preventDefault();
                     
                      var password = $("#password").val();
                      var password_confirmation = $("#password_confirmation").val();

                      if (password !== password_confirmation) {
                        $('#checkpassword').css("display", "block");
                      } else{
                        $("#form").submit();
                      }
                  });
            // Validation lors de la soumission du formulaire
            
        });
    </script>
</body>
</html>
