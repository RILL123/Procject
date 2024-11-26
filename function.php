<?php
/*
    - function atau method yang tidak mengembalikan nilai
    - function atau metod yang mengembalikan nilai
*/
    //membuat Function yang tidak mengembalikan nilai
    function menampilkan (){
        echo "hello PHP \n";
    }

    function pergi(){
        echo "Saya Pamint";
    }
    //Menampilkan atau memanggil Function
    menampilkan();
    pergi();

    //function mengembalikan nilai
    function  menjumlahkan($angka1,$angka2){
        $hasil = $angka1 + $angka2;
        return $hasil;
    }


    //menampilkan data
    echo "1 + 2 = " ;
    echo menjumlahkan(1,2);


?>