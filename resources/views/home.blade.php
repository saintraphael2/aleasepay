@extends('layouts.app')

@section('content')
    <div class="container-fluid">
    <br><br>
    <div class="content px-3">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>Compte </h3>
                       
                        <p></p><br>
                        Matricule: <b>{{$cptClient->racine}}</b> <br>
                        Numéro de compte: <b>{{$cptClient->compte}}</b> <br>
                        
                  
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="" class="small-box-footer">
                             <i class="fas fa-arrow-circle-right"></i>
                        </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                    <h3> Solde</h3>
                       
                        <p></p><br>
                        <br><b>{{number_format($cptClient->solde, 0,"", " ")}}</b><br>
                        
                    </div>
                    <div class="icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <a href="" class="small-box-footer">
                             <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    
                </div>
            </div>
        </div>    
        </div>      
    </div>
@endsection
