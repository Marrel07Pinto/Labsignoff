@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
    <style>
        p {
            text-align: justify;
           }
    </style>
    <body>
        <main id="main" class="main">

            <div class="pagetitle">
                <h1>About lab</h1>
            </div><!-- End Page Title -->

            <section class="section">
            <p>A web application lab gives practical environment for students to develop and to test web applicatioin
                    technologies like Javascript,HTML,CSS and web application framework. It helps student to think about real life scenarios,
                    manage database, Build dynamic websites and security about web application. These labs gives practical knowege in 
                    creating, deploying and to build a good web application interaction and cybersecuritry.<p>
                <center><img src="/images/webapplication.jpg" alt="Web Application" width="300" height="300"></center>
                <br>
           <p>Web application is a program that runs on the internet, allowing user to interact with through web. Generally, software's are installed in the system but, 
            web application are accessed online. some of the web application are Facebook, Gmail, YouTube. They are easy to us because they don't need to download.<p>
            </section>
            </main>
    </body>
</html>
@endsection