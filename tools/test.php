<?php

$i=3000;

echo $str = sprintf( "%02d/%05d\n",floor($i/1000),$i);

exit;


$txt='Число пострадавших при аварийной посадке Ту-154 в московском аэропорту Домодедово в субботу возросло до 56, погибших остается двое, сообщил РИА "Новости" представитель Минздравсоцразвития РФ.Число пострадавших при аварийной посадке Ту-154 в московском аэропорту Домодедово в субботу возросло до 56, погибших остается двое, сообщил РИА "Новости" представитель Минздравсоцразвития РФ.';
echo strlen($txt)."\n";
for ($i=256; $i<1024; $i++) {
    if ($txt[$i] == '.')
        break;
}
echo substr( $txt, 0,$i);
