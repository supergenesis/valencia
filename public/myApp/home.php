<html>
    <head>
        <title>myApp by valencia</title>
    </head>
    <body>
        Welkom!<br />

        <ul>
        {{ for $title in $book.name }}
            <li>{{ $var = 1976; print $title }}</li>
        {{ endfor }}
        {{ $war = 40+ $var }}
        </ul>

    </body>
</html>