<html>
    <head>

    </head>
    <body style="font-family:Verdana">
        
    <table style='font-family:Verdana;width:700px; text-align:center; border: 1px solid' cellspacing=0 cellpadding=0>
    <tr >
            <td  ><img style="margin:5px;width:300px" src="./images/logoalt.png"></td>
            <td colspan='3' style=" text-align:center;font-weight:bold; padding-left:10px; height:100px">ATTESTATION D'IDENTITE BANCAIRE</td>
        </tr>
        <tr style='border: 1px solid black'>
            <th style='border: 1px solid black; height:40px'>Code Banque</th>
            <th style='border: 1px solid black'>Code Guichet</th>
            <th style='border: 1px solid black'>Numéro de Compte</th>
            <th style='border: 1px solid black'>Clé RIB</th>
        </tr>
        <tr style='border: 1px solid'>
            <td style='border: 1px solid black; height:40px'>TG215</td>
            <td style='border: 1px solid black'>01001</td>
            <td style='border: 1px solid black'>{{ $cptClient->compte }}</td>
            <td style='border: 1px solid black'>{{ $cptClient->cle }}</td>
        </tr>
        <tr style='border: 1px solid'>
            <th style='border: 1px solid; height:40px' colspan='3'>CODE IBAN</th>
            
            <th style='border: 1px solid'>CODE BIC</th>
        </tr>
        <tr style='border: 1px solid'>
            <td style='border: 1px solid; height:40px' colspan='3'>TG53TG21501001{{ $cptClient->compte }}{{ $cptClient->cle }}</td>
            <td style='border: 1px solid black'>ALTBTGTG</td>
            
        </tr>
        <tr  >
            
            <td style=" text-align:left; height:40px; padding-left:10px">Intitulé du compte</td>
            <td colspan='3' style=" text-align:left;font-weight:bold; padding-left:10px">{{ $cptClient->intitule }}</td>
        </tr>
        <tr  >
            
            <td style=" text-align:left; height:40px; padding-left:10px; padding-left:10px">Devise</td>
            <td colspan='3' style=" text-align:left;font-weight:bold; padding-left:10px">{{ $cptClient->devise_code }}  {{ $cptClient->devise_libelle }}</td>
        </tr>
        <tr  >
            
            <td style=" text-align:left; height:40px; padding-left:10px">Domiciliation</td>
            <td colspan='3' style=" text-align:left;font-weight:bold; padding-left:10px">01.001 AFRICAN LEASE TOGO</td>
        </tr>
        </table>
        <div>
            A remettre à tout organisme demandant vos références bancaires
        </div>
    </body>
</html>