<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function viewMaintenance()
    {
        echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Text</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet"> 
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Fredoka One, cursive;
        }
        body {
            background-color: #383838;
        }
        section {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h1 {
            position: relative;
            font-size: 80px;
            font-weight: 400;
            color: #4d4d4d;
            -webkit-text-stroke: 2px #666666;
        }

        h1::before {
            position: absolute;
            content: attr(data-text);
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: #05a9f3;
            -webkit-text-stroke: 0px #05a9f3;
            overflow: hidden;
            animation: loading 2s ease-out forwards;
            animation-iteration-count: infinite;
        }

        @keyframes loading {
            0% { width: 0; }
            20% { width: 45%; }
            80% { width: 75%; }
            90% { width: 85%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body>
    <section>
        <h1 data-text="Updating...">Updating...</h1>
    </section>
</body>
</html>';

        return;
    }
}
