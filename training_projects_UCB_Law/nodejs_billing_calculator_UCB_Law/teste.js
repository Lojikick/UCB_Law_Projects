function adder() {
        let x = parseInt(document.getElementById("numb1").value);
        let y = parseInt(document.getElementById("numb2").value);
        let text;
        text = (x+y);
        let result = text.toString();
        alert(result);
        document.getElementById("p1").innerHTML = result;
    }