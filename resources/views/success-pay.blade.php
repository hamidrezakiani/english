<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div
      style="width: 100%;display: flex;flex-direction: column;justify-content: center;align-items: center;"
    >
         <h1 style="color: green;text-align: center;margin-top: 150px">پرداخت با موفقیت انجام شد</h1>
         <a href="{{env('APPLICATION')}}?pay=success" style="text-decoration: none;background-color: darkmagenta;color: #fff;border-radius: 10px;font-size: 18px;padding: 5px 10px;margin-top: 100px">بازگشت به برنامه</a>
    </div>
</body>
</html>