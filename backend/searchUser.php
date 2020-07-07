<?php
    include 'dbManager.php';
    $data = "";
    $sql = "SELECT `uid`, `name`, `image`  FROM `user` WHERE `name` LIKE '{$_POST['data']}%' OR `uid` LIKE '{$_POST['data']}%';";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    while($res = mysqli_fetch_array($result)){
        $data .= "^{$res['0']}^{$res['1']}|";
        $data .= "<section class='text-gray-700 body-font overflow-hidden'><div class='container px-5 py-5 mx-auto'>";
        $data .= "<div class='flex flex-wrap -m-12'><div class='p-12 md:w-1/2 flex flex-col items-start'><a class='inline-flex items-center' href='https://mimify.ml/profile.php?id={$res['0']}'>";
        $data .= "<img alt='blog' src='{$res['2']}' class='w-12 h-12 rounded-full flex-shrink-0 object-cover object-center'>";
        $data .= "<span class='flex-grow flex flex-col pl-4'><span class='title-font font-medium text-gray-900'>{$res['1']}</span>";
        $data .= "<span class='text-gray-500 text-sm'>{$res['0']}</span></span></a></div></div></div></section>|";
    }
    echo $data;
?>