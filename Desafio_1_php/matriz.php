<?php
    //  Reginaldo Lopes
    //  2022-02-15 
    // Array para calcular a subtração entre a soma das diagonais 
    // superior/esquerdo => inferior/direito e inferior/esquerdo => superior/direito

    // Declaração do array
    $arrayList = array(
        array(1,2,3),
        array(4,5,6),
        array(9,8,9),
    );

    // Soma dos elementos da primeira diagonal superior/equerdo => inferior/direito
    $addArray1 = $arrayList[0][0] + $arrayList[1][1] + $arrayList[2][2];

    // Soma dos elementos da segunda diagonal inferior/esquero => superior/direito
    $addArray2 = $arrayList[2][0] + $arrayList[1][1] + $arrayList[0][2];
    
    // Resultado da subtração
    $subtractArrays = (int)$addArray1 - (int)$addArray2;

    // Apresenta os resultados no console
    echo "Diagonal 2 = ".$addArray1."\n";
    echo "Diagonal 2 = ".$addArray2."\n";
    echo  "Differença entre diagonais = ".((int)$addArray1 - (int)$addArray2);

?>