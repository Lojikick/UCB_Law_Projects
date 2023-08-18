// Code to hide all elements below the "Calculate" button before submission

// Helper functions and other code as needed

// This function is executed on submission of the HTML form

//Person 1 and person 2 should pay diff amounts, person one amount + percentage their tipping off of their person one amount
function calculateBill() {
    
    let amt1 = parseInt(document.getElementById("person1amt").value);
    let amt2 = parseInt(document.getElementById("person2amt").value); 
    let amttax = parseInt(document.getElementById("billamt").value); 
    let tip = parseFloat(document.getElementById("tipamt").value);
    let radios = document.getElementsByName('tax');
    let taxcalc;
    og = amt1 + amt2;
    for (var radio of radios){
        if(radio.checked){
            taxcalc = radio.value;
        }
    }
    let finalTip;
    let finalAmt;

    if (taxcalc == "after"){
        finalTip = (amttax)*(tip);
    }else if (taxcalc == "before"){
        finalTip = (amt1+amt2)*(tip);
    }
    finalAmt = (amttax)+(finalTip);
    split = (finalAmt/og)-1;
    document.getElementById("tip").innerHTML =(finalTip.toString());
    document.getElementById("bill").innerHTML =(finalAmt.toString());
    document.getElementById("person1").innerHTML =((amt1+(amt1*split)).toString());
    document.getElementById("person2").innerHTML =((amt2+(amt2*split)).toString());
}