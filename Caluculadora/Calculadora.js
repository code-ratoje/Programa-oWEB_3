   function dobro(valor)
   {
      return valor * 2;
   }

   function triplo(valor)
   {
      return valor * 3;
   }

   function quadruplo(valor)
   {
      return valor * 4;
   }
   
   function Calcular()
   {
    let valor1 = document.getElementById("a").value;
    let valor2 = document.getElementById("b").value;
    let valor3 = document.getElementById("c").value;
    let valor4 = document.getElementById("d").value;

   //Conversão do valor pego no html para número
    let n1 = parseFloat(valor1); 
    let n2 = parseFloat(valor2);
    let n3 = parseFloat(valor3);
    let n4 = parseFloar(valor4);

   //puxa a função de calculo do dobro
    let dobro1 = dobro(n1); 
    let dobro2 = dobro(n2);
    let dobro3 = dobro(n3);
    let dobro4 = dobro(n4);

   //exibe o resultado
    document.getElementById("res1").innerText = "Dobro do valor 1:" + dobro1;
    document.getElementById("res2").innerText = "Dobro do valor 2:" + dobro2;
    document.getElementById("res3").innerText = "Dobro do valor 3:" + dobro3;
    document.getElementById("res4").innerText = "Dobro do valor 4:" + dobro4;
   }
