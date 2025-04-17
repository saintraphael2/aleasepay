<div class="row input-daterange">

<div class="form-group col-sm-2">
<!--  a href="{{ route('commandeBordereau.form') }}" type="submit"  id="commander" class="btn btn-primary btnSubmit"></a-->
<button  data-bs-toggle="modal" 
          data-bs-target="#modalForCompte" style="margin: 10px;" type="button" class="btn btn-primary mb-3" >
              <i class="fas fa-plus-circle"></i>Commander
          </button>
</div>
</div>
        <table class="table table-bordered table-striped" id="bordereauxTable">
            <thead>
                <tr>
                    <th>Compte</th>
                    <th>Type Bordereau</th>
                    <th>Date de commande</th>
                    <th>Quantité</th>
                    <th>Numéro Ordre</th>
                    <th>Etat </th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    