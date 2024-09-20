<html>
    <head>
    <link href="./css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./vendor/UIjs/themes/base/jquery-ui.css">
    <style>
.page-break {
    page-break-after: always;
}
    </style>
    </head>
    <body style="font-family:Verdana; font-size:10px!important">
    
    <table class="table table-striped table-bordered dataTable no-footer " cellspacing="0">
            <tr>
            <th style='width:50px'>Date</th>
                <th>Désignation</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
            @foreach($mouvements as $mouvement)
                <tr style='line-height: 10px !important'>
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
           <div class="page-break"></div>

       
    </body>
</html>