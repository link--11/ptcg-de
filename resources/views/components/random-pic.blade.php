@php
    $pics = ['pics/xtra/Digda-s.png', 'pics/xtra/Ditto-s.png', 'pics/xtra/Endivie-s.png', 'pics/xtra/Feurigel-s.png', 'pics/xtra/Jirachi-s.png', 'pics/xtra/Karnimani-s.png', 'pics/xtra/Kokuna-s.png', 'pics/xtra/Lektrobal-s.png', 'pics/xtra/Porygon-Z-s.png','pics/xtra/Kabuto-s.png', 'pics/xtra/Kleinstein-s.png', 'pics/xtra/Magnetilo-s.png', 'pics/xtra/Pantimos-s.png', 'pics/xtra/Papungha-s.png', 'pics/xtra/Traunmagil-s.png', 'pics/xtra/Pummeluff-s.png', 'pics/xtra/Pichu-s.png', 'pics/xtra/Simsala-s.png', 'pics/xtra/Smogon-s.png', 'pics/xtra/Krypuk-s.png', 'pics/xtra/Bluzuk-s.png', 'pics/xtra/Gengar-s.png', 'pics/xtra/Safcon-s.png'];
    $randpic = $pics[rand(0, (count($pics)-1))];
@endphp

<img src="/{{ $randpic }}">
