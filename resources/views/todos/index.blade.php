<!DOCTYPE html>
<html>
<head>
    <title>{{$todoList->title}}</title>
</head>
<body>
<h1>{{$todoList->title}}</h1>
<ul>
    @foreach($todoList->todos as $todo)
        <li>
            <h2>{{$todo->title}} {{$todo->complete ? '✅' : ''}}</h2>
            <p>{{$todo->description}}</p>
        </li>
    @endforeach
</ul>
</body>
</html>
