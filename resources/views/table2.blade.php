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
    <span><font style="font-weight:bold;">ตัวอย่างภาคผนวกเกษตรกร ประเภทปลอดภัย (ป)</font></span>
    <br/>
    <br/>
    @for($i = 0; $i < 3; $i++)

    <table cellspacing="0" cellpadding="3" border="1" nobr="true">
       <tr>
            <td>ชื่อวัตถุดิบ</td>
            <td>กะหล่ำปลีหัวใจ</td>
            <td rowspan="13" colspan="2">ภาพ: เกษตรกร</td>
       </tr>
       <tr>
            <td>แหล่งผลิต</td>
            <td>อำเภอเมืองปาน จังหวัดลำปาง</td>
       </tr>
       <tr>
            <td>มาตรฐาน GAP</td>
            <td>⃝ ได้รับ</td>
       </tr>
        <tr>
            <td></td>
            <td>⃝ กำลังดำเนินการ</td>
        </tr>
        <tr>
            <td></td>
            <td>⃝ ยังไม่ได้รับ</td>
        </tr>
        <tr>
            <td>อ้างอิงรหัสแปลง (ถ้ามี)</td>
            <td>520XXX-0200-XXXX</td>
        </tr>
        <tr>
            <td>วันที่ได้รับการรับรอง GAP</td>
            <td></td>
        </tr>
        <tr>
            <td>วันที่การรับรอง GAP หมดอายุ</td>
            <td></td>
        </tr>
        <tr>
            <td>ระบุปุ๋ย/สารเคมีที่ใช้</td>
            <td></td>
        </tr>
        <tr>
            <td>ขนาดแปลง</td>
            <td></td>
        </tr>
        <tr>
            <td>ความถี่</td>
            <td></td>
        </tr>
        <tr>
            <td>ที่มาของแหล่งน้ำที่ใช้</td>
            <td></td>
        </tr>
        <tr>
            <td>อ้างอิงรหัสแปลง (ถ้ามี)</td>
            <td>520XXX-0200-XXXX</td>
        </tr>
        <tr>
            <td width="25%">ที่มาของดินที่ใช้</td>
            <td width="25%"></td>
            <td width="15%">ชื่อเกษตรกร</td>
            <td width="35%"></td>
        </tr>
        <tr>
            <td rowspan="3" colspan="4">ที่มาของดินที่ <font color="#FFFFFF">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</font></td>
        </tr>
    </table>
    <br/>
    <br/>
    @endfor
</body>

