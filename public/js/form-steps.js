/*=========================================================================================
  File Name: form-steps.js
  Description: Template form-steps js.
  ----------------------------------------------------------------------------------------
  Item name: 1
  Version: 1.0
  Author: Hodabalo BATASCOME
  Author URL: http://www
==========================================================================================*/

//Configure defaut value
let first = 1
let last = 2
let currentStep = first
let progression = []
let redirect_url = '/home'

//showStep(currentStep)

function configStepsLimit(steps_number=null){
    last = (steps_number) ? steps_number : last
    initializeProgression(last)
}

function initializeProgression(nombre) {
    for (let i = 0; i < nombre; i++) {
        progression[i] = false 
    }
}

function setProgression(nombre) {
    for (let i = 0; i < nombre; i++) {
        progression[i] = true 
        $("#progress-bar-step-"+(i+1)).addClass("active")
    }
}

function setCurrentStep(step){
    currentStep = step
    setProgression(step-1)
}

function setRedirectUrl(route){
    //console.log("route is ", route)
    redirect_url = route
}

function validateStep(step) {
    console.log("original validate step on the way ", step)
    progression[step-1] = true
    nextStep()
    //return true
}

function nextStep() {
    //let validate = validateStep(currentStep)
    //console.log("The validate step is ", validate)
    //if (validate && currentStep < last) {
    enabledLastStepButton()
    if (currentStep < last) {
        setCurrentStep(parseInt(currentStep)+1)
        showStep(currentStep)
        //activate next step on progressbar
	    $("#progress-bar-step-"+currentStep).addClass("active")
    //} else if (validateStep(currentStep) && currentStep == last) {
    } else if (currentStep == last) {
        //console.log("next, current step is",currentStep)
        window.location.href = redirect_url
    }
}

function prevStep() {
    if (currentStep > 1) {
      //currentStep--
      setCurrentStep(currentStep-1)
      showStep(currentStep)

      //activate next step on progressbar
	    $("#progress-bar-step-"+(currentStep+1)).removeClass("active")
    }
}


function showStep(step) {
    //activate next step on progressbar
    $("#progress-bar-step-"+step).addClass("active")
    const steps = document.getElementsByClassName("form-step")
    //console.log("show step : ",step, steps)
    for (let i = 0; i < steps.length; i++) {
      //console.log("boucle showStep : ", i, steps[i].classList)
      //$("#progress-bar-step-"+(i+1)).addClass("active")
      steps[i].classList.remove("active")
    }
    steps[step - 1].classList.add("active")
    //showActions()
}


function enabledLastStepButton() {
    $('.last-step').removeAttr('disabled')
}

function disabledLastStepButton() {
    $('.last-step').attr('disabled','disabled')
}

//To be delete
/* function showActions() {
    //let btn_next_step = document.getElementsByClassName("next-step")
    //$('.cancel-step').addClass("active")
    if(currentStep == first) {
        $('.prev-step').removeClass("active")
        $('.next-step').addClass("active")
        $('.last-step').removeClass("active")
    } else if (currentStep == last) {

    } else {

    }

} */
