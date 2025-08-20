<html lang="en">

<head>
    <style>
        /**
 * Eric Meyer's Reset CSS v2.0 (http://meyerweb.com/eric/tools/css/reset/)
 * http://cssreset.com
 */
        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* HTML5 display-role reset for older browsers */
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }

        body {
            line-height: 1;
        }

        ol,
        ul {
            list-style: none;
        }

        blockquote,
        q {
            quotes: none;
        }

        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }

        .clearfix {
            display: inline-block;
        }

        /* start commented backslash hack \*/
        * html .clearfix {
            height: 1%;
        }

        .clearfix {
            display: block;
        }

        /* close commented backslash hack */
    </style>
    <style>
        html,
        body {
            height: 100%;
        }

        #banner-wrap {
            text-align: center;
            background: #444 url('/img/t-night/JAS_1102_2.jpg') fixed center no-repeat;
            height: 100%;
            position: relative;
            background-size: 100%;

        }

        #banner {
            text-align: center;
            height: 100%;
            position: fixed;
            width: 100%;
        }

        .main {
            font-family: 'Montserrat', sans-serif;
            font-size: 200px;
            font-weight: 700;
            text-transform: uppercase;
            width: 100%;
            text-align: center;
            padding-top: 150px;
            color: #fff;
            -moz-animation: bounce .40s linear;
            -webkit-animation: bounce .40s linear;
        }

        .sub {
            font-family: 'Montserrat', sans-serif;
            font-size: 44px;
            text-transform: uppercase;
            font-weight: 700;
            width: 100%;
            text-align: center;
            z-index: 1;
            color: #fff;
        }

        .gt-logo {
            background: url('/img/t-night/gt_logo.png');
            width: 100px;
            height: 60px;
            display: block;
            margin: 60px auto 0 auto;
        }

        .scroll-down {
            width: 40px;
            height: 40px;
            background: url('/img/t-night/scroll_down_arrow.png');
            position: absolute;
            bottom: 0px;
            left: 50%;
            margin-left: -20px;
            z-index: 1;
        }

        .highlight {
            color: #CBB57C;
        }

        #wrapper {
            width: 100%;
            position: relative;
        }

        .container {
            font-family: 'Montserrat', sans-serif;
            width: 70%;
            margin: 0 auto;
            z-index: 9;
        }

        #intro {
            padding-top: 30px;
            border-bottom: 3px #444 solid;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        #invitation {
            font-size: 28px;
            color: #444;
            float: left;
            width: 60%;
            line-height: 36px;
        }

        #schedule {
            width: 40%;
            float: left;
            text-align: right;
        }

        h2 {
            font-size: 28px;
            color: #CBB57C;
            margin-bottom: 5px;
        }

        p {
            margin-bottom: 15px;
        }

        #schedule li {
            padding: 7px;
            font-size: 17px;
        }

        #schedule span {
            padding-left: 10px;
        }

        #history {
            color: #444;
            line-height: 27px;
        }

        #sponsors {
            margin: 20px 0;
        }

        .sponsor {
            height: 140px;
            width: 140px;
            display: inline-block;
            background: #AAA;
            margin: 5px;
        }

        #reck-club {
            background: url('/img/t-night/reck_club.png');
        }

        #tiffs {
            background: url('/img/t-night/tiffs_treats.png');
        }

        #inspire {
            background: url('/img/t-night/inspire.png');
        }

        #lotto {
            background: url('/img/t-night/georgia_lottery.jpg');
        }

        #waho {
            background: url('/img/t-night/waffle_house.png');
        }

        #onyx {
            background: url('/img/t-night/onyx.png');
        }

        #naanstop {
            background: url('/img/t-night/naanstop.png');
        }

        #falcons {
            background: url('/img/t-night/falcons.png');
        }

        #shake-shack {
            background: url('/img/t-night/shake-shack.png');
        }

        #athlete {
            background: url('/img/t-night/gatech_athletics.png');
        }

        #chik {
            background: url('/img/t-night/chick_fil_a.png');
        }

        #bj {
            background: url('/img/t-night/ben_jerry.png');
        }

        #parent {
            background: url('/img/t-night/parents_fund.png');
        }

        #HDC {
            background: url('/img/t-night/Home_Depot.png');
        }

        #BWW {
            background: url('/img/t-night/BWW.png');
        }

        footer {
            text-align: center;
            color: #AAA;
            padding: 10px 0;
        }

        @-moz-keyframes bounce {
            0% {
                -moz-transform: scale(0);
                opacity: 0;
            }

            50% {
                -moz-transform: scale(1.3);
                opacity: 0.4;
            }

            75% {
                -moz-transform: scale(0.9);
                opacity: 0.7;
            }

            100% {
                -moz-transform: scale(1);
                opacity: 1;
            }
        }

        @-webkit-keyframes bounce {
            0% {
                -webkit-transform: scale(0);
                opacity: 0;
            }

            50% {
                -webkit-transform: scale(1.3);
                opacity: 0.4;
            }

            75% {
                -webkit-transform: scale(0.9);
                opacity: 0.7;
            }

            100% {
                -webkit-transform: scale(1);
                opacity: 1;
            }
        }
    </style>
    <style>
        /*
        * Skeleton V1.2
        * Copyright 2011, Dave Gamache
        * www.getskeleton.com
        * Free to use under the MIT license.
        * http://www.opensource.org/licenses/mit-license.php
        * 6/20/2012
        */

        /* Table of Content
        ==================================================
            #Site Styles
            #Page Styles
            #Media Queries
            #Font-Face */

        /* #Site Styles
        ================================================== */

        /* #Page Styles
        ================================================== */

        /* #Media Queries
        ================================================== */

        /* Smaller than standard 960 (devices and browsers) */
        @media only screen and (max-width: 959px) {
            .main {
                //padding-top:70px;
                font-size: 157px;
            }
        }

        /* Tablet Portrait size to standard 960 (devices and browsers) */
        @media only screen and (min-width: 768px) and (max-width: 959px) {
            .main {
                font-size: 152px;
            }

            .sub {
                font-size: 32px;
            }
        }

        /* All Mobile Sizes (devices and browser) */
        @media only screen and (max-width: 767px) {
            .main {
                font-size: 109px;
            }

            .sub {
                font-size: 24px;
            }
        }

        /* Mobile Landscape Size to Tablet Portrait (devices and browsers) */
        @media only screen and (min-width: 480px) and (max-width: 767px) {
            #banner-wrap {
                height: 300px;
                background-position: top;
            }

            #banner {
                position: relative;

            }

            .gt-logo {
                display: none;
            }

            .main {
                font-size: 60px;
                padding-top: 100px;
            }

            #invitation,
            #schedule {
                width: 100%;
            }

            #schedule {
                margin-top: 30px;
                text-align: center;
            }

            .container {
                width: 90%;
            }

            .sponsor {
                margin: 0px;
            }



        }

        /* Mobile Portrait Size to Mobile Landscape Size (devices and browsers) */
        @media only screen and (max-width: 479px) {

            #banner-wrap {
                height: 300px;
                background-position: top;
            }

            #banner {
                position: relative;

            }

            .gt-logo {
                display: none;
            }

            .main {
                font-size: 60px;
                padding-top: 100px;
            }

            #invitation,
            #schedule {
                width: 100%;
            }

            #schedule {
                margin-top: 30px;
                text-align: center;
            }

            .container {
                width: 90%;
            }

            .sponsor {
                margin: 0px;
            }
        }


        /* #Font-Face
        ================================================== */
        /* 	This is the proper syntax for an @font-face file
                Just create a "fonts" folder at the root,
                copy your FontName into code below and remove
                comment brackets */

        /*	@font-face {
                font-family: 'FontName';
                src: url('../fonts/FontName.eot');
                src: url('../fonts/FontName.eot?iefix') format('eot'),
                     url('../fonts/FontName.woff') format('woff'),
                     url('../fonts/FontName.ttf') format('truetype'),
                     url('../fonts/FontName.svg#webfontZam02nTh') format('svg');
                font-weight: normal;
                font-style: normal; }
        */
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="/js/jquery-3.2.1.min.js"></script>
    <style></style>
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        $(document).ready(function () {
            $('.main').hover(function () {
                $(this).text("August 24").fadeIn("slow");
            }, function () {
                $(this).text("T-Night").fadeIn("slow");
            });
        });
    </script>
    <title>T-Night 2025 | Ramblin' Reck Club</title>
