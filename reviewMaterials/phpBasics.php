<!-- syntaxes -->

<?php
        //variables
        $myint = 5;
        $myfloat = 5.5;
        $myString = "hello";
        $myBool =  true; //1 for true, 0 for false if printed
        
        print $myint + $myfloat; //works ok

        //string contatenation
        print "(" . $myString . ")";

        //casting
        $a = (float) $myfloat;
        $a = intval( $myfloat );
        $a = floatval($myfloat);
?>

<!-- if, for loops -->
<?php
        if($$myInt > 0){
            print "hello";
        }
        else if(){}
        else{}

        for($i = 0; $i < 10; $i++){


        }

        $myArr = array(100,200,300,400);
        array_push($myArr, 999);
        print var_dump($myArr) . "<br>";

        array_splice($myArr, 1, 1);

        $varName  = 0;
        sizeof($varName);
?>

