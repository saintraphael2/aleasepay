/*=========================================================================================
  File Name: request.js
  Description: Template request js.
  ----------------------------------------------------------------------------------------
  Item name: 1
  Version: 1.0
  Author: Hodabalo
  Author URL: http://www
==========================================================================================*/

//Check to see if the window is top if not then display button
let timer = 2500;

let numberFormatter = new Intl.NumberFormat(
    'fr', 
    {
        style: 'currency', 
        currency: 'xof'
        //minimumFractionDigits: 0, maximumFractionDigits: 0
    });

let spellingNumberOptions = {
    lang: "fr",
    //wholesUnit:"dollars",
    //fractionUnit:"cents",
    //digitsLengthW2F: 2,
    //decimalSeperator:"and"

}


        
function makeApiRequest(type, url, params=null, successUrl, successMessage)
{
    console.log(type,url,params,successUrl,successMessage)

    $.ajax({
        type : type,
        url  : url,
        data : params,
        dataType : 'json',
        headers : getHeaders(),
        success : function(data){
            showSuccess(successUrl, successMessage, data)
            return true
        },
        error : function(data) {
            showError(data)
            return false
        }
    })
}

function reload(url){
    window.location.href = url
}


function getHeaders() {
    let headers = {
        "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
    }
    console.log(headers)
    return headers;
}


function showSuccess(route, message, data) {
    //$('.loader').addClass('hidden')
    console.log("Success", data)

    $('#form-alert').html(null)
    $('#form-alert').removeClass('alert alert-danger')
    $('.is-invalid').removeClass("is-invalid")
    $('.text-danger').html(null)

    if (message) {
        console.log("show message", message)
        $('#form-alert').addClass('alert alert-success')
        $('#form-alert').html("<li>"+message+"</li>")
    }

    if (route != null){
        setTimeout(reload(route), timer)
    }
}


function showError(data, part=null)
{
    console.log("Error",data)
    if(typeof enabledLastStepButton === 'function' ) {
        enabledLastStepButton()
    }
    if(data.status == 200) {
        console.log("Mauvais retour de requete")
    } else {
        let error = "";
        let content = data.responseJSON
    
        $('#form-alert').html(null)
        $('#form-alert').removeClass('alert alert-success')
        $('.is-invalid').removeClass("is-invalid")
        $('.text-danger').html(null)
    
        if (!content){
            error = "<li>Vérifiez votre connexion internet</li>"
        }
    
        if (content.errors){
            console.log("before for",content.errors)
    
            Object.entries(content.errors).forEach(entry => {
                const [key, value] = entry;
                console.log("in the boucle",key, value[0]);
                console.log("#error_"+key+part)
                //var balise =
                /*if (!$('#'+key).hasClass('is-invalid')){
                    $('#'+key+part).addClass('is-invalid')
                }*/
                $('#'+key+part).addClass('is-invalid')
                $('.error_'+key+part).html(value[0])
                //error += "<li>"+value[0]+"</li>"
            });
    
        } else if (content.message){
            error = "<li>"+content.message+"</li>"
        }
    
        if (error) {
            console.log("end error", error)
            $('#form-alert').addClass('alert alert-danger')
            $('#form-alert').html("<li>"+error+"</li>")
        }
    
    }
    
}


