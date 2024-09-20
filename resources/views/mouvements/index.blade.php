@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Mouvements du compte {{$compte}}  -- {{$deb->format('d-m-Y')}} au {{$fin->format('d-m-Y')}}</h4>
                </div>
            </div>
        </div>
    </section>
    <div class="content px-3">
        @include('flash::message')
        <div class="clearfix"></div>
     
        <div class="row input-daterange">
            
        <div class="form-group col-sm-3">
                {!! Form::label('compte', 'Comptes :') !!}
                <select name="compte" id="compte" class = 'form-control'>
                    @foreach($comptes as $compte)
                    <option value="{{$compte->id}}">{{$compte->compte}}</option>
                    @endforeach
                </select>
                
                <span class="text-danger font-size-xsmall error_date_debut"></span>
            </div>
  <!-- Date Signature Field -->
  <div class="form-group col-sm-3">
                {!! Form::label('date_debut', 'Date début (jj-mm-aaaa) :') !!}
                {!! Form::text('date_debut', null, ['class' => 'form-control','id'=>'date_debut']) !!}
                <span class="text-danger font-size-xsmall error_date_debut"></span>
            </div>

            <!-- Date Debut Field -->
            <div class="form-group col-sm-3">
                {!! Form::label('date_fin', 'Date fin (jj-mm-aaaa) :') !!}
                {!! Form::text('date_fin', null, ['class' => 'form-control','id'=>'date_fin']) !!}
                <span class="text-danger font-size-xsmall error_date_fin"></span>
            </div>

            <div class="form-group col-sm-3" style="margin-top: 2rem;">
                <button type="submit" name="filter" id="filter" class="btn btn-primary">Filtrer</button>
                
            </div></div>

          
        
        <div class="card">
           <table class="table table-striped table-bordered dataTable no-footer">
            <tr>
            <th>Date</th>
                <th>Désignation</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
            @foreach($mouvements as $mouvement)
                <tr>
                <td>{{$mouvement->LOT_DATE->format('d-m-Y')}}</td>
                    <td>{{$mouvement->ECRCPT_LIBELLE }} {{$mouvement->ECRCPT_LIBCOMP}}</td>
                    <td style="text-align:right">
                        @if($mouvement->ECRCPT_SENS=='D')
                            {{number_format($mouvement->ECRCPT_MONTANT, 0,"", " ") }}
                        @endif
                    </td>
                    <td style="text-align:right">

                    @if($mouvement->ECRCPT_SENS=='C')
                    {{number_format($mouvement->ECRCPT_MONTANT, 0,"", " ") }}
                        @endif
                    </td>
                </tr>
            @endforeach
           </table>
        </div>
    </div>

@endsection
@push('page_scripts')
<script>

    $('#date_debut').datepicker()
    $('#date_fin').datepicker()


        $('#filter').click(function(){
            let fromDate = $('#date_debut').val()
            let toDate = $('#date_fin').val()
            let redirect_url = "mouvements?compte="+$('#compte option:selected').text()
            
            if(fromDate != '' &&  toDate != ''){
                
                redirect_url += "&deb="+fromDate+"&fin="+toDate
            } 
            
            /*
            //alert('Both Date is required')
            let erreur = {
                responseJSON : {message : "Les deux dates sont obligatoires"}
            }
            showError(erreur, "")*/
            
            console.log("redirect Url : ", redirect_url)
            window.location.href =redirect_url
        });

        $('#refresh').click(function(){
            //$('#date_debut').val('')
            //$('#date_fin').val('')

            
            console.log("redirect Url : ", redirect_url)
            showSuccess(redirect_url, null, null)
        });

        var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
</script>
@endpush