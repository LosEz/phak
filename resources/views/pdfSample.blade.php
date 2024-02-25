<!DOCTYPE html>
<html>
<head>
    <title>TCPDF</title>

    <style>
        body {
        background: rgb(204,204,204); 
        }
        page {
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        page[size="A4"] {  
        width: 21cm;
        height: 29.7cm; 
        }
        page[size="A4"][layout="portrait"] {
        width: 29.7cm;
        height: 21cm;  
        }
        @media print {
        body, page {
            margin: 0;
            box-shadow: 0;
        }
        }
    </style>
</head>
<body>
    <page size="A4">A4 
        <h1 style="color:red;">{!! $title !!}</h1>
    
        <br>

        <p>Your message here.</p>
    </page>
   

    <page size="A4" layout="portrait">A4 portrait

     <h1 style="color:red;">{!! $title !!}</h1>
 
    <br>

    <p>Your message here.</p>
    </page>
</body>
</html>