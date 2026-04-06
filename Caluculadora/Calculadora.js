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

   function quintuplo(valor)
   {
      return valor * 5;
   }

   function sextuplo(valor)
   {
      return valor * 6;
   }

   function quadrado(valor)
   {
      return valor ** 2;
   }

   function cubo(valor)
   {
      return valor ** 3;
   }

   function quarta_potencia(valor)
   {
      return valor ** 4;
   }

   function quinta_potencia(valor)
   {
      return valor ** 5;
   }   

   function sexta_potencia(valor)
   {
      return valor ** 6;
   }

   function bhaskara(a, b, c)
   {
      let delta = quadrado(b) - 4 * a * c;

      if(delta < 0)
      {
         return"A equação não possui raizes reais(delta negativo)";
      }

      let x1 = (-b + Math.sqrt(delta))/(2 * a);
      let x2 = (-b - Math.sqrt(delta))/(2 * a);

      //toFixed --> arredondamento
      return "x1 = " + x1.toFixed(2) + " e x2 = " + x2.toFixed(2);
   }

   function media_artmetica(a, b, c, d)
   {
      let media = (a + b + c + d)/4;

      return "média aritmética" + media.toFixed(2);
   }

   function par_impar(valor)
   {
      //condição ? valor_se_verdadeiro : valor_se_falso
      return (valor % 2 === 0) ? "PAR" : "IMPAR";
   }

   function Calcular()
   {
    let valor1 = document.getElementById("A").value || 0;
    let valor2 = document.getElementById("B").value || 0;
    let valor3 = document.getElementById("C").value || 0;
    let valor4 = document.getElementById("D").value || 0;

   //Conversão do valor pego no html para número
    let n1 = parseFloat(valor1); 
    let n2 = parseFloat(valor2);
    let n3 = parseFloat(valor3);
    let n4 = parseFloat(valor4);

   //puxa a função de calculo do dobro
    let dobro1 = dobro(n1); 
    let dobro2 = dobro(n2);
    let dobro3 = dobro(n3);
    let dobro4 = dobro(n4);

   //puxa a função de calculo do triplo
    let triplo1 = triplo(n1);
    let triplo2 = triplo(n2);
    let triplo3 = triplo(n3);
    let triplo4 = triplo(n4);

   //puxa a função de calculo do quadruplo
    let quadruplo1 = quadruplo(n1);
    let quadruplo2 = quadruplo(n2);
    let quadruplo3 = quadruplo(n3);
    let quadruplo4 = quadruplo(n4);
   
   //puxa a função de calculo do quintuplo
    let quintuplo1 = quintuplo(n1);
    let quintuplo2 = quintuplo(n2);
    let quintuplo3 = quintuplo(n3);
    let quintuplo4 = quintuplo(n4);
   
   //puxa a função de calculo do sextuplo
    let sextuplo1 = sextuplo(n1);
    let sextuplo2 = sextuplo(n2);
    let sextuplo3 = sextuplo(n3);
    let sextuplo4 = sextuplo(n4);
   
   //puxa a função de calculo do quadrado
    let quadrado1 = quadrado(n1);
    let quadrado2 = quadrado(n2);
    let quadrado3 = quadrado(n3);
    let quadrado4 = quadrado(n4);
   
   //puxa a função de calculo do cubo 
    let cubo1 = cubo(n1);
    let cubo2 = cubo(n2);
    let cubo3 = cubo(n3);
    let cubo4 = cubo(n4);
   
   //puxa a função de calculo do quarta_potencia
    let quarta_potencia1 = quarta_potencia(n1);
    let quarta_potencia2 = quarta_potencia(n2);
    let quarta_potencia3 = quarta_potencia(n3);
    let quarta_potencia4 = quarta_potencia(n4);

   //puxa a função de calculo do quinta_potencia
    let quinta_potencia1 = quinta_potencia(n1);
    let quinta_potencia2 = quinta_potencia(n2);
    let quinta_potencia3 = quinta_potencia(n3);
    let quinta_potencia4 = quinta_potencia(n4);
   
   //puxa a função de calculo do sexta_potencia
    let sexta_potencia1 = sexta_potencia(n1);
    let sexta_potencia2 = sexta_potencia(n2);
    let sexta_potencia3 = sexta_potencia(n3);
    let sexta_potencia4 = sexta_potencia(n4);

   //puxa a função de calculo de bhaskara
    let resBhaskara = bhaskara(n1, n2, n3);
   
   //puxa a função de calculo da média aritiméica
    let resMedia = media_artmetica(n1, n2, n3, n4);
   
   //puxa a função de classificação entre par ou impar
    let par_impar1 = par_impar(n1);
    let par_impar2 = par_impar(n2);
    let par_impar3 = par_impar(n3);
    let par_impar4 = par_impar(n4);

// EXIBIÇÃO NOS INPUTS (Usando .value para inputs)
    document.getElementById("resDobro").value = 'A:' + dobro1 + ' | B:' + dobro2 + ' | C:' + dobro3 + ' | D:' + dobro4;
    document.getElementById("resTriplo").value = 'A:' + triplo1 + ' | B:' + triplo2 + ' | C:' + triplo3 + ' | D:' + triplo4;

    // Para os demais, usei os IDs que você tinha no HTML (mudei .innerText para .value)
    // CORREÇÃO: IDs corrigidos conforme seu último HTML enviado
    document.getElementById("Quadruplo").value = "A:" + quadruplo1 + " | B:" + quadruplo2 + " | C:" + quadruplo3 + " | D:" + quadruplo4;
    document.getElementById("Quintuplo").value = "A:" + quintuplo1 + " | B:" + quintuplo2 + " | C:" + quintuplo3 + " | D:" + quintuplo4;
    document.getElementById("Sextuplo").value = "A:" + sextuplo1 + " | B:" + sextuplo2 + " | C:" + sextuplo3 + " | D:" + sextuplo4;
    document.getElementById("Quadrado").value = "A:" + quadrado1 + " | B:" + quadrado2 + " | C:" + quadrado3 + " | D:" + quadrado4;
    document.getElementById("Cubo").value = "A:" + cubo1 + " | B:" + cubo2 + " | C:" + cubo3 + " | D:" + cubo4;
    document.getElementById("QuartaPotencia").value = "A:" + quarta_potencia1 + " | B:" + quarta_potencia2 + " | C:" + quarta_potencia3 + " | D:" + quarta_potencia4;
    document.getElementById("QuintaPotencia").value = "A:" + quinta_potencia1 + " | B:" + quinta_potencia2 + " | C:" + quinta_potencia3 + " | D:" + quinta_potencia4;
    document.getElementById("SextaPotencia").value = "A:" + sexta_potencia1 + " | B:" + sexta_potencia2 + " | C:" + sexta_potencia3 + " | D:" + sexta_potencia4;
    
    document.getElementById("Bhaskara").value = resBhaskara;
    document.getElementById("MediaAritmetica").value = resMedia;
    document.getElementById("ParesImpares").value = "A:" + par_impar1 + " | B:" + par_impar2 + " | C:" + par_impar3 + " | D:" + par_impar4;
   }