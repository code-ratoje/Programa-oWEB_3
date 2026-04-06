//todas as funções com os cálculos dos valores
function dobro(valor) { return valor * 2; }
function triplo(valor) { return valor * 3; }
function quadruplo(valor) { return valor * 4; }
function quintuplo(valor) { return valor * 5; }
function sextuplo(valor) { return valor * 6; }

function quadrado(valor) { return valor ** 2; }
function cubo(valor) { return valor ** 3; }
function quarta_potencia(valor) { return valor ** 4; }
function quinta_potencia(valor) { return valor ** 5; }
function sexta_potencia(valor) { return valor ** 6; }

function bhaskara(a, b, c) {
    let delta = quadrado(b) - (4 * a * c);

    if (delta < 0) return "Sem raízes reais";

    let x1 = (-b + Math.sqrt(delta)) / (2 * a);
    let x2 = (-b - Math.sqrt(delta)) / (2 * a);

    return "x1=" + x1.toFixed(2) + " | x2=" + x2.toFixed(2);
}

function Calcular() {
    // Pegar os valores 
    let n1 = parseFloat(document.getElementById("a").value) || 0;
    let n2 = parseFloat(document.getElementById("b").value) || 0;
    let n3 = parseFloat(document.getElementById("c").value) || 0;
    let n4 = parseFloat(document.getElementById("d").value) || 0;

    // ARRAY = (lista) --> Facilita a realização dos cálculos sem ser necessário a criação de vários LETs
    let lista = [n1, n2, n3, n4];

    // Fazendo o calculo de todos os números com auxílio do "lista.map"
    /* lista.map --> 
    transforma os valores string passados pelo usuário em um "Array"
    calculando o dobro e colocando o resultado em uma nova lista 
    com mesmo número de valores da anterior, mas sendo os valores o resultado da operação pedida
    */

    // lista. --> é apenas o tipo de dado. "map" só pode ser utilizado com arrays, "lista" define o valor como um array
    // porém, como uma variável, o nome pode ser qualquer outro.

    // join --> serve para unir os elementos da lista em uma string utilizando algum elemento de texto como separador
    document.getElementById("resDobro").value = lista.map(dobro).join("   |   ");
    document.getElementById("resTriplo").value = lista.map(triplo).join("   |   ");
    document.getElementById("resQuadruplo").value = lista.map(quadruplo).join("   |   ");
    document.getElementById("resQuintuplo").value = lista.map(quintuplo).join("   |   ");
    document.getElementById("resSextuplo").value = lista.map(sextuplo).join("   |   ");
    document.getElementById("resQuadrado").value = lista.map(quadrado).join("   |   ");
    document.getElementById("resCubo").value = lista.map(cubo).join("   |   ");
    document.getElementById("resQuarta").value = lista.map(quarta_potencia).join("   |   ");
    document.getElementById("resQuinta").value = lista.map(quinta_potencia).join("   |   ");
    document.getElementById("resSexta").value = lista.map(sexta_potencia).join("   |   ");

    // Bhaskara
    document.getElementById("resBhaskara").value = bhaskara(n1, n2, n3);

    // Média Aritmética de todos
    let media = (n1 + n2 + n3 + n4) / 4;
    document.getElementById("resMedia").value = media.toFixed(2); //toFixed --> serve para arredondamento do número, neste caso, até dois números após a virgula

    // Verificação de Pares e Ímpares para todos
    document.getElementById("resParImpar").value = lista.map(n => (n % 2 === 0 ? "Par" : "Impar")).join("   |   ");
}