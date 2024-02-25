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
    <page size="A4">
    <h3>2. กรณีวัตถุดิบเป็นผัก-ผลไม้ ประเภทปลอดภัย (ป); ชี้แจงรายละเอียดผัก-ผลไม้ ปริมาณจัดส่ง วันที่จัดส่ง ระบุเกษตรกรผู้ผลิตและ แนบภาคผนวกท้ายซึ่งเป้นรายละเอียดที่เกี่ยวข้องกับการควบคุมการใช้สารเคมี และ/หรือมาตรฐาน GAP ที่ได้รับ
    </h3>
    <table cellspacing="0" cellpadding="3" border="1">
        <thead>
            <tr bgcolor="#323E4F" nobr="true">
                <th width="5%" style="text-indent:5px"></th>
                <th width="25%"><font color="#FFFFFF" style="font-weight: bold; font-size:14px;">รายละเอียด</font></th>
                <th width="10%"><font color="#FFFFFF" style="font-weight: bold; font-size:14px;">ปริมาณ</font></th>
                <th width="15%"><font color="#FFFFFF" style="font-weight: bold; font-size:14px;">หน่วย</font></th>
                <th width="25%"><font color="#FFFFFF" style="font-weight: bold; font-size:14px;">เกษตรกรผู้ผลิต</font></th>
                <th width="20%"><font color="#FFFFFF" style="font-weight: bold; font-size:14px;">วันที่จัดส่ง</font></th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < 50; $i++)
        <tr nobr="true">
            <td width="5%"  style="text-indent:5px">{{$i + 1}}</td>
            <td width="25%" style="text-indent:5px">กระหล่ำปลีหัวใจ (ป)</td>
            <td width="10%" style="text-indent:5px">1.0</td>
            <td width="15%" style="text-indent:5px">กิโลกรัม</td>
            <td width="25%" style="text-indent:5px">นายสุภาพ ประเสริฐ</td>
            <td width="20%" style="text-indent:5px">1 สิงหาคม 2566</td>
        </tr>
            @endfor
        </tbody>
    </table>


    <br/>

    <br/>



    <!--table border="1" cellspacing="3" cellpadding="4" >
        <tr>
            <th>#</th>
            <th align="right">RIGHT align</th>
            <th align="left">LEFT align</th>
            <th>4A</th>
        </tr>
        <tr>
            <td>1</td>
            <td bgcolor="#cccccc" align="center" colspan="2">A1 ex<i>amp</i>le <a href="http://www.tcpdf.org">link</a>
                column span. One two tree four five six seven eight nine ten.<br />line after br<br /><small>small
                    text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal bla bla bla bla bla bla
                bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla<ol>
                    <li>first<ol>
                            <li>sublist</li>
                            <li>sublist</li>
                        </ol>
                    </li>
                    <li>second</li>
                </ol><small color="#FF0000" bgcolor="#FFFF00">small small small small small small small small small small
                    small small small small small small small small small small</small></td>
            <td>4B</td>
        </tr>
        <tr>
            <td>
                <table border="1" cellspacing="6" cellpadding="4">
                    <tr>
                        <td>a</td>
                        <td>b</td>
                    </tr>
                    <tr>
                        <td>c</td>
                        <td>d</td>
                    </tr>
                </table>
            </td>
            <td bgcolor="#0000FF" color="yellow" align="center">A2 € &euro; &#8364; &amp; è &egrave;<br />A2 € &euro;
                &#8364; &amp; è &egrave;</td>
            <td bgcolor="#FFFF00" align="left">
                <font color="#FF0000">Red</font> Yellow BG
            </td>
            <td>4C</td>
        </tr>
        <tr>
            <td>1A</td>
            <td rowspan="2" colspan="2" bgcolor="#FFFFCC">2AA<br />2AB<br />2AC</td>
            <td bgcolor="#FF0000">4D</td>
        </tr>
        <tr>
            <td>1B</td>
            <td>4E</td>
        </tr>
        <tr>
            <td>1C</td>
            <td>2C</td>
            <td>3C</td>
            <td>4F</td>
        </tr>
    </table-->
    </page>
</body>

