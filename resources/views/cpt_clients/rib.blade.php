@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                   ATTESTATION D'IDENTITE BANCAIRE
                    </h1>
                </div>
             
                
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                @foreach($cptClients as $cptClient)
                <div class="col-sm-6">
                <a class="btn btn-primary float-right"
                       href="{{ route('attestation',$cptClient->compte) }}">
                                                   Exporter PDF
                                            </a>
                </div>
                <div class="row">
                  <table style='width:1000px; text-align:center; border: 1px solid'>
                    <tr style='border: 1px solid'>
                        <th>Code Banque</th>
                        <th>Code Guichet</th>
                        <th>Numéro de Compte</th>
                        <th>Clé RIB</th>
                    </tr>
                    <tr style='border: 1px solid'>
                        <td>TG215</td>
                        <td>01001</td>
                        <td>{{ $cptClient->compte }}</td>
                        <td>{{ $cptClient->cle }}</td>
                    </tr>
                    <tr style='border: 1px solid'>
                        <th colspan='3'>CODE IBAN</th>
                        
                        <th>CODE BIC</th>
                    </tr>
                    <tr style='border: 1px solid'>
                        <td colspan='3'>TG53TG21501001{{ $cptClient->compte }}{{ $cptClient->cle }}</td>
                        <td>ALTBTGTG</td>
                       
                    </tr>
                    <tr style='border: 1px solid'>
                      
                        <td style="text-align:left">Intitulé du compte</td>
                        <td colspan='3' style="text-align:left;font-weight:bold">{{ $cptClient->intitule }}</td>
                    </tr>
                    <tr style='border: 1px solid'>
                      
                        <td style="text-align:left">Devise</td>
                        <td colspan='3' style="text-align:left;font-weight:bold">{{ $cptClient->devise_code }}  {{ $cptClient->devise_libelle }}</td>
                    </tr>
                    <tr style='border: 1px solid'>
                      
                        <td style="text-align:left">Domiciliation</td>
                        <td colspan='3' style="text-align:left;font-weight:bold">01.001 AFRICAN LEASE TOGO</td>
                    </tr>
                  </table>
                </div><div><p style='background-color:green'></p></div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
