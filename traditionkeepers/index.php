<html lang="en">
<head>
    <link rel="stylesheet" href="/css/bootstrap.min.css?v=<?php echo filemtime(dirname(__FILE__, 2) . '/css/bootstrap.min.css'); ?>">
    <style>
        .dark-bg{
            text-align: center;
            background: #444 ;
            /*background-size:100%;*/
            padding-bottom: 20px;

        }
        h1 {
            font-family: 'Montserrat', sans-serif;
            /*font-size:90px;*/
            font-weight:700;
            text-transform: uppercase;
            /*width:100%;*/
            padding-top:30px;
            text-align: center;
            color:#fff;
            -moz-animation:bounce .40s linear;
            -webkit-animation:bounce .40s linear;
        }
        h4.sub {
            font-family: 'Montserrat', sans-serif;
            /*font-size: 30px;*/
            text-transform: uppercase;
            font-weight:400;
            padding-top: 10px;
            width:100%;
            text-align: center;
            z-index: 1;
            color:#fff;
        }

        .highlight{
            color:#CBB57C;
        }


        .container{
            font-family: 'Montserrat', sans-serif;
            width:80%;
            margin: 0 auto;
            z-index: 1;
        }
        .btn-primary {
            background-color: #CBB57C;
            border-color: #CBB57C;
            color: white;
            font-family: 'Montserrat', sans-serif;
        }

        .btn.btn-primary.focus,
        .btn.btn-primary:focus,
        .btn.btn-primary:hover,
        .btn.btn-primary:active.focus,
        .btn.btn-primary:active:focus,
        .btn.btn-primary:active:hover,
        .btn.btn-primary:hover{
            background-color: #B3A369 !important;
            border-color: #B3A369 !important;
        }


        h2{
            color:#CBB57C;
            margin-bottom: 15px;
        }
        p{
            margin-bottom: 15px;
        }

        footer{
            text-align: center;
            color:#AAA;
            padding:10px 0;
        }

        @-moz-keyframes bounce {
            0%{ -moz-transform:scale(0); opacity:0;}
            50%{ -moz-transform:scale(1.3); opacity:0.4; }
            75%{ -moz-transform:scale(0.9); opacity:0.7;}
            100%{ -moz-transform:scale(1); opacity:1;}
        }

        @-webkit-keyframes bounce {
            0%{ -webkit-transform:scale(0); opacity:0;}
            50%{ -webkit-transform:scale(1.3); opacity:0.4;}
            75%{ -webkit-transform:scale(0.9); opacity:0.7;}
            100%{ -webkit-transform:scale(1); opacity:1;}
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="/js/jquery-3.2.1.min.js"></script><style></style>
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <title>Tradition Keepers</title>
</head>
<body style="">
<div id="container-fluid">
    <div class="dark-bg">
        <h1>Tradition Keepers</h1>
        <h4 class="sub">Participate in traditions. <span class="highlight">Submit photos.</span> Win prizes.</h4>
    </div>

</div>
<div class="container">
    <div class="row mt-3 text-center mb-3">
        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>
            <a class="btn btn-primary" href="https://docs.google.com/document/d/1tDqAF7Z-3OBYn0S6oT52MKjJKYnMUUf_rnfldmddUZg/edit">Traditions Checklist</a>
        </div>
        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>
            <a class="btn btn-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSeFsa5KJgGmsV-ZmXBrVUxfhycM9aOpa63jg88Xuft5WNVJVg/viewform">Submit a Tradition</a>
        </div>
        <div class='col-sm-4 col-xs-12 mb-sm-0'>
            <a class="btn btn-primary" href="https://docs.google.com/document/d/1FGSsF1qlbQXGxbcnnd3-Qa1wJqbMtrpJ6RhZEGmUqgE/edit">Prizes and Tiers</a>
        </div>
    </div>
        <div>
            <h2>What is the Tradition Keepers program?</h2>
            <p>The Tradition Keepers program is a collaboration between the Ramblin' Reck Club and the Georgia Tech Alumni Association that aims to foster campus-wide participation in our cherished school traditions! By submitting photos as you and your friends complete various traditions and challenges, you can qualify for a number of different prizes and keep Tech traditions going strong.
            </p>
            <p></p>
        </div>

        <div>
            <h2>How can I participate?</h2>
            <p>Getting started is easy! All you have to do is participate in an eligible tradition and submit a photo of yourself completing it. Various rotating prizes are available for people who complete different numbers of traditions during their time at Tech. The list of eligible traditions, the form to submit your completed traditions, and a list of current prizes can be found at the top of this page.
            </p>
            <p></p>
        </div>

        <div>
            <h2>Who do I contact if I have a question or want to suggest including a new tradition?</h2>
            <p>For any questions or suggestions, send an email to <a href="mailto:rrctraditions@gmail.com?" style="color:#CBB57C">rrctraditions@gmail.com</a> and be sure to mention Tradition Keepers in the subject line. We are always looking to expand the list of traditions, so let us know if we missed any! Communications about when and where to pick up prizes will also come from this address.
            </p>
            <p></p>
        </div>

    <div>
        <footer>© Copyright <?php echo date('Y'); ?> Ramblin' Reck Club. All Rights Reserved.</footer>
    </div>
</div>

</body></html>