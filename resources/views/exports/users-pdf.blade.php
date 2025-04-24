<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>قائمة المستخدمين</title>
    <style>
        body {
            font-family: 'aealarabiya', sans-serif;
            direction: rtl;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            direction: rtl;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: right;
        }
        th { 
            background-color: #f2f2f2; 
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;">قائمة المستخدمين</h1>
    <table>
        <thead>
            <tr>
                <th>العنوان</th>
                <th>رقم البطاقة</th>
                <th>الهاتف</th>
                <th>الوظيفة</th>
                <th>اسم المستخدم</th>
                <th>الاسم</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->address }}</td>
                <td>{{ $user->national_id }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->getRoleNames()->first() }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->name_ar }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>