</head>

<body style="">
    <div id="banner-wrap">
        <div id="banner">
            <div class="main">T-Night</div>
            <div class="sub">Welcome to the Family Tradition</div>
            <div class="gt-logo"></div>
        </div>
        <div class="scroll-down"></div>
    </div>
    <div id="wrapper">
        <div class="container">
            <div id="intro" class="clearfix">
                <div id="invitation">Kickoff the new school year with tons of excitement at T-Night 2024! Come learn all
                    about Georgia Tech spirit and traditions and get ready to cheer on the Jackets all season long!
                    T-Night begins with a festival made up of fun and interactive student organization and traditions
                    booths, free t-shirts and food, games, and more! The event continues with an electric show inside
                    McCamish featuring performance groups, speakers, and your chance to learn the fight song and alma
                    mater! Come join us for a night to remember! All are welcome!

                    Questions? Contact <a href="mailto:rrctnight@gmail.com">rrctnight@gmail.com</a>
                </div>
                <div id="schedule">
                    <h2>Schedule of Events</h2>
                    <ul>
                        <li>Sunday, August 24, 2025</span></li>
                        <li>Traditions Festival - McCamish Parking Lot<span>4:00 PM</span></li>
                        <li>T-Night Show - McCamish Pavilion<span>6:00 PM</span></li>
                    </ul>
                </div>
            </div>
            <div id="history">
                <h2>What is T-Night?</h2>
                <p> A tradition only exists if it stands the test of time. The reason Tech students today still know
                    about Sideways, George P. Burdell, and the Freshman Cake Race can be attributed to the passing down
                    of lore decade to decade. "Traditions Night", now referred to as simply T-Night, has emerged over
                    the past half century as a more engaging and exciting way to preserve Tech history and traditions.
                </p>
                <p> T-Night is an annual, campus-wide event that serves to teach the student body, particularly the
                    incoming freshman class, Tech history and traditions in a fun and interactive manner. With the help
                    of the GT Band, the Georgia Tech Athletic Association (GTAA), and many other student organizations,
                    the Ramblin' Reck Club seeks to instill a sense of pride in students along with knowledge of our
                    school's past. And there's no better way to get excited about football season than a block party
                    with all your fellow students!</p>
                <p></p>
            </div>
            <div id="sponsors">
                <h2 align="center">Put on by Ramblin' Reck Club with the support of its sponsors:</h2>
                <div id="sponsor_block" align="center">
                    <div id="athlete" class="sponsor"></div>
                    <div id="reck-club" class="sponsor"></div>
                    <div id="parent" class="sponsor"></div>
                </div>
                <div id="sponsor_block" align="center">
                    <div id="waho" class="sponsor"></div>
                    <div id="onyx" class="sponsor"></div>
                    <div id="naanstop" class="sponsor"></div>
                    <div id="falcons" class="sponsor"></div>
                    <div id="shake-shack" class="sponsor"></div>

                    <!-- <div id="tiffs" class="sponsor"></div>
                <div id="inspire" class="sponsor"></div>
                <div id="HDC" class="sponsor"></div>
                <div id="BWW" class="sponsor"></div> -->
                </div>
            </div>
        </div>
        <div class="container">
            <footer>© Copyright <?php echo date('Y'); ?> Ramblin' Reck Club. All Rights Reserved.</footer>
        </div>
    </div>

</body>

</html>