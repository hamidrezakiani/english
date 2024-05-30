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
    style="width: 100%;display: flex;flex-direction: row;justify-content: center;align-items: center;padding-bottom: 150px"
  >
       <a href="{{url('failed-pay')}}" style="text-decoration: none;background-color: red;color: #fff;border-radius: 10px;font-size: 18px;padding: 5px 10px;margin: 20px">پرداخت نا موفق</a>
       <a href="{{url('success-pay/'.$orderId)}}" style="text-decoration: none;background-color: green;color: #fff;border-radius: 10px;font-size: 18px;padding: 5px 10px;margin:20px">پرداخت موفق</a>
  </div>
</body>
</html>